<?php

namespace App\Http\Controllers\Frontend\Api\JobOffer;

use App\Http\Controllers\Controller;
use App\Interfaces\JobOfferServiceInterface;
use App\Models\Bookmark;
use App\Models\JobApplication;
use App\Models\JobOffer;
use App\Models\LeadSource;
use App\Models\Tutor;
use App\Traits\ApiResponse;
use App\Transformers\JobOfferResource;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class JobofferController extends Controller
{
    use ApiResponse;
    private $jobOfferRepository;
    public function __construct(JobOfferServiceInterface $jobOfferRepository)
    {
        $this->jobOfferRepository = $jobOfferRepository;

    }
    
    public function jobFilterSalary(Request $request)
    {

        $salaryRange       = $request->input('salary');
        $perPage = $request->input('per_page', 12);

        // dd($diw);

        $query = JobOffer::where('is_active', 1);


        $minSalary = null;
        $maxSalary = null;

        if ($salaryRange !== null) {
            list($minSalary, $maxSalary) = explode('-', $salaryRange);
            $minSalary = (int) trim($minSalary);
            $maxSalary = (int) trim($maxSalary);

            if ($minSalary > 0 && $maxSalary > 0) {
                $query->whereBetween('salary', [$minSalary, $maxSalary]);
            }
        }

        $jobOffers = $query->orderBy('id','desc')->paginate($perPage);

        $paginationMeta = [
            'current_page' => $jobOffers->currentPage(),
            'per_page' => $jobOffers->perPage(),
            'total' => $jobOffers->total(),
        ];
        return $this->resposeSuccess('data get successfully', [
            'job_offers' => JobOfferResource::collection($jobOffers),
            'paginationMeta' => $paginationMeta,
            'request_data' => $request->all(),
        ]);
    }
    public function getJobOffer(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 12);
            $cityId  = $request->input('city_id');

            if($cityId == null){
                $jobOffers = $this->jobOfferRepository->all()->paginate($perPage);

                $totalJobOffers = $this->jobOfferRepository->all()->count();

            }else{

                $jobOffers = $this->jobOfferRepository->all()->where('city_id',$cityId)->paginate($perPage);
                $totalJobOffers = $this->jobOfferRepository->all()->where('city_id', $cityId)->count();

            }

            $paginationMeta = [
                'current_page' => $jobOffers->currentPage(),
                'per_page' => $jobOffers->perPage(),
                'total' => $jobOffers->total(),
                'cityId' => $cityId,
                'totalJobOffers' => $totalJobOffers,
            ];

            return $this->resposeSuccess('data get successfully', [
                'job_offers' => JobOfferResource::collection($jobOffers),
                'meta' => $paginationMeta,
            ]);
        } catch (Exception $e) {
            return $this->resposeError('', $e->getMessage());
        }
    }


    // public function apply_to_job_offer(Request $request, $id=null){

    //     $id = $request->id;

    //    $dubliChecker = auth()->user()->tutor->job_applications()->where('job_offer_id', '=', $id)->first();

    //    if ($dubliChecker != null) {
    //    		return redirect()->back()->with('error','Already applied to the job offer');
    //     }


    //     JobApplication::create([
    //         'job_offer_id'=>$id,
    //         'tutor_id'=>auth()->user()->tutor->id,
    //     ]);
    // 	return response()->json(['message' => 'Your Boj Appllied successfully done...'], 200);

    // }


    public function jobDetails($id)
    {
        try {
            $jobDetails = new JobOfferResource($this->jobOfferRepository->single($id)->first());

            $job = JobOffer::find($id);
            $job->increment('job_views');
            $job->save();

            $appliedTutorIds = JobApplication::where('job_offer_id', $id)->pluck('tutor_id')->toArray();



            $tutors = [];
            foreach ($appliedTutorIds as $tutorId) {
                $tutors[] = ['tutor_id' => $tutorId];
            }

            $bookmarkTutorIds = Bookmark::whereNotNull('tutor_id')
                ->where('target_id', $id)
                ->pluck('tutor_id')
                ->toArray();
            

            $bookmarkTutors = array_map(function ($tutorId) {
                return ['tutor_id' => $tutorId];
            }, $bookmarkTutorIds);
            
            $response = [
                'jobDetails' => $jobDetails,
                'appliedTutorIds' => $tutors,
                'bookmarkTutorIds' => $bookmarkTutors, // ✅ fixed this line
            ];

            return $this->resposeSuccess('Data retrieved successfully', $response);
        } catch (Exception $e) {
            return $this->resposeError('', $e->getMessage());
        }
    }

    public function jobSearch(Request $request)
    {
        $jobOffers = $this->jobOfferRepository->all()->where('id',$request->job_id)->get();


        return $this->resposeSuccess('data get successfully', [
            'job_offers' => JobOfferResource::collection($jobOffers),
        ]);
    }

    // public function jobFilter(Request $request)
    // {
    //     $catf              = $request->input('catf');
    //     $catt              = $request->input('catt');
    //     $country_id        = $request->input('country_id');
    //     $city_id           = $request->input('city_id');
    //     $location_id       = $request->input('location_id');
    //     $category_id       = $request->input('category_id');
    //     $course_id         = $request->input('course_id');
    //     $subject_id        = $request->input('subject_id');
    //     $tutor_gender      = $request->input('tutor_gender');
    //     $student_gender    = $request->input('student_gender');
    //     $diw               = $request->input('diw');
    //     $salaryRange       = $request->input('salary');
    //     $t_method          = $request->input('t_method');
    //     $t_duration        = $request->input('t_duration');

    //     $perPage = $request->input('per_page', 12);

    //     // dd($diw);

    //     $query = JobOffer::where('is_active', 1);

    //     if ($catf !== null) {
    //         $query->whereDate('job_offers.created_at', '>=', Carbon::parse($catf)->startOfDay());
    //     }

    //     if ($catt !== null) {
    //         $query->whereDate('job_offers.created_at', '<=', Carbon::parse($catt)->endOfDay());
    //     }
    //     if ($country_id !== null) {
    //         $query->where('country_id',$country_id);
    //     }
    //     if ($city_id !== null) {
    //         $query->where('city_id',$city_id);
    //     }
    //     if ($location_id !== null) {
    //         $query->where('location_id',$location_id);
    //     }
    //     if ($category_id !== null) {
    //         $query->where('category_id',$category_id);
    //     }
    //     if ($course_id !== null) {
    //         $query->where('course_id',$course_id);
    //     }


    //     if ($subject_id !== null) {
    //         $subjectIdsArray = Arr::wrap(explode(',', $subject_id));
    //         $query->join('job_offer_student_subjects', 'job_offers.id', '=', 'job_offer_student_subjects.job_id')
    //           ->whereIn('job_offer_student_subjects.subject_id', $subjectIdsArray);
    //     }

    //     if ($tutor_gender !== null) {
    //         $query->where('tutor_gender',$tutor_gender);
    //     }
    //     if ($student_gender !== null) {
    //         $query->where('student_gender',$student_gender);
    //     }
    //     if ($diw !== null) {
    //         $query->where('days_in_week',$diw);
    //     }
    //     $minSalary = null;
    //     $maxSalary = null;

    //     if ($salaryRange !== null) {
    //         list($minSalary, $maxSalary) = explode('-', $salaryRange);
    //         $minSalary = (int) trim($minSalary);
    //         $maxSalary = (int) trim($maxSalary);

    //         if ($minSalary > 0 && $maxSalary > 0) {
    //             $query->whereBetween('salary', [$minSalary, $maxSalary]);
    //         }
    //     }


    //     if ($t_method !== null) {
    //         $query->where('teaching_method_id',$t_method);
    //     }
    //     if ($t_duration !== null) {
    //         $query->where('tutoring_duration',$t_duration);
    //     }
    //     if ($lat && $lon && $distance !== null) {

    //         $query->selectRaw("
    //             job_offers.*,
    //             (
    //                 6371 * acos(
    //                     cos(radians(?))
    //                     * cos(radians(lat))
    //                     * cos(radians(long) - radians(?))
    //                     + sin(radians(?))
    //                     * sin(radians(lat))
    //                 )
    //             ) AS distance
    //         ", [$lat, $lon, $lat])
        
    //         ->having('distance', '<=', $distance)
    //         ->orderBy('distance', 'asc');
    //     }

    //     $jobOffers = $query->orderBy('id','desc')->paginate($perPage);

    //     $paginationMeta = [
    //         'current_page' => $jobOffers->currentPage(),
    //         'per_page' => $jobOffers->perPage(),
    //         'total' => $jobOffers->total(),
    //     ];





    //     return $this->resposeSuccess('data get successfully', [
    //         'job_offers' => JobOfferResource::collection($jobOffers),
    //         'paginationMeta' => $paginationMeta,
    //         'request_data' => $request->all(),
    //     ]);
    // }
    
    public function jobFilter(Request $request)
{
    $catf              = $request->input('catf');
    $catt              = $request->input('catt');
    $country_id        = $request->input('country_id');
    $city_id           = $request->input('city_id');
    $location_id       = $request->input('location_id');
    $category_id       = $request->input('category_id');
    $course_id         = $request->input('course_id');
    $subject_id        = $request->input('subject_id');
    $tutor_gender      = $request->input('tutor_gender');
    $student_gender    = $request->input('student_gender');
    $diw               = $request->input('diw');
    $salaryRange       = $request->input('salary');
    $t_method          = $request->input('t_method');
    $t_duration        = $request->input('t_duration');

    // Nearby filter
    $lat               = $request->input('lat');
    $lon               = $request->input('lon');
    $distance          = $request->input('distance');

    $perPage = $request->input('per_page', 12);

    $query = JobOffer::query()
        ->where('is_active', 1);

    /*
    |--------------------------------------------------------------------------
    | Date Filter
    |--------------------------------------------------------------------------
    */

    if ($catf !== null) {
        $query->whereDate(
            'job_offers.created_at',
            '>=',
            Carbon::parse($catf)->startOfDay()
        );
    }

    if ($catt !== null) {
        $query->whereDate(
            'job_offers.created_at',
            '<=',
            Carbon::parse($catt)->endOfDay()
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Basic Filters
    |--------------------------------------------------------------------------
    */

    if ($country_id !== null) {
        $query->where('country_id', $country_id);
    }

    if ($city_id !== null) {
        $query->where('city_id', $city_id);
    }

    if ($location_id !== null) {
        $query->where('location_id', $location_id);
    }

    if ($category_id !== null) {
        $query->where('category_id', $category_id);
    }

    if ($course_id !== null) {
        $query->where('course_id', $course_id);
    }

    /*
    |--------------------------------------------------------------------------
    | Subject Filter
    |--------------------------------------------------------------------------
    */

    if ($subject_id !== null) {

        $subjectIdsArray = Arr::wrap(explode(',', $subject_id));

        $query->join(
            'job_offer_student_subjects',
            'job_offers.id',
            '=',
            'job_offer_student_subjects.job_id'
        )
        ->whereIn(
            'job_offer_student_subjects.subject_id',
            $subjectIdsArray
        );

        $query->distinct();
    }

    /*
    |--------------------------------------------------------------------------
    | Gender & Days Filter
    |--------------------------------------------------------------------------
    */

    if ($tutor_gender !== null) {
        $query->where('tutor_gender', $tutor_gender);
    }

    

    if ($diw !== null) {
        $query->where('days_in_week', $diw);
    }

    /*
    |--------------------------------------------------------------------------
    | Salary Filter
    |--------------------------------------------------------------------------
    */

    if ($salaryRange !== null) {

        list($minSalary, $maxSalary) = explode('-', $salaryRange);

        $minSalary = (int) trim($minSalary);
        $maxSalary = (int) trim($maxSalary);

        if ($minSalary > 0 && $maxSalary > 0) {

            $query->whereBetween('salary', [
                $minSalary,
                $maxSalary
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Teaching Method & Duration
    |--------------------------------------------------------------------------
    */

    if ($t_method !== null) {
        $query->where('teaching_method_id', $t_method);
    }

    if ($t_duration !== null) {
        $query->where('tutoring_duration', $t_duration);
    }

    /*
    |--------------------------------------------------------------------------
    | Nearby Location Filter
    |--------------------------------------------------------------------------
    */

    if ($lat !== null && $lon !== null && $distance !== null) {

        $query->selectRaw("
            job_offers.*,
            (
                6371 * acos(
                    cos(radians(?))
                    * cos(radians(lat))
                    * cos(
                        radians(`long`) - radians(?)
                    )
                    + sin(radians(?))
                    * sin(radians(lat))
                )
            ) AS distance
        ", [$lat, $lon, $lat])

        ->having('distance', '<=', $distance)
        ->orderBy('distance', 'desc');

        $jobOffers = $query->paginate($perPage);

    } else {

        $jobOffers = $query
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | Pagination Meta
    |--------------------------------------------------------------------------
    */

    $paginationMeta = [
        'current_page' => $jobOffers->currentPage(),
        'per_page'     => $jobOffers->perPage(),
        'total'        => $jobOffers->total(),
        'last_page'    => $jobOffers->lastPage(),
    ];

    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    return $this->resposeSuccess('data get successfully', [
        'job_offers'    => JobOfferResource::collection($jobOffers),
        'paginationMeta'=> $paginationMeta,
        'request_data'  => $request->all(),
    ]);
}

    public function jobExtraInfo($id)
    {
        $jobOffer = Joboffer::where('id',$id)->first();

        $sourceInfo = LeadSource::where('job_id', $id)->first();

        if ($sourceInfo) {
            if($sourceInfo->source_name == 'Parent Fnf Lead')
            {
                $sourceInfo = 'Fnf';
            }else{
                $sourceInfo = 'Myself';
            }

        } else {
            $sourceInfo = 'Myself';
        }
        $allAppliedTutor = [];
        $appliedTutorIds = JobApplication::where('job_offer_id', $id)->pluck('tutor_id')->take('10')->toArray();

        if (!empty($appliedTutorIds)) {
            $tutors = Tutor::with([
                'tutor_education.institutes',
                'tutor_personal_info',
                'tutor_prefered_locations.city',
            ])->whereIn('id', $appliedTutorIds)->get();

            $tutorData = $tutors->map(function ($tutor) {
                $tutorEducationHonours = $tutor->tutor_education->firstWhere('degree_name', 'honours');
                $tutorEducationHSC = $tutor->tutor_education->firstWhere('degree_name', 'hsc');

                return [
                    'id'               => $tutor->id,
                    'unique_id'        => $tutor->unique_id,
                    'tutor_image'      => $tutor->image,
                    'tutor_name'       => $tutor->name,
                    'tutor_gender'     => $tutor->gender,
                    'is_premium'       => $tutor->is_premium,
                    'is_premium_pro'   => $tutor->is_premium_pro,
                    'is_premium_advance' => $tutor->is_premium_advance,
                    'is_boost'         => $tutor->is_boost,
                    'is_verified'      => $tutor->is_verified,
                    'is_featured'      => $tutor->is_featured,
                    'tutor_location'   => $tutor->tutor_prefered_locations->first()->city->name ?? null,
                    'tutor_university' => $tutorEducationHonours->institutes->title ?? null,
                    'tutor_college'    => $tutorEducationHSC->institutes->title ?? null,
                ];
            });

            $allAppliedTutor = $tutorData->toArray();
        }


        // Suggested Tutor

        $job_offer = JobOffer::with([
            'job_offer_tutor_universities',
            'job_offer_tutor_departments',
            'job_offer_tutor_study_types',
        ])->findOrFail($id);

        $tutor_university = $job_offer->job_offer_tutor_universities->pluck('id')->implode(',');
        $tutor_department = $job_offer->job_offer_tutor_departments->pluck('id')->implode(',');
        $tutor_study = $job_offer->job_offer_tutor_study_types->pluck('id')->implode(',');

        $cacheKey = "tutors_ids_for_job_offer_{$job_offer->id}";

        // Cache tutor IDs for 12 hours
        $tutors_ids = Cache::remember($cacheKey, now()->addHours(12), function () use ($job_offer, $tutor_university, $tutor_department, $tutor_study) {
            return Tutor::with(['tutor_personal_info', 'tutor_education', 'tutor_prefered_locations'])
                ->when($job_offer->tutor_gender !== 'any', function ($query) use ($job_offer) {
                    $query->where('gender', $job_offer->tutor_gender);
                })
                ->whereHas('tutor_personal_info', function ($query) use ($job_offer) {
                    $query->where('country_id', $job_offer->country_id)
                        ->when(!empty($job_offer->city_id), function ($query) use ($job_offer) {
                            $query->where('city_id', $job_offer->city_id);
                        })
                        ->when(!empty($job_offer->tutor_religion), function ($query) use ($job_offer) {
                            $query->where('religion', $job_offer->tutor_religion);
                        });
                })
                ->when(!empty($job_offer->location_id), function ($query) use ($job_offer) {
                    $query->whereHas('tutor_prefered_locations', function ($subQuery) use ($job_offer) {
                        $subQuery->where('location_id', $job_offer->location_id);
                    });
                })
                ->when(!empty($job_offer->tutor_group), function ($query) use ($job_offer) {
                    $query->whereHas('tutor_education', function ($subQuery) use ($job_offer) {
                        $subQuery->where(function ($subSubQuery) use ($job_offer) {
                            $subSubQuery->where('group_or_major', $job_offer->tutor_group)
                                ->where('degree_name', 'ssc');
                        })->orWhere(function ($subSubQuery) use ($job_offer) {
                            $subSubQuery->where('group_or_major', $job_offer->tutor_group)
                                ->where('degree_name', 'hsc');
                        });
                    });
                })
                ->when(!empty($tutor_university), function ($query) use ($tutor_university) {
                    $query->whereHas('tutor_education', function ($subQuery) use ($tutor_university) {
                        $subQuery->whereIn('institute_id', explode(',', $tutor_university))
                            ->where('degree_name', 'honours');
                    });
                })
                ->when(!empty($job_offer->tutor_university_type), function ($query) use ($job_offer) {
                    $query->whereHas('tutor_education', function ($subQuery) use ($job_offer) {
                        $subQuery->whereIn('university_type', explode(',', $job_offer->tutor_university_type))
                            ->where('degree_name', 'honours');
                    });
                })
                ->when(!empty($tutor_department), function ($query) use ($tutor_department) {
                    $query->whereHas('tutor_education', function ($subQuery) use ($tutor_department) {
                        $subQuery->whereIn('department_id', explode(',', $tutor_department))
                            ->where('degree_name', 'honours');
                    });
                })
                ->when(!empty($tutor_study), function ($query) use ($tutor_study) {
                    $query->whereHas('tutor_education', function ($subQuery) use ($tutor_study) {
                        $subQuery->whereIn('study_type_id', explode(',', $tutor_study))
                            ->where('degree_name', 'honours');
                    });
                })
                ->when(!empty($job_offer->tutor_curriculam_id), function ($query) use ($job_offer) {
                    $query->whereHas('tutor_education', function ($subQuery) use ($job_offer) {
                        $subQuery->where('curriculum_id', $job_offer->tutor_curriculam_id);
                    });
                })
                ->orderByRaw('
                    CASE
                        WHEN is_boost = 1 AND boost_package = 1 AND boost_date >= CURDATE() - INTERVAL 15 DAY THEN 1
                        WHEN is_boost = 1 AND boost_package = 3 AND boost_date >= CURDATE() - INTERVAL 30 DAY THEN 1
                        WHEN is_boost = 1 AND boost_package = 6 AND boost_date >= CURDATE() - INTERVAL 60 DAY THEN 1
                        WHEN is_boost = 1 AND boost_package = 12 AND boost_date >= CURDATE() - INTERVAL 90 DAY THEN 1

                        WHEN is_premium_advance = 1 AND premium_date >= CURDATE() - INTERVAL 45 DAY THEN 2
                        WHEN is_premium_pro = 1 AND premium_date >= CURDATE() - INTERVAL 20 DAY THEN 3
                        ELSE 4
                    END ASC,
                    premium_date DESC,
                    boost_date DESC,
                    is_boost DESC,
                    is_premium_advance DESC,
                    is_premium_pro DESC,
                    is_premium DESC,
                    id DESC,
                    RAND()
                ')
                ->pluck('id')
                ->take(20);
        });

        // Fetch tutor data if tutor IDs are retrieved
        $tutorData = [];
        if ($tutors_ids->isNotEmpty()) {
            $tutors = Tutor::whereIn('id', $tutors_ids)
                ->with(['tutor_education.institutes', 'tutor_personal_info', 'tutor_prefered_locations.city'])
                ->get();

            $tutorData = $tutors->map(function ($tutor) {
                $tutorEducationHonours = $tutor->tutor_education->firstWhere('degree_name', 'honours');
                $tutorEducationHSC = $tutor->tutor_education->firstWhere('degree_name', 'hsc');

                return [
                    'id'               => $tutor->id,
                    'unique_id'        => $tutor->unique_id,
                    'tutor_image'      => $tutor->image,
                    'tutor_name'       => $tutor->name,
                    'tutor_gender'     => $tutor->gender,
                    'is_premium'       => $tutor->is_premium,
                    'is_premium_pro'   => $tutor->is_premium_pro,
                    'is_premium_advance' => $tutor->is_premium_advance,
                    'is_boost'         => $tutor->is_boost,
                    'is_verified'      => $tutor->is_verified,
                    'is_featured'      => $tutor->is_featured,
                    'tutor_location'   => $tutor->tutor_prefered_locations->first()->city->name ?? null,
                    'tutor_university' => $tutorEducationHonours->institutes->title ?? null,
                    'tutor_college'    => $tutorEducationHSC->institutes->title ?? null,
                ];
            });
        }



        return $this->resposeSuccess('data get successfully', [
            'sourceInfo' => $sourceInfo,
            'allAppliedTutor' => $allAppliedTutor,
            'suggestedTutor' => $tutorData,

        ]);
    }





}