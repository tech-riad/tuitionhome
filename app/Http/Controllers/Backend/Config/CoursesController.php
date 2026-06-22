<?php

namespace App\Http\Controllers\Backend\Config;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateCoursesRequest;
use App\Http\Requests\UpdateCoursesRequest;
use App\Imports\CourseImport;
use App\Models\Course;
use App\Repositories\CoursesRepository;
use Flash;
use Hamcrest\Arrays\IsArray;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Response;
use Illuminate\Support\Facades\Storage;
class CoursesController extends AppBaseController
{
    /** @var CoursesRepository $coursesRepository*/
    private $coursesRepository;

    public function __construct(CoursesRepository $coursesRepo)
    {
        $this->coursesRepository = $coursesRepo;
    }

    /**
     * Display a listing of the Course.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function coursesSearch(Request $request)
    {
        $search = $request->input('search');

        $courses = Course::where('courses.name', 'LIKE', '%' . $search . '%') 
                ->select('courses.*', 'categories.name as category_name')
                ->leftJoin('categories', 'courses.category_id', '=', 'categories.id')
                ->paginate(10);

        return view('backend.config.courses.index', compact('courses'));
    }

    public function index(Request $request)
    {
        $courses = DB::table('courses')
            ->select('courses.*','categories.name as category_name')
            ->leftJoin('categories','courses.category_id','categories.id')
            ->paginate(10);
        return view('backend.config.courses.index')->with('courses', $courses);
    }

    /**
     * Show the form for creating a new Course.
     *
     * @return Response
     */
    public function create()
    {

        return view('backend.config.courses.create');
    }

    /**
     * Store a newly created Course in storage.
     *
     * @param CreateCoursesRequest $request
     *
     * @return Response
     */
    public function store(CreateCoursesRequest $request)
    {
        $input = $request->all();

        $courses = $this->coursesRepository->create($input);

        Flash::success('Course saved successfully.');

        return redirect(route('courses.index'));
    }

    /**
     * Display the specified Course.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $courses = $this->coursesRepository->find($id);

        if (empty($courses)) {
            Flash::error('Course not found');

            return redirect(route('courses.index'));
        }

        return view('backend.config.courses.show')->with('courses', $courses);
    }

    /**
     * Show the form for editing the specified Course.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        $courses = $this->coursesRepository->find($id);

        if (empty($courses)) {
            Flash::error('Course not found');

            return redirect(route('courses.index'));
        }

        return view('backend.config.courses.edit')->with('courses', $courses);
    }

    /**
     * Update the specified Course in storage.
     *
     * @param int $id
     * @param UpdateCoursesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCoursesRequest $request)
    {
        $course = $this->coursesRepository->find($id);

        if (empty($course)) {
            Flash::error('Course not found');
            return redirect(route('courses.index'));
        }

        if ($request->hasFile('course_image')) {
            if ($course->course_image) {
                Storage::delete('public/course-images/' . $course->course_image);
            }

            $file = $request->file('course_image');
            $image_name = $id . '_' . rand(1000, 9999) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/course-images', $image_name);

            // dd($image_name);

            $course->course_image = $image_name;
        }

        $course->fill($request->all())->save();
        $course->course_image = $image_name;

        $course->update();

        Flash::success('Course updated successfully.');

        return redirect(route('courses.index'));
    }




    /**
     * Remove the specified Course from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $courses = $this->coursesRepository->find($id);

        if (empty($courses)) {
            Flash::error('Course not found');

            return redirect(route('courses.index'));
        }

        $this->coursesRepository->delete($id);

        Flash::success('Course deleted successfully.');

        return redirect(route('courses.index'));
    }

    public function importCourse(Request $request)
    {
        $request->validate([
            'import_course'=>'required|file|mimes:csv',
        ]);

//    Excel::import(new CountryImport,$request->file('import_country'));
        Excel::import(new CourseImport(),$request->file('import_course'));
        Flash::success('Course Imported successfully.');
        return redirect()->back();
    }

    public function get_class_course(Request $request)
    {
        $category_ids = $request->category_id;

            if(is_array($category_ids))
            {
                $courses = Course::whereIn('category_id',$category_ids)->with('category')->orderBy('name','asc')->get();

                $html = "<option value='' >~select Course~</option>";
                foreach ($courses as $course)
                {
                    // html+=`<option value="`+loc.id+`" data-select2-id="`+loc.id+`">`+loc.name+`</option>`;
                    $html.='<option value="'.$course->id.'">'.$course->name.' ('.$course->category->name.')'.'</option>';

                }
                echo $html;
            }else
            {
                $courses = Course::where('category_id',$category_ids)->with('category')->orderBy('name','asc')->get();

                $html = "<option value='' >~select Course~</option>";
                foreach ($courses as $course)
                {
                    $html.='<option value="'.$course->id.'">'.$course->name.' ('.$course->category->name.')'.'</option>';

                }
                echo $html;
            }



    }
}
