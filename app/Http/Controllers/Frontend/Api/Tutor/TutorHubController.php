<?php

namespace App\Http\Controllers\Frontend\Api\Tutor;

use App\Http\Controllers\Controller;
use App\Interfaces\JobOfferServiceInterface;
use App\Models\Bookmark;
use App\Models\City;
use App\Models\Country;
use App\Models\JobApplication;
use App\Models\Department;
use App\Models\TutorEducation;
use App\Models\Institute;
use App\Models\JobOffer;
use App\Models\Location;
use App\Models\Tutor;
use App\Models\TutorPersonalInfo;
use App\Transformers\CategoryResource;
use App\Transformers\CourseResource;
use App\Transformers\JobOfferResource;
use App\Transformers\SubjectResource;
use App\Transformers\TeachingMethodResource;
use App\Transformers\Tutor_prefered_locationsResource;
use App\Transformers\TutorDaysResource;
use App\Transformers\TutorEducationResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TutorHubController extends Controller
{

    private $jobOfferRepository;
    public function __construct(JobOfferServiceInterface $jobOfferRepository)
    {
        $this->jobOfferRepository = $jobOfferRepository;

    }
    public function newTutorFilter(Request $request)
    {
        $input         = $request->input('pagination_limit') ?? 30;
        $countryId     = $request->country_id;
        $cityId        = $request->city_id;
        $locationId    = $request->location_id;
        $universityId  = $request->university_id;
        $departmentId  = $request->department_id;
        $gender        = $request->gender;
        $schoolId      = $request->school_id;
        $collegeId     = $request->college_id;
        $tutoringMethodId     = $request->t_method_id;
        $sscGroup     = $request->ssc_group;
        $sscBoard     = $request->ssc_board;
        $sscCurriculam     = $request->ssc_curriculam_id;
        $tutorCategory     = $request->category_id;
        $tutorCourse    = $request->course_id;
        $tutorSubject    = $request->subject_id;
        $degreeName = 'honours';

        $threeMonthsAgo = Carbon::now()->subMonths(3)->toDateString();

        $tutorsQuery = Tutor::with([
            'tutor_education',
            'tutor_personal_info',
            'tutor_prefered_locations',
            'teaching_method',
        ])
        ->whereDate('created_at', '>=', $threeMonthsAgo)
        ->where('is_active', 1);

        if ($countryId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($countryId) {
                $subQuery->where('country_id', $countryId);
            });
        }
        if ($cityId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($cityId) {
                $subQuery->where('city_id', $cityId);
            });
        }
        if ($locationId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($locationId) {
                $subQuery->where('location_id', $locationId);
            });
        }

        if ($universityId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($universityId, $degreeName) {
                $subQuery->where('degree_name', $degreeName)->where('institute_id', $universityId);
            });
        }
        if ($departmentId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($departmentId) {
                $subQuery->where('department_id', $departmentId);
            });
        }
        if ($gender !== null) {
            $tutorsQuery->where('gender',$gender);
        }
        if ($schoolId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($schoolId) {
                $subQuery->where('institute_id', $schoolId);
            });
        }
        if ($collegeId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($collegeId) {
                $subQuery->where('institute_id', $collegeId);
            });
        }
        if ($tutoringMethodId !== null) {
            $tutorsQuery->whereHas('teaching_method', function ($subQuery) use ($tutoringMethodId) {
                $subQuery->where('method_id', $tutoringMethodId);
            });
        }
        if ($sscGroup !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscGroup) {
                $subQuery->where('group_or_major', $sscGroup)->where("degree_name","ssc");
            });
        }
        if ($sscBoard !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscBoard) {
                $subQuery->where('education_board', $sscBoard)->where("degree_name","ssc");
            });
        }
        if ($sscCurriculam !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscCurriculam) {
                $subQuery->where('curriculum_id', $sscCurriculam)->where("degree_name","ssc");
            });
        }

        if ($tutorCategory !== null) {
            $tutorsQuery->whereHas('tutor_geTcategories', function ($query) use ($tutorCategory) {
                $query->where('category_id', $tutorCategory);
            });
        }
        if ($tutorCourse !== null) {
            $tutorsQuery->whereHas('tutor_geTcourses', function ($query) use ($tutorCourse) {
                $query->where('course_id', $tutorCourse);
            });
        }
        if ($tutorSubject !== null) {
            $tutorsQuery->whereHas('tutor_geTcourses', function ($query) use ($tutorSubject) {
                $query->where('subject_id', $tutorSubject);
            });
        }

        $tutors = $tutorsQuery
                    ->orderByRaw('
                        is_premium_advance DESC,
                        is_premium_pro DESC,
                        is_premium DESC,
                        is_verified DESC,
                        RAND()
                    ')
                    ->paginate($input);

        $tutorData = [];
        foreach ($tutors as $key => $tutor) {

            $tutorUniversity = null;
            $tutorHsc = null;
            $tutorEducationHonours = $tutor->tutor_education->where('degree_name', "honours")->first();
            $tutorEducationHSC     = $tutor->tutor_education->where('degree_name', "hsc")->first();

            if ($tutorEducationHonours) {
                $institute = Institute::where('id', $tutorEducationHonours->institute_id)->first();
                if ($institute) {
                    $tutorUniversity = $institute->title;
                }
            }
             if ($tutorEducationHSC) {
                $institute = Institute::where('id', $tutorEducationHSC->institute_id)->first();
                if ($institute) {
                    $tutorHsc = $institute->title;
                }
            }

            $tutorData[] = [
                'id'               => $tutor->id,
                'unique_id'        => $tutor->unique_id,
                'tutor_image'      => $tutor->image,
                'tutor_name'       => $tutor->name,
                'tutor_gender'     => $tutor->gender,
                'is_premium'       => $tutor->is_premium,
                'is_premium_pro'     => $tutor->is_premium_pro,
                'is_premium_advance' => $tutor->is_premium_advance,
                'is_verified'      => $tutor->is_verified,
                'is_boost'      => $tutor->is_boost,
                'is_featured'      => $tutor->is_featured,
                'tutor_location'   => $tutor->tutor_prefered_locations->first()->city->name ?? null,
                'tutor_university' => $tutorUniversity,
                'tutor_college'    => $tutorHsc,
                'group_or_major'    => $tutor->tutor_geTcourses,
            ];
        }
        return response()->json([
            'filteredData'       => $tutorData,
            'meta' => [
                'current_page' => $tutors->currentPage(),
                'per_page' => $tutors->perPage(),
                'total' => $tutors->total(),
            ],
            'requested_data' => $request->all(),
        ]);


    }
    public function verifiedTutorFilter(Request $request)
    {
        $input         = $request->input('pagination_limit') ?? 30;
        $countryId     = $request->country_id;
        $cityId        = $request->city_id;
        $locationId    = $request->location_id;
        $universityId  = $request->university_id;
        $departmentId  = $request->department_id;
        $gender        = $request->gender;
        $schoolId      = $request->school_id;
        $collegeId     = $request->college_id;
        $tutoringMethodId     = $request->t_method_id;
        $sscGroup     = $request->ssc_group;
        $sscBoard     = $request->ssc_board;
        $sscCurriculam     = $request->ssc_curriculam_id;
        $tutorCategory     = $request->category_id;
        $tutorCourse    = $request->course_id;
        $tutorSubject    = $request->subject_id;

        $tutorsQuery = Tutor::with([
            'tutor_education',
            'tutor_personal_info',
            'tutor_prefered_locations',
            'teaching_method',
        ])
        ->where('is_verified', 1)
        ->where('is_active', 1);

        if ($countryId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($countryId) {
                $subQuery->where('country_id', $countryId);
            });
        }

        if ($cityId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($cityId) {
                $subQuery->where('city_id', $cityId);
            });
        }
        if ($locationId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($locationId) {
                $subQuery->where('location_id', $locationId);
            });
        }
        $degreeName = 'honours';
        if ($universityId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($universityId, $degreeName) {
                $subQuery->where('degree_name', $degreeName)->where('institute_id', $universityId);
            });
        }
        if ($departmentId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($departmentId) {
                $subQuery->where('department_id', $departmentId);
            });
        }
        if ($gender !== null) {
            $tutorsQuery->where('gender',$gender);
        }
        if ($schoolId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($schoolId) {
                $subQuery->where('institute_id', $schoolId);
            });
        }
        if ($schoolId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($schoolId) {
                $subQuery->where('institute_id', $schoolId);
            });
        }
        if ($collegeId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($collegeId) {
                $subQuery->where('institute_id', $collegeId);
            });
        }
        if ($tutoringMethodId !== null) {
            $tutorsQuery->whereHas('teaching_method', function ($subQuery) use ($tutoringMethodId) {
                $subQuery->where('method_id', $tutoringMethodId);
            });
        }
        if ($sscGroup !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscGroup) {
                $subQuery->where('group_or_major', $sscGroup)->where("degree_name","ssc");
            });
        }
        if ($sscBoard !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscBoard) {
                $subQuery->where('education_board', $sscBoard)->where("degree_name","ssc");
            });
        }
        if ($sscBoard !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscBoard) {
                $subQuery->where('education_board', $sscBoard)->where("degree_name","ssc");
            });
        }
        if ($sscCurriculam !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscCurriculam) {
                $subQuery->where('curriculum_id', $sscCurriculam)->where("degree_name","ssc");
            });
        }

        if ($tutorCategory !== null) {
            $tutorsQuery->whereHas('tutor_geTcategories', function ($query) use ($tutorCategory) {
                $query->where('category_id', $tutorCategory);
            });
        }
        if ($tutorCategory !== null) {
            $tutorsQuery->whereHas('tutor_geTcategories', function ($query) use ($tutorCategory) {
                $query->where('category_id', $tutorCategory);
            });
        }
        if ($tutorCourse !== null) {
            $tutorsQuery->whereHas('tutor_geTcourses', function ($query) use ($tutorCourse) {
                $query->where('course_id', $tutorCourse);
            });
        }
        if ($tutorSubject !== null) {
            $tutorsQuery->whereHas('tutor_geTcourses', function ($query) use ($tutorSubject) {
                $query->where('subject_id', $tutorSubject);
            });
        }

        $tutors = $tutorsQuery
                    ->orderByRaw('
                        is_premium_advance DESC,
                        is_premium_pro DESC,
                        is_premium DESC,
                        is_verified DESC,
                        RAND()
                    ')
                    ->paginate($input);

        $tutorData = [];
        foreach ($tutors as $key => $tutor) {

            $tutorUniversity = null;
            $tutorHsc = null;
            $tutorEducationHonours = $tutor->tutor_education->where('degree_name', "honours")->first();
            $tutorEducationHSC     = $tutor->tutor_education->where('degree_name', "hsc")->first();

            if ($tutorEducationHonours) {
                $institute = Institute::where('id', $tutorEducationHonours->institute_id)->first();
                if ($institute) {
                    $tutorUniversity = $institute->title;
                }
            }
             if ($tutorEducationHSC) {
                $institute = Institute::where('id', $tutorEducationHSC->institute_id)->first();
                if ($institute) {
                    $tutorHsc = $institute->title;
                }
            }

            $tutorData[] = [
                'id'               => $tutor->id,
                'unique_id'        => $tutor->unique_id,
                'tutor_image'      => $tutor->image,
                'tutor_name'       => $tutor->name,
                'tutor_gender'     => $tutor->gender,
                'is_premium'       => $tutor->is_premium,
                'is_premium_pro'     => $tutor->is_premium_pro,
                'is_premium_advance' => $tutor->is_premium_advance,
                'is_verified'      => $tutor->is_verified,
                'is_boost'      => $tutor->is_boost,
                'is_featured'      => $tutor->is_featured,
                'tutor_location'   => $tutor->tutor_prefered_locations->first()->city->name ?? null,
                'tutor_university' => $tutorUniversity,
                'tutor_college'    => $tutorHsc,
                'group_or_major'    => $tutor->tutor_geTcourses,
            ];
        }
        return response()->json([
            'filteredData'       => $tutorData,
            'meta' => [
                'current_page' => $tutors->currentPage(),
                'per_page' => $tutors->perPage(),
                'total' => $tutors->total(),
            ],
            'requested_data' => $request->all(),
        ]);


    }
    public function premiumTutorFilter(Request $request)
    {
        $input         = $request->input('pagination_limit') ?? 30;
        $countryId     = $request->country_id;
        $cityId        = $request->city_id;
        $locationId    = $request->location_id;
        $universityId  = $request->university_id;
        $departmentId  = $request->department_id;
        $gender        = $request->gender;
        $schoolId      = $request->school_id;
        $collegeId     = $request->college_id;
        $tutoringMethodId     = $request->t_method_id;
        $sscGroup     = $request->ssc_group;
        $sscBoard     = $request->ssc_board;
        $sscCurriculam     = $request->ssc_curriculam_id;
        $tutorCategory     = $request->category_id;
        $tutorCourse    = $request->course_id;
        $tutorSubject    = $request->subject_id;

        $tutorsQuery = Tutor::with([
            'tutor_education',
            'tutor_personal_info',
            'tutor_prefered_locations',
            'teaching_method',
        ])
        ->where('is_premium', 1)
        ->where('is_active', 1);

        if ($countryId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($countryId) {
                $subQuery->where('country_id', $countryId);
            });
        }
        if ($cityId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($cityId) {
                $subQuery->where('city_id', $cityId);
            });
        }
        if ($locationId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($locationId) {
                $subQuery->where('location_id', $locationId);
            });
        }
        $degreeName = 'honours';
        if ($universityId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($universityId, $degreeName) {
                $subQuery->where('degree_name', $degreeName)->where('institute_id', $universityId);
            });
        }
        if ($departmentId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($departmentId) {
                $subQuery->where('department_id', $departmentId);
            });
        }
        if ($gender !== null) {
            $tutorsQuery->where('gender',$gender);
        }
        if ($schoolId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($schoolId) {
                $subQuery->where('institute_id', $schoolId);
            });
        }
        if ($schoolId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($schoolId) {
                $subQuery->where('institute_id', $schoolId);
            });
        }
        if ($collegeId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($collegeId) {
                $subQuery->where('institute_id', $collegeId);
            });
        }
        if ($tutoringMethodId !== null) {
            $tutorsQuery->whereHas('teaching_method', function ($subQuery) use ($tutoringMethodId) {
                $subQuery->where('method_id', $tutoringMethodId);
            });
        }
        if ($sscGroup !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscGroup) {
                $subQuery->where('group_or_major', $sscGroup)->where("degree_name","ssc");
            });
        }
        if ($sscBoard !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscBoard) {
                $subQuery->where('education_board', $sscBoard)->where("degree_name","ssc");
            });
        }
        if ($sscBoard !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscBoard) {
                $subQuery->where('education_board', $sscBoard)->where("degree_name","ssc");
            });
        }
        if ($sscCurriculam !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscCurriculam) {
                $subQuery->where('curriculum_id', $sscCurriculam)->where("degree_name","ssc");
            });
        }

        if ($tutorCategory !== null) {
            $tutorsQuery->whereHas('tutor_geTcategories', function ($query) use ($tutorCategory) {
                $query->where('category_id', $tutorCategory);
            });
        }
        if ($tutorCategory !== null) {
            $tutorsQuery->whereHas('tutor_geTcategories', function ($query) use ($tutorCategory) {
                $query->where('category_id', $tutorCategory);
            });
        }
        if ($tutorCourse !== null) {
            $tutorsQuery->whereHas('tutor_geTcourses', function ($query) use ($tutorCourse) {
                $query->where('course_id', $tutorCourse);
            });
        }
        if ($tutorSubject !== null) {
            $tutorsQuery->whereHas('tutor_geTcourses', function ($query) use ($tutorSubject) {
                $query->where('subject_id', $tutorSubject);
            });
        }

        $tutors = $tutorsQuery
                    ->orderByRaw('
                        is_premium_advance DESC,
                        is_premium_pro DESC,
                        is_premium DESC,
                        is_verified DESC,
                        RAND()
                    ')
                    ->paginate($input);

        $tutorData = [];
        foreach ($tutors as $key => $tutor) {

            $tutorUniversity = null;
            $tutorHsc = null;
            $tutorEducationHonours = $tutor->tutor_education->where('degree_name', "honours")->first();
            $tutorEducationHSC     = $tutor->tutor_education->where('degree_name', "hsc")->first();

            if ($tutorEducationHonours) {
                $institute = Institute::where('id', $tutorEducationHonours->institute_id)->first();
                if ($institute) {
                    $tutorUniversity = $institute->title;
                }
            }
             if ($tutorEducationHSC) {
                $institute = Institute::where('id', $tutorEducationHSC->institute_id)->first();
                if ($institute) {
                    $tutorHsc = $institute->title;
                }
            }

            $tutorData[] = [
                'id'               => $tutor->id,
                'unique_id'        => $tutor->unique_id,
                'tutor_image'      => $tutor->image,
                'tutor_name'       => $tutor->name,
                'tutor_gender'     => $tutor->gender,
                'is_premium'       => $tutor->is_premium,
                'is_premium_pro'     => $tutor->is_premium_pro,
                'is_premium_advance' => $tutor->is_premium_advance,
                'is_verified'      => $tutor->is_verified,
                'is_boost'      => $tutor->is_boost,
                'is_featured'      => $tutor->is_featured,
                'tutor_location'   => $tutor->tutor_prefered_locations->first()->city->name ?? null,
                'tutor_university' => $tutorUniversity,
                'tutor_college'    => $tutorHsc,
                'group_or_major'    => $tutor->tutor_geTcourses,
            ];
        }
        return response()->json([
            'filteredData'       => $tutorData,
            'meta' => [
                'current_page' => $tutors->currentPage(),
                'per_page' => $tutors->perPage(),
                'total' => $tutors->total(),
            ],
            'requested_data' => $request->all(),
        ]);


    }
    public function exclusiveTutorFilter(Request $request)
    {
        $input         = $request->input('pagination_limit') ?? 30;
        $countryId     = $request->country_id;
        $cityId        = $request->city_id;
        $locationId    = $request->location_id;
        $universityId  = $request->university_id;
        $departmentId  = $request->department_id;
        $gender        = $request->gender;
        $schoolId      = $request->school_id;
        $collegeId     = $request->college_id;
        $tutoringMethodId     = $request->t_method_id;
        $sscGroup     = $request->ssc_group;
        $sscBoard     = $request->ssc_board;
        $sscCurriculam     = $request->ssc_curriculam_id;
        $tutorCategory     = $request->category_id;
        $tutorCourse    = $request->course_id;
        $tutorSubject    = $request->subject_id;

        $tutorsQuery = Tutor::with([
            'tutor_education',
            'tutor_personal_info',
            'tutor_prefered_locations',
            'teaching_method',
        ])
        ->where('is_featured', 1)
        ->where('is_active', 1);

        if ($countryId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($countryId) {
                $subQuery->where('country_id', $countryId);
            });
        }
        if ($cityId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($cityId) {
                $subQuery->where('city_id', $cityId);
            });
        }
        if ($locationId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($locationId) {
                $subQuery->where('location_id', $locationId);
            });
        }
        $degreeName = 'honours';
        if ($universityId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($universityId, $degreeName) {
                $subQuery->where('degree_name', $degreeName)->where('institute_id', $universityId);
            });
        }
        if ($departmentId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($departmentId) {
                $subQuery->where('department_id', $departmentId);
            });
        }
        if ($gender !== null) {
            $tutorsQuery->where('gender',$gender);
        }
        if ($schoolId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($schoolId) {
                $subQuery->where('institute_id', $schoolId);
            });
        }
        if ($schoolId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($schoolId) {
                $subQuery->where('institute_id', $schoolId);
            });
        }
        if ($collegeId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($collegeId) {
                $subQuery->where('institute_id', $collegeId);
            });
        }
        if ($tutoringMethodId !== null) {
            $tutorsQuery->whereHas('teaching_method', function ($subQuery) use ($tutoringMethodId) {
                $subQuery->where('method_id', $tutoringMethodId);
            });
        }
        if ($sscGroup !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscGroup) {
                $subQuery->where('group_or_major', $sscGroup)->where("degree_name","ssc");
            });
        }
        if ($sscBoard !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscBoard) {
                $subQuery->where('education_board', $sscBoard)->where("degree_name","ssc");
            });
        }
        if ($sscBoard !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscBoard) {
                $subQuery->where('education_board', $sscBoard)->where("degree_name","ssc");
            });
        }
        if ($sscCurriculam !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscCurriculam) {
                $subQuery->where('curriculum_id', $sscCurriculam)->where("degree_name","ssc");
            });
        }

        if ($tutorCategory !== null) {
            $tutorsQuery->whereHas('tutor_geTcategories', function ($query) use ($tutorCategory) {
                $query->where('category_id', $tutorCategory);
            });
        }
        if ($tutorCategory !== null) {
            $tutorsQuery->whereHas('tutor_geTcategories', function ($query) use ($tutorCategory) {
                $query->where('category_id', $tutorCategory);
            });
        }
        if ($tutorCourse !== null) {
            $tutorsQuery->whereHas('tutor_geTcourses', function ($query) use ($tutorCourse) {
                $query->where('course_id', $tutorCourse);
            });
        }
        if ($tutorSubject !== null) {
            $tutorsQuery->whereHas('tutor_geTcourses', function ($query) use ($tutorSubject) {
                $query->where('subject_id', $tutorSubject);
            });
        }

        $tutors = $tutorsQuery
                    ->orderByRaw('
                        is_premium_advance DESC,
                        is_premium_pro DESC,
                        is_premium DESC,
                        is_verified DESC,
                        RAND()
                    ')
                    ->paginate($input);

        $tutorData = [];
        foreach ($tutors as $key => $tutor) {

            $tutorUniversity = null;
            $tutorHsc = null;
            $tutorEducationHonours = $tutor->tutor_education->where('degree_name', "honours")->first();
            $tutorEducationHSC     = $tutor->tutor_education->where('degree_name', "hsc")->first();

            if ($tutorEducationHonours) {
                $institute = Institute::where('id', $tutorEducationHonours->institute_id)->first();
                if ($institute) {
                    $tutorUniversity = $institute->title;
                }
            }
             if ($tutorEducationHSC) {
                $institute = Institute::where('id', $tutorEducationHSC->institute_id)->first();
                if ($institute) {
                    $tutorHsc = $institute->title;
                }
            }

            $tutorData[] = [
                'id'               => $tutor->id,
                'unique_id'        => $tutor->unique_id,
                'tutor_image'      => $tutor->image,
                'tutor_name'       => $tutor->name,
                'tutor_gender'     => $tutor->gender,
                'is_premium'       => $tutor->is_premium,
                'is_premium_pro'     => $tutor->is_premium_pro,
                'is_premium_advance' => $tutor->is_premium_advance,
                'is_verified'      => $tutor->is_verified,
                'is_boost'      => $tutor->is_boost,
                'is_featured'      => $tutor->is_featured,
                'tutor_location'   => $tutor->tutor_prefered_locations->first()->city->name ?? null,
                'tutor_university' => $tutorUniversity,
                'tutor_college'    => $tutorHsc,
                'group_or_major'    => $tutor->tutor_geTcourses,
            ];
        }
        return response()->json([
            'filteredData'       => $tutorData,
            'meta' => [
                'current_page' => $tutors->currentPage(),
                'per_page' => $tutors->perPage(),
                'total' => $tutors->total(),
            ],
            'requested_data' => $request->all(),
        ]);


    }
    // public function filter(Request $request)
    // {

    //     // dd($request->all());
        
    //     $search = $request->searchInput;

    //     $input         = $request->input('pagination_limit') ?? 30;
    //     $countryId     = $request->country_id;
    //     $cityId        = $request->city_id;
    //     $locationId    = $request->location_id;
    //     $universityId  = $request->university_id;
    //     $departmentId  = $request->department_id;
    //     $gender        = $request->gender;
    //     $schoolId      = $request->school_id;
    //     $collegeId     = $request->college_id;
    //     $tutoringMethodId = $request->t_method_id;
    //     $sscGroup         = $request->ssc_group;
    //     $sscBoard         = $request->ssc_board;
    //     $sscCurriculam    = $request->ssc_curriculam_id;
    //     $tutorCategory    = $request->category_id;
    //     $tutorCourse      = $request->course_id;
    //     $tutorSubject     = $request->subject_id;

    //     $religion         = $request->religion;
    //     $year             = $request->year;
        
    //     $name = $request->name;
    //     $tutorID = $request->tutor_unique_id;
        


    //     $tutorsQuery = Tutor::with([
    //         'tutor_education',
    //         'tutor_personal_info',
    //         'tutor_prefered_locations',
    //         'teaching_method',
    //     ])->where('is_active', 1);

    //     if ($year !== null) {
    //         $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($year) {
    //             $subQuery->where('degree_name', 'honours')
    //                      ->where('year_or_semester', $year);
    //         });
    //     }
    //     if ($religion !== null) {
    //         $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($religion) {
    //             $subQuery->where('religion', $religion);
    //         });
    //     }
    //     if ($countryId !== null) {
    //         $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($countryId) {
    //             $subQuery->where('country_id', $countryId);
    //         });
    //     }
    //     if ($cityId !== null) {
    //         $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($cityId) {
    //             $subQuery->where('city_id', $cityId);
    //         });
    //     }
    //     if ($locationId !== null) {
    //         $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($locationId) {
    //             $subQuery->where('location_id', $locationId);
    //         });
    //     }
    //     $degreeName = 'honours';
    //     if ($universityId !== null) {
    //         $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($universityId, $degreeName) {
    //             $subQuery->where('degree_name', $degreeName)->where('institute_id', $universityId);
    //         });
    //     }
    //     if ($departmentId !== null) {
    //         $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($departmentId) {
    //             $subQuery->where('department_id', $departmentId);
    //         });
    //     }
    //     if ($gender !== null) {
    //         $tutorsQuery->where('gender',$gender);
    //     }
    //     if ($tutorID !== null) {
    //         $tutorsQuery->where('unique_id',$tutorID);
    //     }
    //     if ($name !== null) {
    //         $tutorsQuery->where('name', 'like', '%' . $name . '%');
    //     }
    //     if ($schoolId !== null) {
    //         $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($schoolId) {
    //             $subQuery->where('institute_id', $schoolId);
    //         });
    //     }
    //     if ($schoolId !== null) {
    //         $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($schoolId) {
    //             $subQuery->where('institute_id', $schoolId);
    //         });
    //     }
    //     if ($collegeId !== null) {
    //         $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($collegeId) {
    //             $subQuery->where('institute_id', $collegeId);
    //         });
    //     }
    //     if ($tutoringMethodId !== null) {
    //         $tutorsQuery->whereHas('teaching_method', function ($subQuery) use ($tutoringMethodId) {
    //             $subQuery->where('method_id', $tutoringMethodId);
    //         });
    //     }
    //     if ($sscGroup !== null) {
    //         $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscGroup) {
    //             $subQuery->where('group_or_major', $sscGroup)->where("degree_name","ssc");
    //         });
    //     }
    //     if ($sscBoard !== null) {
    //         $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscBoard) {
    //             $subQuery->where('education_board', $sscBoard)->where("degree_name","ssc");
    //         });
    //     }
    //     if ($sscBoard !== null) {
    //         $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscBoard) {
    //             $subQuery->where('education_board', $sscBoard)->where("degree_name","ssc");
    //         });
    //     }
    //     if ($sscCurriculam !== null) {
    //         $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscCurriculam) {
    //             $subQuery->where('curriculum_id', $sscCurriculam)->where("degree_name","ssc");
    //         });
    //     }

    //     if ($tutorCategory !== null) {
    //         $tutorsQuery->whereHas('tutor_geTcategories', function ($query) use ($tutorCategory) {
    //             $query->where('category_id', $tutorCategory);
    //         });
    //     }
    //     if ($tutorCourse !== null) {
    //         $tutorsQuery->whereHas('tutor_geTcourses', function ($query) use ($tutorCourse) {
    //             $query->where('course_id', $tutorCourse);
    //         });
    //     }
    //     if ($tutorSubject !== null) {
    //         $tutorsQuery->whereHas('tutor_geTcourses', function ($query) use ($tutorSubject) {
    //             $query->where('subject_id', $tutorSubject);
    //         });
    //     }

    //     $tutors = $tutorsQuery
    //                 ->orderByRaw('
    //                     is_premium_advance DESC,
    //                     is_premium_pro DESC,
    //                     is_premium DESC,
    //                     RAND()
    //                 ')
    //                 ->paginate($input);

    //     $tutorData = [];
    //     foreach ($tutors as $key => $tutor) {

    //         $tutorUniversity = null;
    //         $tutorHsc = null;
    //         $tutorEducationHonours = $tutor->tutor_education->where('degree_name', "honours")->first();
    //         $tutorEducationHSC     = $tutor->tutor_education->where('degree_name', "hsc")->first();

    //         if ($tutorEducationHonours) {
    //             $institute = Institute::where('id', $tutorEducationHonours->institute_id)->first();
    //             if ($institute) {
    //                 $tutorUniversity = $institute->title;
    //             }
    //         }
    //          if ($tutorEducationHSC) {
    //             $institute = Institute::where('id', $tutorEducationHSC->institute_id)->first();
    //             if ($institute) {
    //                 $tutorHsc = $institute->title;
    //             }
    //         }

    //         $tutorData[] = [
    //             'id'               => $tutor->id,
    //             'unique_id'        => $tutor->unique_id,
    //             'tutor_image'      => $tutor->image,
    //             'tutor_name'       => $tutor->name,
    //             'tutor_gender'     => $tutor->gender,
    //             'is_premium'       => $tutor->is_premium,
    //             'is_premium_pro'     => $tutor->is_premium_pro,
    //             'is_premium_advance' => $tutor->is_premium_advance,
    //             'is_verified'      => $tutor->is_verified,
    //             'is_boost'      => $tutor->is_boost,
    //             'is_featured'      => $tutor->is_featured,
    //             'tutor_location'   => $tutor->tutor_prefered_locations->first()->city->name ?? null,
    //             'tutor_university' => $tutorUniversity,
    //             'tutor_college'    => $tutorHsc,
    //             'group_or_major'    => $tutor->tutor_geTcourses,
    //         ];
    //     }
    //     return response()->json([
    //         'filteredData'       => $tutorData,
    //         'meta' => [
    //             'current_page' => $tutors->currentPage(),
    //             'per_page' => $tutors->perPage(),
    //             'total' => $tutors->total(),
    //         ],
    //         'requested_data' => $request->all(),
    //     ]);


    // }
    public function filter(Request $request)
    {

        $search = $request->searchInput;
        

        $input         = $request->input('pagination_limit') ?? 30;
        $countryId     = $request->country_id;
        $cityId        = $request->city_id;
        $locationId    = $request->location_id;
        $universityId  = $request->university_id;
        $departmentId  = $request->department_id;
        $gender        = $request->gender;
        $schoolId      = $request->school_id;
        $collegeId     = $request->college_id;
        $tutoringMethodId = $request->t_method_id;
        $sscGroup         = $request->ssc_group;
        $sscBoard         = $request->ssc_board;
        $sscCurriculam    = $request->ssc_curriculam_id;
        $tutorCategory    = $request->category_id;
        $tutorCourse      = $request->course_id;
        $tutorSubject     = $request->subject_id;

        $religion         = $request->religion;
        $year             = $request->year;
        
        $name = $request->name;
        $tutorID = $request->tutor_unique_id;
        


        $tutorsQuery = Tutor::with([
            'tutor_education',
            'tutor_personal_info',
            'tutor_prefered_locations',
            'teaching_method',
        ])->where('is_active', 1);
        
        
      
       if ($search !== null && strlen(trim($search)) >= 1) {

            $searchTerm = '%' . trim($search) . '%';
            $keywords   = preg_split('/\s+/', trim($search));
        
            $universityIds = Institute::where('title', 'LIKE', $searchTerm)
                ->pluck('id')
                ->toArray();
        
            $tutorsQuery->where(function ($query) use ($keywords, $searchTerm, $universityIds) {
        
                foreach ($keywords as $word) {
        
                    $word = '%' . $word . '%';
        
                    $query->orWhere('unique_id', 'LIKE', $word)
                          ->orWhere('name', 'LIKE', $word);
        
                    // FIXED: group_or_major LIKE (not whereIn)
                    $query->orWhereHas('tutor_education', function ($subQuery) use ($word) {
                        $subQuery->where('group_or_major', 'LIKE', $word);
                    });
                }
        
                // University match (OUTSIDE loop)
                if (!empty($universityIds)) {
                    $query->orWhereHas('tutor_education', function ($subQuery) use ($universityIds) {
                        $subQuery->whereIn('institute_id', $universityIds);
                    });
                }
            });
        }


        if ($year !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($year) {
                $subQuery->where('degree_name', 'honours')
                         ->where('year_or_semester', $year);
            });
        }
        if ($religion !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($religion) {
                $subQuery->where('religion', $religion);
            });
        }
        if ($countryId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($countryId) {
                $subQuery->where('country_id', $countryId);
            });
        }
        if ($cityId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($cityId) {
                $subQuery->where('city_id', $cityId);
            });
        }
        if ($locationId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($locationId) {
                $subQuery->where('location_id', $locationId);
            });
        }
        $degreeName = 'honours';
        if ($universityId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($universityId, $degreeName) {
                $subQuery->where('degree_name', $degreeName)->where('institute_id', $universityId);
            });
        }
        if ($departmentId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($departmentId) {
                $subQuery->where('department_id', $departmentId);
            });
        }
        if ($gender !== null) {
            $tutorsQuery->where('gender',$gender);
        }
        if ($tutorID !== null) {
            $tutorsQuery->where('unique_id',$tutorID);
        }
        if ($name !== null) {
            $tutorsQuery->where('name', 'like', '%' . $name . '%');
        }
        
        if ($schoolId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($schoolId) {
                $subQuery->where('institute_id', $schoolId);
            });
        }
        if ($collegeId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($collegeId) {
                $subQuery->where('institute_id', $collegeId);
            });
        }
        if ($tutoringMethodId !== null) {
            $tutorsQuery->whereHas('teaching_method', function ($subQuery) use ($tutoringMethodId) {
                $subQuery->where('method_id', $tutoringMethodId);
            });
        }
        if ($sscGroup !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscGroup) {
                $subQuery->where('group_or_major', $sscGroup)->where("degree_name","ssc");
            });
        }
        if ($sscBoard !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscBoard) {
                $subQuery->where('education_board', $sscBoard)->where("degree_name","ssc");
            });
        }
        
        if ($sscCurriculam !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscCurriculam) {
                $subQuery->where('curriculum_id', $sscCurriculam)->where("degree_name","ssc");
            });
        }

        if ($tutorCategory !== null) {
            $tutorsQuery->whereHas('tutor_geTcategories', function ($query) use ($tutorCategory) {
                $query->where('category_id', $tutorCategory);
            });
        }
        if ($tutorCategory !== null) {
            $tutorsQuery->whereHas('tutor_geTcategories', function ($query) use ($tutorCategory) {
                $query->where('category_id', $tutorCategory);
            });
        }
        if ($tutorCourse !== null) {
            $tutorsQuery->whereHas('tutor_geTcourses', function ($query) use ($tutorCourse) {
                $query->where('course_id', $tutorCourse);
            });
        }
        if ($tutorSubject !== null) {
            $tutorsQuery->whereHas('tutor_geTcourses', function ($query) use ($tutorSubject) {
                $query->where('subject_id', $tutorSubject);
            });
        }

        $tutors = $tutorsQuery
                    ->orderByRaw('
                        is_premium_advance DESC,
                        is_premium_pro DESC,
                        is_premium DESC,
                        RAND()
                    ')
                    ->paginate($input);

        $tutorData = [];
        foreach ($tutors as $key => $tutor) {

            $tutorUniversity = null;
            $tutorHsc = null;
            $tutorEducationHonours = $tutor->tutor_education->where('degree_name', "honours")->first();
            $tutorEducationHSC     = $tutor->tutor_education->where('degree_name', "hsc")->first();

            if ($tutorEducationHonours) {
                $institute = Institute::where('id', $tutorEducationHonours->institute_id)->first();
                if ($institute) {
                    $tutorUniversity = $institute->title;
                }
            }
             if ($tutorEducationHSC) {
                $institute = Institute::where('id', $tutorEducationHSC->institute_id)->first();
                if ($institute) {
                    $tutorHsc = $institute->title;
                }
            }

            $tutorData[] = [
                'id'               => $tutor->id,
                'unique_id'        => $tutor->unique_id,
                'tutor_image'      => $tutor->image,
                'tutor_name'       => $tutor->name,
                'tutor_gender'     => $tutor->gender,
                'is_premium'       => $tutor->is_premium,
                'is_premium_pro'     => $tutor->is_premium_pro,
                'is_premium_advance' => $tutor->is_premium_advance,
                'is_verified'      => $tutor->is_verified,
                'is_boost'      => $tutor->is_boost,
                'is_featured'      => $tutor->is_featured,
                'tutor_location'   => $tutor->tutor_prefered_locations->first()->city->name ?? null,
                'tutor_university' => $tutorUniversity,
                'tutor_college'    => $tutorHsc,
                'group_or_major'    => $tutor->tutor_geTcourses,
            ];
        }
        return response()->json([
            'filteredData'       => $tutorData,
            'meta' => [
                'current_page' => $tutors->currentPage(),
                'per_page' => $tutors->perPage(),
                'total' => $tutors->total(),
            ],
            'requested_data' => $request->all(),
        ]);


    }
    public function tutorHub(Request $request)
    {
        $homeTutor = [
           $allTutor      = $this->getAllTutor($request),
           $premiumTutor  = $this->getPremiumTutor($request),
           $verifiedTutor = $this->getVerifiedTutor($request),
           $newTutor      = $this->getNewTutor($request),
           $exclusiveTutor = $this->getFeaturedTutor($request),
        ];



        return response()->json([
            'homeTutor'     => $homeTutor,

        ]);
    }
    public function tutorCounting()
    {
        $cacheKey = 'tutor_counting';
        $cacheDuration = 6 * 60;

        $cachedData = Cache::remember($cacheKey, $cacheDuration, function () {
            $maletutotor   = Tutor::where('gender', 'male')->count();
            $femaletutotor = Tutor::where('gender', 'female')->count();
            $alltutor      = Tutor::count();

            return [
                'alltutor'      => $alltutor,
                'maletutotor'   => $maletutotor,
                'femaletutotor' => $femaletutotor,
            ];
        });

        return response()->json($cachedData);
    }
    public function getAllTutor(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 36);
            $cityId = $request->input('city_id');

            // Base query with eager loading
            $tutorsQuery = Tutor::with([
                'tutor_education.institutes',
                'tutor_personal_info',
                'tutor_prefered_locations.city'
            ])->where('is_active', 1);

            if ($cityId !== null) {
                $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($cityId) {
                    $subQuery->where('city_id', $cityId);
                });
            }

            $tutors = $tutorsQuery->selectRaw("
            *,
            CASE
                WHEN is_boost = 1 AND boost_package = 1 AND boost_date >= CURDATE() - INTERVAL 15 DAY THEN 1
                WHEN is_boost = 1 AND boost_package = 3 AND boost_date >= CURDATE() - INTERVAL 30 DAY THEN 1
                WHEN is_boost = 1 AND boost_package = 6 AND boost_date >= CURDATE() - INTERVAL 60 DAY THEN 1
                WHEN is_boost = 1 AND boost_package = 12 AND boost_date >= CURDATE() - INTERVAL 90 DAY THEN 1

                WHEN is_premium_advance = 1 AND premium_date >= CURDATE() - INTERVAL 60 DAY THEN 2
                WHEN is_premium_pro = 1 AND premium_date >= CURDATE() - INTERVAL 45 DAY THEN 3
                WHEN is_premium = 1 AND premium_date >= CURDATE() - INTERVAL 30 DAY THEN 4
                ELSE 5
            END AS priority
        ")
        ->orderBy('priority')
        ->inRandomOrder() // Randomize within priority groups
        ->paginate($perPage);

            // Map data for response
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
                    'tutorprofile'     => $tutor->getProfileComplete(),
                ];
            });

            // Return successful response
            return response()->json([
                'Alltutors' => $tutorData,
                'meta' => [
                    'current_page' => $tutors->currentPage(),
                    'per_page'     => $tutors->perPage(),
                    'total'        => $tutors->total(),
                    'cityId'       => $cityId ?? '',
                ],
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'error' => 'An error occurred while fetching tutors. Please try again later.',
            ], 500);
        }
    }
    public function getPremiumTutor(Request $request)
    {
        $perPage = $request->input('per_page', 36);
        $cityId = $request->input('city_id');

        $tutorsQuery = Tutor::with([
            'tutor_education.institutes',
            'tutor_personal_info',
            'tutor_prefered_locations.city',
        ])
        ->where(function($query) {
            $query->where('is_premium', 1)
                ->orWhere('is_premium_pro', 1)
                ->orWhere('is_premium_advance', 1);
        })
        ->where('is_active', 1);

        // Filter by city
        if ($cityId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($cityId) {
                $subQuery->where('city_id', $cityId);
            });
        }

        // Ordering tutors based on requirements
        $tutors = $tutorsQuery->selectRaw("
        *,
        CASE
            WHEN is_boost = 1 AND boost_package = 1 AND boost_date >= CURDATE() - INTERVAL 15 DAY THEN 1
            WHEN is_boost = 1 AND boost_package = 3 AND boost_date >= CURDATE() - INTERVAL 30 DAY THEN 1
            WHEN is_boost = 1 AND boost_package = 6 AND boost_date >= CURDATE() - INTERVAL 60 DAY THEN 1
            WHEN is_boost = 1 AND boost_package = 12 AND boost_date >= CURDATE() - INTERVAL 90 DAY THEN 1

            WHEN is_premium_advance = 1 AND premium_date >= CURDATE() - INTERVAL 45 DAY THEN 2
            WHEN is_premium_pro = 1 AND premium_date >= CURDATE() - INTERVAL 20 DAY THEN 3
            ELSE 4
            END AS priority
        ")
        ->orderBy('priority')
        ->inRandomOrder()
        ->paginate($perPage);

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

        // Return response
        return response()->json([
            'premiumTutors' => $tutorData,
            'meta' => [
                'current_page' => $tutors->currentPage(),
                'per_page'     => $tutors->perPage(),
                'total'        => $tutors->total(),
                'cityId'       => $cityId,
            ],
        ]);
    }

    public function getVerifiedTutor(Request $request)
    {
        $perPage = $request->input('per_page', 36);
        $cityId  = $request->input('city_id');

        $tutorsQuery = Tutor::with([
            'tutor_education',
            'tutor_personal_info',
            'tutor_prefered_locations',
        ])
        ->where('is_verified', 1)
        ->where('is_active', 1);

        if ($cityId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($cityId) {
                $subQuery->where('city_id', $cityId);
            });
        }

        $tutors = $tutorsQuery->orderByRaw('
                        is_premium_advance DESC,
                        is_premium_pro DESC,
                        is_premium DESC,
                        RAND()
                    ')->paginate($perPage);


        $tutorData = [];
        foreach ($tutors as $key => $tutor) {

            $tutorUniversity = null;
            $tutorHsc = null;
            $tutorEducationHonours = $tutor->tutor_education->where('degree_name', "honours")->first();
            $tutorEducationHSC     = $tutor->tutor_education->where('degree_name', "hsc")->first();

            if ($tutorEducationHonours) {
                $institute = Institute::where('id', $tutorEducationHonours->institute_id)->first();
                if ($institute) {
                    $tutorUniversity = $institute->title;
                }
            }
             if ($tutorEducationHSC) {
                $institute = Institute::where('id', $tutorEducationHSC->institute_id)->first();
                if ($institute) {
                    $tutorHsc = $institute->title;
                }
            }

            $tutorData[] = [
                'id'               => $tutor->id,
                'unique_id'        => $tutor->unique_id,
                'tutor_image'      => $tutor->image,
                'tutor_name'       => $tutor->name,
                'tutor_gender'     => $tutor->gender,
                'is_premium'       => $tutor->is_premium,
                'is_premium_pro'     => $tutor->is_premium_pro,
                'is_premium_advance' => $tutor->is_premium_advance,
                'is_boost' => $tutor->is_boost,
                'is_verified'      => $tutor->is_verified,
                'is_featured'      => $tutor->is_featured,
                'tutor_location'   => $tutor->tutor_prefered_locations->first()->city->name ?? null,
                'tutor_university' => $tutorUniversity,
                'tutor_college'    => $tutorHsc,
            ];
        }
        return response()->json([
            'verified'       => $tutorData,
            'meta' => [
                'current_page' => $tutors->currentPage(),
                'per_page' => $tutors->perPage(),
                'total' => $tutors->total(),
                'cityId' => $cityId,
            ],
        ]);


    }
    public function getFeaturedTutor(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $cityId  = $request->input('city_id');

        $tutorsQuery = Tutor::with([
            'tutor_education',
            'tutor_personal_info',
            'tutor_prefered_locations',
        ])
        ->where('is_featured',1)
        ->where('is_active', 1);

        if ($cityId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($cityId) {
                $subQuery->where('city_id', $cityId);
            });
        }

        $tutors = $tutorsQuery->orderByRaw('
                        is_premium_advance DESC,
                        is_premium_pro DESC,
                        is_premium DESC,
                        RAND()
                    ')->paginate($perPage);


        $tutorData = [];
        foreach ($tutors as $key => $tutor) {

            $tutorUniversity = null;
            $tutorHsc = null;
            $tutorEducationHonours = $tutor->tutor_education->where('degree_name', "honours")->first();
            $tutorEducationHSC     = $tutor->tutor_education->where('degree_name', "hsc")->first();

            if ($tutorEducationHonours) {
                $institute = Institute::where('id', $tutorEducationHonours->institute_id)->first();
                if ($institute) {
                    $tutorUniversity = $institute->title;
                }
            }
             if ($tutorEducationHSC) {
                $institute = Institute::where('id', $tutorEducationHSC->institute_id)->first();
                if ($institute) {
                    $tutorHsc = $institute->title;
                }
            }

            $tutorData[] = [
                'id'               => $tutor->id,
                'unique_id'        => $tutor->unique_id,
                'tutor_image'      => $tutor->image,
                'tutor_gender'     => $tutor->gender,
                'tutor_name'       => $tutor->name,
                'is_premium'       => $tutor->is_premium,
                'is_premium_pro'     => $tutor->is_premium_pro,
                'is_premium_advance' => $tutor->is_premium_advance,
                'is_boost' => $tutor->is_boost,
                'is_verified'      => $tutor->is_verified,
                'is_featured'      => $tutor->is_featured,
                'tutor_location'   => $tutor->tutor_prefered_locations->first()->city->name ?? null,
                'tutor_university' => $tutorUniversity,
                'tutor_college'    => $tutorHsc,
            ];
        }
        return response()->json([
            'exclusiveTutor'       => $tutorData,
            'meta'      => [
                'current_page' => 1,
                'per_page'     => $perPage,
                'total'        => $tutors->total(),
                'cityId'       => $cityId,
            ],
        ]);


    }
    public function getNewTutor(Request $request)
    {


        $perPage = $request->input('per_page', 36);
        $cityId  = $request->input('city_id');
        $threeMonthsAgo = Carbon::now()->subMonths(3)->toDateString();


        $tutorsQuery = Tutor::whereDate('created_at', '>=', $threeMonthsAgo)
                        ->where('is_active', 1);

        if ($cityId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($cityId) {
                $subQuery->where('city_id', $cityId);
            });
        }

        $tutors = $tutorsQuery->orderByRaw('
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
        ')->paginate($perPage);

        $tutorData = [];
        foreach ($tutors as $key => $tutor) {
        $tutorprofile = $tutor->getProfileComplete();

        $tutorData []= [
            'id' => $tutor->id,
            'unique_id' => $tutor->unique_id,
            'tutor_name' => $tutor->name,
            'tutor_gender' => $tutor->gender,
            'tutor_image' => $tutor->image,
            'is_premium'       => $tutor->is_premium,
            'is_premium_pro'     => $tutor->is_premium_pro,
            'is_premium_advance' => $tutor->is_premium_advance,
            'is_boost' => $tutor->is_boost,
            'is_verified' => $tutor->is_verified,
            'is_featured' => $tutor->is_featured,
            'tutor_location' => $tutor->tutor_personal_info->city->name ?? null,
            'tutor_education' => TutorEducationResource::collection($tutor->tutor_education),
            'profileCompleted' => $tutorprofile,
        ];
        }


        return response()->json([
            'newTutor'       => $tutorData,
            'meta' => [
                'current_page' => $tutors->currentPage(),
                'per_page' => $tutors->perPage(),
                'total' => $tutors->total(),
                'cityId' => $cityId,
            ],

        ]);



    }
    public function getSingleTutor($id)
    {

        $tutor = Tutor::with([
            'tutor_personal_info',
            'tutor_education',
            'tutor_prefered_locations',
            'tutor_course',
            'tutor_subject',
            'tutor_categories',
            'tutor_days',
            'teaching_method',
            'course_subjects',
            'TutorCertificate',
            'tutor_reviews',
        ])->where('unique_id', $id)->first();

        if (!$tutor) {
            return response()->json(['message' => 'Tutor not found'], 404);
        }




        $tutor->profile_views += 1;
        $tutor->update();







            $tutorUniversity = null;
            $tutorDepartment = null;
            $tutorEducationHonours = $tutor->tutor_education->where('degree_name', "honours")->first();



            $tutorData[] = [
                'id'               => $tutor->id,
                'profile_views'    => $tutor->profile_views,
                'unoque_id'        => $tutor->unique_id,
                'profile_image'    => $tutor->image,
                'tutor_name'       => $tutor->name,
                'tutor_id'         => $tutor->unique_id,
                'is_premium'       => $tutor->is_premium,
                'is_premium_pro'     => $tutor->is_premium_pro,
                'is_premium_advance' => $tutor->is_premium_advance,
                'is_boost' => $tutor->is_boost,
                'is_verified'      => $tutor->is_verified,
                'is_featured'      => $tutor->is_featured,
                'tutoruniversity'  => $tutorUniversity,
                'tutorDepartment'  => $tutorDepartment,
                'gender'           => $tutor->gender,
                'religion'         => $tutor->tutor_personal_info->religion ?? '',
                'blood_group'      => $tutor->tutor_personal_info->blood_group ?? '',
                'date_of_birth'    => $tutor->tutor_personal_info->date_of_birth ?? '',
                'nationality'      => $tutor->tutor_personal_info->nationality ?? '',
                'member_since'     => $tutor->created_at,
                'last_achive'      => $tutor->login_at,
            ];

            $tutoringInformation[] = [
                'tutor_country'                => $tutor->tutor_personal_info->country->name ?? null,
                'tutor_city'                   => $tutor->tutor_personal_info->city->name ?? null,
                'tutor_location'               => $tutor->tutor_personal_info->location->name ?? null,
                'tutor_prefered_location'      => Tutor_prefered_locationsResource::collection($tutor->tutor_prefered_locations),
                'tutor_course'                 => CourseResource::collection($tutor->tutor_course),
                'tutor_subject'                => SubjectResource::collection($tutor->tutor_subject),
                'tutor_categories'             => CategoryResource::collection($tutor->tutor_categories),
                'tutor_days'                   => TutorDaysResource::collection($tutor->tutor_days),
                'teaching_method'              => TeachingMethodResource::collection($tutor->teaching_method),
                'tutor_experience'             => $tutor->tutor_personal_info->tutoring_experience ?? null,
                'expected_salary'              => $tutor->tutor_personal_info->expected_salary ?? null,
                'available_from'               => $tutor->tutor_personal_info->available_from ?? null,
                'available_to'                 => $tutor->tutor_personal_info->available_to ?? null,
                'reason_hired'                 => $tutor->tutor_personal_info->reason_hired ?? null,
                'preface'                      => $tutor->tutor_personal_info->about_yourself ?? null,
                'experience_in_details'        => $tutor->tutor_personal_info->tutoring_experience_details ?? null,
                'full_address'                 => $tutor->tutor_personal_info->full_address ?? null,
                'permanent_full_address'       => $tutor->tutor_personal_info->permanent_full_address ?? null,
                'tutor_education'              => TutorEducationResource::collection($tutor->tutor_education),

            ];

            $tutor_reviews = $tutor->tutor_reviews()
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($review) {
                return [
                    'parent_name' => $review->parent->name ?? null,
                    'parent_image' => 'https://hellott.xyz/storage/parent-images/' . ($review->parent->image ?? null),
                    'parent_id' => $review->parent->unique_id ?? null,
                    'emp_id' => $review->emp_id ? 'E2' . $review->emp_id .'2A' : null,
                    'rating' => $review->rating,
                    'description' => $review->description,
                    'date' => $review->created_at,
                ];
            });



            $appliedJobCounting     = JobApplication::where('tutor_id',$id)->count();
            $shortlistedjobcount    = JobApplication::where('tutor_id',$id)->where('is_shortlisted',1)->count();
            $appointedJobCounting   = JobApplication::where('tutor_id', $id)->whereNotNull('taken_at')->count();
            $confirm_jobCounting    = JobApplication::where('tutor_id', $id)->whereNotNull('confirm_date')->count();
            $closed_jobCounting     = JobApplication::where('tutor_id', $id)
                                                    ->whereNotNull('closed_date')->count();

            $appliedJob = JobApplication::where('tutor_id', $id)->pluck('job_offer_id');
            $appliedJobOfferDetails = [];

            foreach ($appliedJob as $jobOfferId) {
                $jobOffer = new JobOfferResource($this->jobOfferRepository->single($jobOfferId)->first());
                if ($jobOffer) {
                    $appliedJobOfferDetails[] = $jobOffer;
                }
            }

            $appointedJob  = JobApplication::where('tutor_id', $id)->whereNotNull('taken_at')->get();
            $appointedJobOfferDetails = null;

            foreach ($appointedJob as $jobOfferId) {
                if ($jobOffer) {
                    $appointedJobOfferDetails[] = $jobOffer;
                }
            }

            $confirmJob            = JobApplication::where('tutor_id', $id)->whereNotNull('confirm_date')->get();
            $confirmJobOfferDetails = [];

            foreach ($confirmJob as $jobOfferId) {
                if ($jobOffer) {
                    $confirmJobOfferDetails[] = $jobOffer;
                }
            }

            $closedjob           = JobApplication::where('tutor_id', $id)->whereNotNull('closed_date')->get();
            $closedjobOfferDetails = [];

            foreach ($closedjob as $jobOfferId) {
                if ($jobOffer) {
                    $closedjobOfferDetails[] = $jobOffer;
                }
            }
            $shortlistedjob           = JobApplication::where('tutor_id', $id)
                                                ->where('is_shortlisted',1)->get();
            $shortlistedjobOfferDetails = [];

            foreach ($shortlistedjob as $jobOfferId) {
                if ($jobOffer) {
                    $shortlistedjobOfferDetails[] = $jobOffer;
                }
            }

            $platformStatus = [
                'appliedJobCounting'   => $appliedJobCounting,
                'shortlistedjobcount'  => $shortlistedjobcount,
                'appointedJobCounting' => $appointedJobCounting,
                'confirm_jobCounting'  => $confirm_jobCounting,
                'closed_jobCounting'   => $closed_jobCounting,

            ];

        $bookmarkParents = Bookmark::whereNotNull('parent_id')
                                    ->where('target_id', $tutor->id)
                                    ->pluck('parent_id');

        $bookarkParent = [];
        foreach ($bookmarkParents as $parentId) {
            $bookarkParent[] = ['parent_id' => $parentId];
        }




        return response()->json([
            'tutorData'                  => $tutorData,
            'tutoringInformation'        => $tutoringInformation,
            'platformStatus'             => $platformStatus,
            'appliedJobOfferDetails'     => $appliedJobOfferDetails,
            'appointedJobOfferDetails'   => $appointedJobOfferDetails,
            'confirmJobOfferDetails'     => $confirmJobOfferDetails,
            'closedjobOfferDetails'      => $closedjobOfferDetails,
            'shortlistedjobOfferDetails' => $shortlistedjobOfferDetails,
            'tutor_reviews' => $tutor_reviews,
            'bookarkParent' => $bookarkParent,

        ]);
    }



    public function suggestedTutor(Request $request,$id)
    {
        $per_page = $request->per_page ?? 50;

        $tutor = Tutor::with([
            'tutor_personal_info',
            'tutor_prefered_locations',
            'tutor_education',
            'tutor_categories'
        ])->where('is_active', 1)
        ->where('unique_id', $id)->first(['id']);

        $suggestedTutor = [];


        $tutorEducationSSC = $tutor->tutor_education
            ? $tutor->tutor_education->where('degree_name', "ssc")->pluck('curriculum_id')
            : collect();

        if ($tutorEducationSSC->isNotEmpty()) {
            $tutorsQuery = Tutor::where('is_active', 1)
                ->whereExists(function ($query) use ($tutorEducationSSC) {
                    $query->select(DB::raw(1))
                        ->from('tutor_educations')
                        ->whereColumn('tutor_educations.tutor_id', 'tutors.id')
                        ->where('degree_name', 'ssc')
                        ->whereIn('curriculum_id', $tutorEducationSSC);
                })
                ->orderByRaw('
                    is_premium_advance DESC,
                    is_premium_pro DESC,
                    is_premium DESC,
                    RAND()
                ');

            $tutors = $tutorsQuery->paginate($per_page);
        } else {
            $tutors = collect();
        }
        $suggestedTutor = $tutors->map(function ($tutor) {
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
                'tutorprofile'     => $tutor->getProfileComplete(),
            ];
        });


        return response()->json([
            'suggested_tutors' => $suggestedTutor,
            'meta' => [
                'current_page' => $tutors->currentPage(),
                'per_page' => $tutors->perPage(),
                'total' => $tutors->total(),
            ],
            'requested_data' => $request->all(),
        ]);
    }



    public function getTutorCounting()
    {
        $cacheKey = 'tutor_counting_data';
        $cacheDuration = 6 * 60;

        $cachedData = Cache::remember($cacheKey, $cacheDuration, function () {
            $dhaka        = TutorPersonalInfo::where('city_id', 1)->count();
            $chittagong   = TutorPersonalInfo::where('city_id', 3)->count();
            $sylhet       = TutorPersonalInfo::where('city_id', 7)->count();
            $Rajshahi     = TutorPersonalInfo::where('city_id', 11)->count();
            $Barishal     = TutorPersonalInfo::where('city_id', 12)->count();
            $Khulna       = TutorPersonalInfo::where('city_id', 13)->count();
            $Rangpur      = TutorPersonalInfo::where('city_id', 10)->count();
            $Mymensingh   = TutorPersonalInfo::where('city_id', 9)->count();
            $Gazipur      = TutorPersonalInfo::where('city_id', 4)->count();
            $Manikganj    = TutorPersonalInfo::where('city_id', 32)->count();
            $Narayanganj  = TutorPersonalInfo::where('city_id', 5)->count();
            $Narsingdi    = TutorPersonalInfo::where('city_id', 18)->count();
            $Tangail      = TutorPersonalInfo::where('city_id', 24)->count();
            $Bogra        = TutorPersonalInfo::where('city_id', 14)->count();
            $Pabna        = TutorPersonalInfo::where('city_id', 26)->count();
            $Dinajpur     = TutorPersonalInfo::where('city_id', 25)->count();
            $Thakurgaon   = TutorPersonalInfo::where('city_id', 46)->count();
            $Patuakhali   = TutorPersonalInfo::where('city_id', 68)->count();
            $Brahmanbaria = TutorPersonalInfo::where('city_id', 20)->count();
            $Chandpur     = TutorPersonalInfo::where('city_id', 40)->count();
            $Cumilla      = TutorPersonalInfo::where('city_id', 8)->count();
            $Coxbazar     = TutorPersonalInfo::where('city_id', 30)->count();
            $Noakhali     = TutorPersonalInfo::where('city_id', 19)->count();
            $Feni         = TutorPersonalInfo::where('city_id', 16)->count();
            $Jashore      = TutorPersonalInfo::where('city_id', 17)->count();
            $Savar        = TutorPersonalInfo::where('city_id', 6)->count();

            return [
                'dhaka'              => $dhaka,
                'chittagong'         => $chittagong,
                'sylhet'             => $sylhet,
                'Rajshahi'           => $Rajshahi,
                'Barishal'           => $Barishal,
                'Khulna'             => $Khulna,
                'Rangpur'            => $Rangpur,
                'Mymensingh'         => $Mymensingh,
                'Gazipur'            => $Gazipur,
                'Manikganj'          => $Manikganj,
                'Narayanganj'        => $Narayanganj,
                'Narsingdi'          => $Narsingdi,
                'Tangail'            => $Tangail,
                'Bogra'              => $Bogra,
                'Pabna'              => $Pabna,
                'Dinajpur'           => $Dinajpur,
                'Thakurgaon'         => $Thakurgaon,
                'Patuakhali'         => $Patuakhali,
                'Brahmanbaria'       => $Brahmanbaria,
                'Chandpur'           => $Chandpur,
                'Cumilla'            => $Cumilla,
                'Coxbazar'           => $Coxbazar,
                'Noakhali'           => $Noakhali,
                'Feni'               => $Feni,
                'Jashore'            => $Jashore,
                'Savar'              => $Savar,
            ];
        });

        return response()->json($cachedData);
    }







}