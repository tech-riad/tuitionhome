<?php

namespace App\Http\Controllers;

use App\Models\CareerPlan;
use App\Models\City;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\URL;

class CareerPlanController extends Controller
{
    private const DIVISION_DISTRICTS = [
        'Barishal' => ['Barguna', 'Barishal', 'Bhola', 'Jhalokati', 'Patuakhali', 'Pirojpur'],
        'Chattogram' => ['Bandarban', 'Brahmanbaria', 'Chandpur', 'Chittagong', "Cox's Bazar", 'Cumilla', 'Feni', 'Khagrachhari', 'Lakshmipur', 'Noakhali', 'Rangamati'],
        'Dhaka' => ['Dhaka', 'Faridpur', 'Gazipur', 'Gopalganj', 'Kishoreganj', 'Madaripur', 'Manikganj', 'Munshiganj', 'Narayanganj', 'Narsingdi', 'Rajbari', 'Savar', 'Shariatpur', 'Tangail'],
        'Khulna' => ['Bagerhat', 'Chuadanga', 'Jashore', 'Jhenaidah', 'Khulna', 'Kushtia', 'Magura', 'Meherpur', 'Narail', 'Satkhira'],
        'Mymensingh' => ['Jamalpur', 'Mymensingh', 'Netrokona', 'Sherpur'],
        'Rajshahi' => ['Bogura', 'Chapainawabganj', 'Joypurhat', 'Naogaon', 'Natore', 'Pabna', 'Rajshahi', 'Sirajganj'],
        'Rangpur' => ['Dinajpur', 'Gaibandha', 'Kurigram', 'Lalmonirhat', 'Nilphamari', 'Panchagarh', 'Rangpur', 'Thakurgaon'],
        'Sylhet' => ['Habiganj', 'Moulvibazar', 'Sunamganj', 'Sylhet'],
    ];

    private const JOB_CATEGORIES = [
        'Graphics/Video Editor',
        'Computer Operator/Data Entry Operator',
        'Accounts/Finance/Audit',
        'Garments - Production/Operator/Technician',
        'General Management/Admin',
        'Supply Chain/Procurement',
        'IT/Telecommunication',
        'Engineer',
        'Hospitality/ Travel/ Tourism',
        'Media/Advertisement/Event Mgt.',
        'Human Resource Management (HR)',
        'Accounts & Finance',
        'Restaurant staff',
        'Warehouse',
        'Construction',
        'Law/ Legal',
        'Healthcare/Medical/Hospital',
        'Office/Building Support',
        'Sales/Marketing',
        'Education/Training/Consultant',
        'Transportation',
        'Manufacturing',
        'Household',
        'Graphics',
        'Beautician/Salon Worker',
        'Technical',
        'Security/Support Service',
        'Management Staff',
    ];
    public function index()
    {
        $careerPlans = CareerPlan::query()
            // ->where('created_by', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(10);

        $areaIds = $careerPlans->getCollection()
            ->flatMap(function ($careerPlan) {
                return (array) ($careerPlan->form_data['area_ids'] ?? []);
            })
            ->unique()
            ->values();
        $areaNamesById = Location::query()->whereIn('id', $areaIds)->pluck('name', 'id');

        $careerPlans->getCollection()->transform(function ($careerPlan) use ($areaNamesById) {
            $data = $careerPlan->form_data ?? [];
            $data['area_names'] = collect($data['area_ids'] ?? [])
                ->map(function ($areaId) use ($areaNamesById) {
                    return $areaNamesById->get($areaId);
                })
                ->filter()
                ->values()
                ->all();
            $careerPlan->setAttribute('display_data', $data);
            $careerPlan->setAttribute('share_url', URL::signedRoute('career.share', [
                'careerPlan' => $careerPlan->id,
            ]));

            return $careerPlan;
        });

        return view('backend.career.index', compact('careerPlans'));
    }

    public function show(CareerPlan $careerPlan)
    {
        abort_unless((int) $careerPlan->created_by === (int) auth()->id(), 403);

        return $this->detailsView($careerPlan, false);
    }

    public function share(CareerPlan $careerPlan)
    {
        abort_unless($careerPlan->status === 'published', 404);

        return $this->detailsView($careerPlan, true);
    }

    public function updateStatus(Request $request, CareerPlan $careerPlan)
    {
        abort_unless((int) $careerPlan->created_by === (int) $request->user()->id, 403);

        $validated = $request->validate([
            'status' => ['required', Rule::in(['published', 'closed'])],
        ]);

        $careerPlan->update(['status' => $validated['status']]);

        return redirect()
            ->route('admin.career.index')
            ->with('success', $validated['status'] === 'published'
                ? 'Job is now on and visible.'
                : 'Job is now off and hidden from shared views.');
    }

    private function detailsView(CareerPlan $careerPlan, bool $shared)
    {
        $data = $careerPlan->form_data ?? [];
        $data['area_names'] = Location::query()
            ->whereIn('id', $data['area_ids'] ?? [])
            ->orderBy('name')
            ->pluck('name')
            ->all();

        return view('backend.career.show', [
            'careerPlan' => $careerPlan,
            'data' => $data,
            'shared' => $shared,
        ]);
    }

