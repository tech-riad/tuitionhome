<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Http\Controllers\Controller;
use App\Models\CareerApplication;
use App\Models\CareerPlan;
use App\Models\Location;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;

class CareerController extends Controller
{
    private const DIVISIONS = [
        'Barishal',
        'Chattogram',
        'Dhaka',
        'Khulna',
        'Mymensingh',
        'Rajshahi',
        'Rangpur',
        'Sylhet',
    ];

    public function index(Request $request)
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:125'],
            'division' => ['nullable', 'string', Rule::in(self::DIVISIONS)],
            'area_id' => ['nullable', 'integer', 'exists:locations,id'],
            'employment_type' => ['nullable', 'string', 'max:100'],
            'workplace_type' => ['nullable', 'string', 'max:100'],
            'gender' => ['nullable', Rule::in(['both', 'male', 'female', 'other'])],
            'education' => ['nullable', 'string', 'max:100'],
            'experience' => ['nullable', 'string', 'max:100'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);

        $query = CareerPlan::query()
            ->where('status', 'published')
            ->orderByDesc('created_at');

        if (!empty($filters['search'])) {
            $search = trim($filters['search']);
            $query->where('title', 'like', '%' . $search . '%');
        }

        if (!empty($filters['category'])) {
            $this->whereJsonStringEquals($query, 'job_category', $filters['category']);
        }

        if (!empty($filters['division'])) {
            $query->whereJsonContains('form_data->division_names', $filters['division']);
        }

        if (!empty($filters['area_id'])) {
            $query->whereJsonContains('form_data->area_ids', (int) $filters['area_id']);
        }

        foreach (['employment_type', 'workplace_type', 'gender', 'education', 'experience'] as $field) {
            if (!empty($filters[$field])) {
                $this->whereJsonStringEquals($query, $field, $filters[$field]);
            }
        }

        $careerPlans = $query->paginate($filters['per_page'] ?? 12);
        $data = $this->mapCareerPlans($careerPlans->getCollection());

