<?php

namespace App\Http\Controllers;

use App\Models\CategoryReview;
use App\Models\Course;
use App\Models\CourseBlogPost;
use App\Models\Institute;
use App\Models\Tutor;
use App\Transformers\TutorEducationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseBlogPostController extends Controller
{
    public function courseBlog()
    {
        $blogposts = CourseBlogPost::paginate(10);
        return view('backend.blog.blog_course.index',compact('blogposts'));
    }
    public function createCourseBlog()
    {

        $existingCourseIds = CourseBlogPost::pluck('course_id')->toArray();
        $courses = Course::orderBy('id', 'desc')
                ->whereNotIn('id', $existingCourseIds)
                ->get();
        return view('backend.blog.blog_course.create',compact('courses'));
    }
    public function storeCourseBlog(Request $request)
    {
        $request->validate([
            'learn_category' => 'required',
            'slider_image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'course_id' => 'required',
            'tags' => 'required',
        ]);

        if (CourseBlogPost::where('course_id', $request->course_id)->exists()) {
            return response()->json(['success' => 'Course Id Already Exists'], 422);
        }

        $course = new CourseBlogPost();
        $course->learn_category = $request->learn_category;
        $course->about_category_first = $request->about_category_first;
        $course->about_category_second = $request->about_category_second;
        $course->course_id = $request->course_id;
        $course->tags = $request->tags;

        $images = [];

        if ($request->hasFile('slider_image')) {

            foreach ($request->file('slider_image') as $image) {

                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Upload to R2
                Storage::disk('r2')->putFileAs(
                    'course-blog-images',
                    $image,
                    $imageName
                );

                $images[] = $imageName;
            }
        }

        $course->slider_image = json_encode($images);

        $course->save();

        return redirect()->route('blog.course')->withMessage('Successfully Created!');
    }

    public function editCourseBlog($id)
    {
        $courseBlog = CourseBlogPost::findOrFail($id);

        $courses = Course::orderBy('id', 'desc')
                  ->get();

        return view('backend.blog.blog_course.edit',compact('courseBlog','courses'));

    }

    public function updateCourseBlog(Request $request, $id)
    {
        try {

            $course = CourseBlogPost::findOrFail($id);

            $request->validate([
                'learn_category' => 'required',
                'about_category_first' => 'required',
                'about_category_second' => 'required',
                'slider_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $course->learn_category = $request->learn_category;
            $course->about_category_first = $request->about_category_first;
            $course->about_category_second = $request->about_category_second;
            $course->tags = $request->tags;

            if ($request->hasFile('slider_image')) {

                // Delete old images from R2
                if (!empty($course->slider_image)) {

                    foreach (json_decode($course->slider_image, true) as $oldImage) {
                        Storage::disk('r2')->delete('course-blog-images/' . $oldImage);
                    }
                }

                $images = [];

                foreach ($request->file('slider_image') as $image) {

                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                    Storage::disk('r2')->putFileAs(
                        'course-blog-images',
                        $image,
                        $imageName
                    );

                    $images[] = $imageName;
                }

                $course->slider_image = json_encode($images);
            }

            $course->save();

            return response()->json([
                'success' => 'Course updated successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // Api For Frontend
    public function courseBlogDetails($id)
    {
        $course = CourseBlogPost::where('course_id', $id)->first();

        if (!$course) {
            return response()->json([
                'data' => [],
            ]);
        }

        // Slider Images
        $images = [];

        if (!empty($course->slider_image)) {
            foreach (json_decode($course->slider_image, true) as $image) {
                $images[] = Storage::disk('r2')->url('course-blog-images/' . $image);
            }
        }

        $data = [
            'courseId'      => $course->course_id,
            'courseName'    => optional($course->courses)->name,
            'image'         => $images,
            'learnCategory' => $course->learn_category,
            'aboutCategory' => $course->about_category_first,
            'shortDesc'     => $course->about_category_second,
            'tags'          => $course->tags,
        ];

        $reviews = CategoryReview::where('category_id', $id)
            ->orderBy('id', 'desc')
            ->get();

        $reviewData = $reviews->map(function ($review) {

            return [
                'parent_id' => optional($review->parent)->unique_id,
                'parent_name' => optional($review->parent)->name,
                'parent_image' => optional($review->parent)->image
                    ? Storage::disk('r2')->url('parent-images/' . $review->parent->image)
                    : null,
                'emp_id' => $review->emp_id,
                'description' => $review->description,
                'rating' => $review->rating,
                'date' => $review->created_at,
            ];
        });

        return response()->json([
            'data' => $data,
            'categoryReviews' => $reviewData,
        ], 200, [], JSON_UNESCAPED_SLASHES);
    }


    public function suggestedTutor($courseId)
    {
        $tutorIds = Tutor::where('is_active', 1)
            ->whereHas('tutor_geTcourses', function ($subQuery) use ($courseId) {
                $subQuery->where('course_id', $courseId);
            })
            ->orderByRaw('
                CASE
                        WHEN is_boost = 1 AND boost_package = 1 AND boost_date >= CURDATE() - INTERVAL 15 DAY THEN 1
                        WHEN is_boost = 1 AND boost_package = 3 AND boost_date >= CURDATE() - INTERVAL 30 DAY THEN 1
                        WHEN is_boost = 1 AND boost_package = 6 AND boost_date >= CURDATE() - INTERVAL 60 DAY THEN 1
                        WHEN is_boost = 1 AND boost_package = 12 AND boost_date >= CURDATE() - INTERVAL 90 DAY THEN 1
                        WHEN is_premium_advance = 1 AND premium_date >= CURDATE() - INTERVAL 60 DAY THEN 2
                        WHEN is_premium_pro = 1 AND premium_date >= CURDATE() - INTERVAL 45 DAY THEN 3
                        WHEN is_premium = 1 AND premium_date >= CURDATE() - INTERVAL 30 DAY THEN 4
                        ELSE 5
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
            ->take(20)
            ->pluck('id');


        $tutorData = [];

        foreach ($tutorIds as $tutorId) {
            $tutor = Tutor::with(['tutor_personal_info.city', 'tutor_education'])
                ->find($tutorId);

            if ($tutor) {
                $tutorData[] = [
                    'id'                   => $tutor->id,
                    'unique_id'            => $tutor->unique_id,
                    'tutor_name'           => $tutor->name,
                    'tutor_gender'         => $tutor->gender,
                    'tutor_image'          => $tutor->image
                                                ? Storage::disk('r2')->url('tutor-images/' . $tutor->image)
                                                : null,
                    'is_premium'           => $tutor->is_premium,
                    'is_premium_pro'       => $tutor->is_premium_pro,
                    'is_premium_advance'   => $tutor->is_premium_advance,
                    'is_verified'          => $tutor->is_verified,
                    'is_featured'          => $tutor->is_featured,
                    'tutor_location'       => optional($tutor->tutor_personal_info->city)->name,
                    'tutor_education'      => TutorEducationResource::collection($tutor->tutor_education),
                ];
            }
        }
        return response()->json([
            'tutors' => $tutorData,
        ]);
    }

    public function relatedCourses()
    {
        $courseIds = Course::inRandomOrder()
            ->whereNotNull('course_image')
            ->take(10)
            ->pluck('id');

        $courseData = [];

        foreach ($courseIds as $key => $courseId) {

            $course = Course::find($courseId);

            if ($course) {

                $courseData[] = [
                    'id'    => $course->id,
                    'name'  => $course->name,
                    'image' => $course->course_image
                        ? Storage::disk('r2')->url('course-images/' . $course->course_image)
                        : null,
                ];
            }
        }

        return response()->json([
            'courseData' => $courseData,
        ], 200, [], JSON_UNESCAPED_SLASHES);
    }

    public function filterCourseTutor( Request $request)
    {
        $input              = $request->input('pagination_limit') ?? 30;
        $countryId          = $request->country_id;
        $cityId             = $request->city_id;
        $locationId         = $request->location_id;
        $universityId       = $request->university_id;
        $departmentId       = $request->department_id;
        $gender             = $request->gender;
        $schoolId           = $request->school_id;
        $collegeId          = $request->college_id;
        $sscGroup           = $request->ssc_group;
        $sscBoard           = $request->ssc_board;
        $sscCurriculam      = $request->ssc_curriculam_id;
        $tutorCourse        = $request->course_id;
        $tutorRelegion      = $request->religion;

        $tutorsQuery = Tutor::where('is_active', 1);

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
        if ($tutorRelegion !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($tutorRelegion) {
                $subQuery->where('religion', $tutorRelegion);
            });
        }
        if ($universityId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($universityId) {
                $subQuery->where('institute_id', $universityId);
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
        if ($tutorCourse !== null) {
            $tutorsQuery->whereHas('tutor_geTcourses', function ($query) use ($tutorCourse) {
                $query->where('course_id', $tutorCourse);
            });
        }

        $tutors = $tutorsQuery->orderBy('id', 'desc')->paginate($input);
        $courseName = Course::where('id',$tutorCourse)->first();
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
                'id'                 => $tutor->id,
                'unique_id'          => $tutor->unique_id,
                'tutor_image'        => $tutor->image
                    ? Storage::disk('r2')->url('tutor-images/' . $tutor->image)
                    : null,
                'tutor_name'         => $tutor->name,
                'tutor_gender'       => $tutor->gender,
                'is_premium'         => $tutor->is_premium,
                'is_premium_pro'     => $tutor->is_premium_pro,
                'is_premium_advance' => $tutor->is_premium_advance,
                'is_verified'        => $tutor->is_verified,
                'is_featured'        => $tutor->is_featured,
                'tutor_location'   => $tutor->tutor_personal_info->city->name ?? null,
                'tutor_university'   => $tutorUniversity,
                'tutor_college'      => $tutorHsc,
            ];
        }
        return response()->json([
            'filteredData' => $tutorData,
            'meta' => [
                'current_page' => $tutors->currentPage(),
                'per_page'     => $tutors->perPage(),
                'total'        => $tutors->total(),
                'courseName'   => optional($courseName)->name,
            ],
            'requested_data' => $request->all(),
        ], 200, [], JSON_UNESCAPED_SLASHES);


    }

    public function getCourseTutor($courseId)
    {
        $tutorsQuery = Tutor::with([
            'tutor_education',
            'tutor_personal_info',
            'tutor_prefered_locations',
        ])
        ->where('is_active', 1)
        ->whereHas('tutor_geTcourses', function ($subQuery) use ($courseId) {
                $subQuery->where('course_id', $courseId);
        });

        $tutors = $tutorsQuery
        ->orderByRaw('
            CASE
                        WHEN is_boost = 1 AND boost_package = 1 AND boost_date >= CURDATE() - INTERVAL 15 DAY THEN 1
                        WHEN is_boost = 1 AND boost_package = 3 AND boost_date >= CURDATE() - INTERVAL 30 DAY THEN 1
                        WHEN is_boost = 1 AND boost_package = 6 AND boost_date >= CURDATE() - INTERVAL 60 DAY THEN 1
                        WHEN is_boost = 1 AND boost_package = 12 AND boost_date >= CURDATE() - INTERVAL 90 DAY THEN 1
                        WHEN is_premium_advance = 1 AND premium_date >= CURDATE() - INTERVAL 60 DAY THEN 2
                        WHEN is_premium_pro = 1 AND premium_date >= CURDATE() - INTERVAL 45 DAY THEN 3
                        WHEN is_premium = 1 AND premium_date >= CURDATE() - INTERVAL 30 DAY THEN 4
                        ELSE 5
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
        ->orderBy('id', 'desc')
        ->paginate(36);





        $tutorData = [];

        foreach ($tutors as $tutor) {


            if ($tutor) {
                $tutorData[] = [
                    'id'               => $tutor->id,
                    'unique_id'        => $tutor->unique_id,
                    'tutor_name'       => $tutor->name,
                    'tutor_gender'     => $tutor->gender,
                    'tutor_image'        => $tutor->image
                    ? Storage::disk('r2')->url('tutor-images/' . $tutor->image)
                    : null,
                    'is_premium'       => $tutor->is_premium,
                    'is_premium_pro'     => $tutor->is_premium_pro,
                    'is_premium_advance' => $tutor->is_premium_advance,
                    'is_verified'      => $tutor->is_verified,
                    'is_featured'      => $tutor->is_featured,
                    'is_boost'      => $tutor->is_boost,
                    'tutor_location'   => $tutor->tutor_personal_info->city->name ?? null,
                    'tutor_education'  => TutorEducationResource::collection($tutor->tutor_education),
                ];
            }
        }

        $courseName = Course::where('id',$courseId)->first();



        return response()->json([
            'tutors'       => $tutorData,
            'meta'      => [
                'page' => $tutors->currentPage(),
                'per_page'     => 36,
                'total'        => $tutors->total(),
                'courseId'       => $courseId,
                'courseName'       => $courseName->name,
            ],
        ]);

    }



}