    public function create()
    {
        
        $districtDivisions = [];
        foreach (self::DIVISION_DISTRICTS as $division => $districts) {
            foreach ($districts as $district) {
                $districtDivisions[$district] = $division;
            }
        }

        $cities = City::query()
            ->whereIn('name', array_keys($districtDivisions))
            ->get(['id', 'name']);
        $divisionByCityId = [];
        foreach ($cities as $city) {
            $divisionByCityId[$city->id] = $districtDivisions[$city->name];
        }

        $areas = Location::query()
            ->whereIn('city_id', $cities->pluck('id'))
            ->orderBy('name')
            ->get();
        foreach ($areas as $area) {
            $area->division_name = $divisionByCityId[$area->city_id];
        }

        return view('backend.career.create', [
            'jobCategories' => self::JOB_CATEGORIES,
            'divisions' => array_keys(self::DIVISION_DISTRICTS),
            'areas' => $areas,
        ]);
    }

    public function store(Request $request)
    {
        $divisionNames = (array) $request->input('division_names', []);
        $districtNames = [];
        foreach ($divisionNames as $divisionName) {
            $districtNames = array_merge($districtNames, self::DIVISION_DISTRICTS[$divisionName] ?? []);
        }
        $cityIds = City::query()->whereIn('name', $districtNames)->pluck('id');

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:125'],
            'application_deadline' => ['required', 'date', 'after_or_equal:today'],
            'vacancies' => ['required', 'integer', 'min:1', 'max:100'],
            'job_category' => ['required', 'string', Rule::in(self::JOB_CATEGORIES)],
            'salary_min' => ['required', 'integer', 'min:1000', 'max:500000'],
            'salary_max' => ['required', 'integer', 'gte:salary_min', 'max:500000'],
            'responsibilities' => ['required', 'string', 'max:10000'],
            'location_type' => ['required', Rule::in(['local', 'overseas'])],
            'division_names' => ['required', 'array', 'min:1', 'max:5'],
            'division_names.*' => ['required', 'string', Rule::in(array_keys(self::DIVISION_DISTRICTS))],
            'area_ids' => ['required', 'array', 'min:1', 'max:5'],
            'area_ids.*' => [
                'integer',
                Rule::exists('locations', 'id')->where(function ($query) use ($cityIds) {
                    $query->whereIn('city_id', $cityIds);
                }),
            ],
            'department' => ['nullable', 'string', 'max:255'],
            'employment_type' => ['nullable', 'string', 'max:100'],
            'workplace_type' => ['nullable', 'string', 'max:100'],
            'benefits' => ['nullable', 'string', 'max:1000'],
            'company_website' => ['nullable', 'url', 'max:255'],
            'gender' => ['required', Rule::in(['both', 'male', 'female', 'other'])],
            'cv_required' => ['required', 'boolean'],
            'education' => ['required', 'string', 'max:100'],
            'experience' => ['required', 'string', 'max:100'],
            'age_min' => ['required', 'integer', 'min:14', 'max:70'],
            'age_max' => ['required', 'integer', 'gte:age_min', 'max:70'],
            'requirements' => ['nullable', 'string', 'max:10000'],
            'matching_criteria' => ['nullable', 'array'],
            'matching_criteria.*' => [Rule::in(['education', 'experience', 'skills', 'location', 'age', 'gender'])],
            'questions' => ['required', 'array', 'min:1'],
            'questions.*.question' => ['required', 'string', 'max:1000'],
            'questions.*.type' => ['required', Rule::in(['text', 'textarea', 'yes_no', 'single_choice', 'multiple_choice', 'number'])],
            'questions.*.required' => ['nullable', 'boolean'],
            'questions.*.options' => ['nullable', 'array'],
            'questions.*.options.*' => ['nullable', 'string', 'max:255'],
            'vacancies_open' => ['nullable', 'boolean'],
            'salary_negotiable' => ['nullable', 'boolean'],
        ]);

        foreach ($validated['questions'] as $index => $question) {
            if (in_array($question['type'], ['single_choice', 'multiple_choice'], true)) {
                $options = array_filter((array) ($question['options'] ?? []), function ($option) {
                    return is_string($option) && trim($option) !== '';
                });

                if (count($options) < 2) {
                    return back()
                        ->withErrors(["questions.{$index}.options" => 'Choice questions need at least two answer options.'])
                        ->withInput();
                }
            }
        }

        $validated['vacancies_open'] = $request->boolean('vacancies_open');
        $validated['salary_negotiable'] = $request->boolean('salary_negotiable');
        $validated['matching_criteria'] = $validated['matching_criteria'] ?? [];
        $validated['questions'] = $validated['questions'] ?? [];
        $validated['division_names'] = $validated['division_names'] ?? [];
        $validated['area_ids'] = $validated['area_ids'] ?? [];

        CareerPlan::create([
            'created_by' => $request->user()->id,
            'title' => $validated['title'],
            'status' => 'published',
            'form_data' => $validated,
        ]);

        return redirect()
            ->route('admin.career.index')
            ->with('success', 'Job posted successfully.');
    }
}
