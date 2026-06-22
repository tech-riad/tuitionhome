<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseSubject;
use App\Models\Institute;
use App\Models\Subject;
use Illuminate\Http\Request;
use Exception;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;

class CategoryCourseSubjectController extends Controller
{
    use ApiResponse;
    public function getCategory()
    {
        try{

            $category = Category::orderBy('id','asc')->get();
            if (count($category) > 0 )
            {
                return response()->json(['status'=>true,'message'=>'All Category get Successfully!','data'=>$category]);
            }else
            {
                return response()->json(['status'=>false,'message'=>'Category Not Found!']);
            }

        }catch(Exception $e)
        {
            return $this->resposeError('',$e->getMessage());
        }


    }

    public function getCourse($id)
    {

         $id = (explode(",",$id));

        try{

            if ($id)
            {
                $get_courses = Course::whereIN('category_id',$id)->orderBy('id','asc')->get();

                //  return $get_courses;
                $course_with_cat = [];

                 foreach ($get_courses as $co) {
                $course_info = [];
                $course_info['course_id'] = $co->id;
                $course_info['course_name'] = $co->name;
                $course_info['category_id'] = $co->category_id;
                $course_info['category_name'] = $co->category->name;
                $course_info['course_image'] = $co->course_image;
                $course_with_cat[] = $course_info;
                   }

                   if (count($get_courses) > 0 )
                {
                    return response()->json(['status'=>true,'message'=>'All Course get Successfully!','data'=>$course_with_cat]);
                }else
                {
                    return response()->json(['status'=>false,'message'=>'Course Not Found!']);
                }
            }else
            {
                return response()->json(['status'=>false,'message'=>'Category Id Not Found!']);
            }

        }catch(Exception $e)
        {
            return $this->resposeError('',$e->getMessage());
        }


    }

    public function getSubject($id)
    {
        $id = explode(",", $id);

        try {
            if ($id) {
                $get_subject = CourseSubject::with(['subject', 'course.category'])
                                            ->whereIn('course_id', $id)
                                            ->get();

                $subject_with_course = [];

                foreach ($get_subject as $s) {
                    // Skip if subject or subject title is 'Error'
                    if (!$s->subject || $s->subject->title === 'Error') {
                        continue;
                    }

                    $subject_info = [
                        'subject_id'    => $s->id,
                        'subject_name'  => $s->subject->title,
                        'course_id'     => $s->course_id,
                        'course_name'   => optional($s->course)->name,
                        'category_id'   => optional($s->course)->category_id,
                        'category_name' => optional(optional($s->course)->category)->name,
                    ];

                    $subject_with_course[] = $subject_info;
                }

                if (count($subject_with_course) > 0) {
                    return response()->json([
                        'status'  => true,
                        'message' => 'All Subject get Successfully!',
                        'data'    => $subject_with_course
                    ]);
                } else {
                    return response()->json(['status' => false, 'message' => 'Subject Not Found!']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Course Id Not Found!']);
            }
        } catch (Exception $e) {
            return $this->resposeError('', $e->getMessage());
        }
    }


    public function getInstitute()
    {
        try{

            $institute = Institute::orderBy('title','asc')->get();
            if (count($institute) > 0)
            {
                return response()->json(['status'=>true,'message'=>'All Institute get Successfully!','data'=>$institute]);
            }else
            {
                return response()->json(['status'=>false,'message'=>'Institute Not Found!']);
            }

        }catch(Exception $e)
        {
            return $this->resposeError('',$e->getMessage());
        }

    }


    public function getCatCourse()
    {
        $categoriesData = [];

        $categories = Category::all();

        foreach ($categories as $category) {
            $categoryData = [
                'id' => $category->id,
                'name' => $category->name,
                'subjects' => $this->getCourse($category->id)
            ];

            $categoriesData[] = $categoryData;
        }

        return response()->json([
            'categoriesCourseData' => $categoriesData,
        ]);
    }

    public function getCourses()
    {
        $courses = DB::table('courses')
            ->select('courses.*', 'categories.name as category_name')
            ->leftJoin('categories', 'courses.category_id', '=', 'categories.id')
            ->inRandomOrder()
            ->take(20)
            ->get();


            return response()->json([
                'courses' => $courses,
            ]);
    }
}