        return response()->json([
            'data' => $data,
            'meta' => [
                'current_page' => $careerPlans->currentPage(),
                'per_page' => $careerPlans->perPage(),
                'last_page' => $careerPlans->lastPage(),
                'total' => $careerPlans->total(),
            ],
            'links' => [
                'first' => $careerPlans->url(1),
                'last' => $careerPlans->url($careerPlans->lastPage()),
                'previous' => $careerPlans->previousPageUrl(),
                'next' => $careerPlans->nextPageUrl(),
            ],
        ]);
    }

    public function show(CareerPlan $careerPlan)
    {
        abort_unless($careerPlan->status === 'published', 404);

        return response()->json([
            'data' => $this->mapCareerPlan($careerPlan),
        ]);
    }

    public function apply(Request $request, CareerPlan $careerPlan)
    {
        $application = DB::transaction(function () use ($request, $careerPlan) {
            $careerPlan = CareerPlan::query()
                ->whereKey($careerPlan->id)
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless($careerPlan->status === 'published', 404);

            $tutorId = $request->user('t-api')->getAuthIdentifier();
            $application = CareerApplication::query()
                ->where('career_plan_id', $careerPlan->id)
                ->where('tutor_id', $tutorId)
                ->first();

            if ($application) {
                return null;
            }

            return CareerApplication::create([
                'career_plan_id' => $careerPlan->id,
                'tutor_id' => $tutorId,
                'status' => 'pending',
            ]);
        });

        if ($application === null) {
            return response()->json([
                'message' => 'You have already applied for this job.',
            ], 409);
        }

        return response()->json([
            'message' => 'Application submitted successfully.',
            'data' => [
                'id' => $application->id,
                'career_plan_id' => $application->career_plan_id,
                'tutor_id' => $application->tutor_id,
                'status' => $application->status,
                'applied_at' => $application->created_at->toIso8601String(),
            ],
        ], 201);
    }

    private function mapCareerPlans($careerPlans)
    {
        $areaIds = $careerPlans
            ->flatMap(function ($careerPlan) {
                return (array) (($careerPlan->form_data ?? [])['area_ids'] ?? []);
            })
            ->unique()
            ->values();

        $areasById = Location::query()
            ->whereIn('id', $areaIds)
            ->get(['id', 'name'])
            ->keyBy('id');

        return $careerPlans
            ->map(function ($careerPlan) use ($areasById) {
                return $this->mapCareerPlan($careerPlan, $areasById);
            })
            ->values();
    }

    private function mapCareerPlan(CareerPlan $careerPlan, $areasById = null)
    {
        $formData = $careerPlan->form_data ?? [];

        if ($areasById === null) {
            $areasById = Location::query()
                ->whereIn('id', $formData['area_ids'] ?? [])
                ->get(['id', 'name'])
                ->keyBy('id');
        }

        $areas = collect($formData['area_ids'] ?? [])
            ->map(function ($areaId) use ($areasById) {
                $area = $areasById->get($areaId);

                return $area ? [
                    'id' => (int) $area->id,
                    'name' => $area->name,
                ] : null;
            })
            ->filter()
            ->values();

        return [
            'id' => $careerPlan->id,
            'title' => $careerPlan->title,
            'status' => $careerPlan->status,
            'posted_at' => optional($careerPlan->created_at)->toIso8601String(),
            'job_information' => [
                'category' => $formData['job_category'] ?? null,
                'department' => $formData['department'] ?? null,
                'application_deadline' => $formData['application_deadline'] ?? null,
                'vacancies' => isset($formData['vacancies']) ? (int) $formData['vacancies'] : null,
                'vacancies_open' => (bool) ($formData['vacancies_open'] ?? false),
                'salary' => [
                    'min' => isset($formData['salary_min']) ? (int) $formData['salary_min'] : null,
                    'max' => isset($formData['salary_max']) ? (int) $formData['salary_max'] : null,
                    'negotiable' => (bool) ($formData['salary_negotiable'] ?? false),
                ],
                'location_type' => $formData['location_type'] ?? null,
                'divisions' => $formData['division_names'] ?? [],
                'areas' => $areas,
                'employment_type' => $formData['employment_type'] ?? null,
                'workplace_type' => $formData['workplace_type'] ?? null,
                'benefits' => $formData['benefits'] ?? null,
                'company_website' => $formData['company_website'] ?? null,
            ],
            'responsibilities' => $this->plainText($formData['responsibilities'] ?? ''),
            'candidate_requirements' => [
                'gender' => $formData['gender'] ?? null,
                'cv_required' => (bool) ($formData['cv_required'] ?? false),
                'education' => $formData['education'] ?? null,
                'experience' => $formData['experience'] ?? null,
                'age_min' => isset($formData['age_min']) ? (int) $formData['age_min'] : null,
                'age_max' => isset($formData['age_max']) ? (int) $formData['age_max'] : null,
                'description' => $this->plainText($formData['requirements'] ?? ''),
                'matching_criteria' => $formData['matching_criteria'] ?? [],
            ],
            'questions' => $formData['questions'] ?? [],
            'share_url' => URL::signedRoute('career.share', ['careerPlan' => $careerPlan->id]),
        ];
    }

    private function plainText($content)
    {
        $content = preg_replace('/<\/(p|div|li|h[1-6])>/i', "\n", $content);
        $content = preg_replace('/<br\s*\/?>/i', "\n", $content);

        return trim(html_entity_decode(strip_tags($content), ENT_QUOTES, 'UTF-8'));
    }

    private function whereJsonStringEquals(Builder $query, $field, $value)
    {
        return $query->whereRaw(
            "CAST(JSON_UNQUOTE(JSON_EXTRACT(form_data, ?)) AS CHAR CHARACTER SET utf8) COLLATE utf8_unicode_ci = ?",
            ['$.' . $field, $value]
        );
    }
}
