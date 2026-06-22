<?php

namespace App\Http\Controllers;

use App\Imports\CourseSubjectImport;
use App\Models\Course;
use App\Models\CourseSubject;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Maatwebsite\Excel\Facades\Excel;

class CourseSubjectController extends Controller
{
    public function courseSubjectsSearch(Request $request)
    {
        $search = $request->input('search');

        $courseSubjects = CourseSubject::with(['course', 'subject'])
            ->whereHas('course', function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%');
            })
            ->orWhereHas('subject', function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%');
            })
            ->paginate(10);

        return view('backend.config.coursesubject.index', compact('courseSubjects'));
    }

    public function index()
    {
        $courseSubjects = CourseSubject::with(['course','subject'])->paginate(10);

        return view('backend.config.coursesubject.index',compact('courseSubjects'));
    }
    public function create()
    {
        $courses = Course::orderBy('name','ASC')->get();
        $subjects = Subject::orderBy('title','ASC')->get();

        
        return view('backend.config.coursesubject.create',compact('courses','subjects'));
    }
    public function store(Request $request)
    {
       $course_subjects = new CourseSubject();
       $course_subjects->course_id = $request->course_id;
       $course_subjects->subject_id = $request->subject_id;
       $course_subjects->added_by = Auth::user()->id;
       $course_subjects->save();
       return redirect()->back()->with('success','Course Subject Save Successfully');
    }
    public function edit($id)
    {
        $courses = Course::orderBy('name','ASC')->get();
        $subjects = Subject::orderBy('title','ASC')->get();
        $courseSubject = CourseSubject::find($id);
        return view('backend.config.coursesubject.edit',compact('courseSubject','courses','subjects'));
    }
    public function update(Request $request,$id)
    {
        $updateSubjectCourse = CourseSubject::find($id);
        $updateSubjectCourse->course_id = $request->course_id;
        $updateSubjectCourse->subject_id = $request->subject_id;
        $updateSubjectCourse->update_by = Auth::user()->id;
        $updateSubjectCourse->save();
        return redirect()->route('course_subject.index')->with('upsuccess','Course Subject Update Successfully');
    }

    public function delete($id)
    {
        $courseSubjectDelete = CourseSubject::find($id);
        $courseSubjectDelete->delete();
        return redirect()->route('course_subject.index')->with('deletecourseSubject','Course Subject Delete Successfully');
    }
    public function importCourseSubject(Request $request)
    {
        $request->validate([
            'import_course_subjects'=>'required|file|mimes:csv',
        ]);

        Excel::import(new CourseSubjectImport(),$request->file('import_course_subjects'));
        Flash::success('Course Subject Imported successfully.');
        return redirect()->back();
    }

    public function get_course_subject(Request $request)
    {

        $course_ids = $request->course_id;
        if(is_array($course_ids))
        {
            $course_subjects = CourseSubject::with('subject')
            ->whereIn('course_id',$course_ids)->get();

        $html = '<option>~ select subject ~</option>';
        foreach ($course_subjects as $course_subject)
        {
            $html.='<option value="'.$course_subject->id.'">'.@$course_subject->subject->title.' ('.@$course_subject->course->name.')'.'</option>';
        }

        echo $html;
        }else
        {
            $course_subjects = CourseSubject::with('subject')
            ->where('course_id',$course_ids)->get();

        $html = '<option>~ select subject ~</option>';
        foreach ($course_subjects as $course_subject)
        {
            $html.='<option value="'.$course_subject->id.'">'.@$course_subject->subject->title.' ('.@$course_subject->course->name.')'.'</option>';
        }

        return $html;

        }

    }
}
