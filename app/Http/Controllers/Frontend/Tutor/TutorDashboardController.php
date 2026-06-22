<?php

namespace App\Http\Controllers\Frontend\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Course;
use App\Models\CourseSubject;
use App\Models\Day;
use App\Models\Department;
use App\Models\Institute;
use App\Models\Location;
use App\Models\Subject;
use App\Models\TeachingMethod;
use App\Models\Tutor;
use App\Models\TutorCategory;
use App\Models\TutorCourse;
use App\Models\TutorPersonalInfo;
use App\Models\TutorPreferedLocation;
use App\Models\TutorSubject;
use App\Models\TutorTeachingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutorDashboardController extends Controller
{

    public function index()
    {

        $t_user = Auth::guard('tutor')->user();
        $tutor = TutorPersonalInfo::with('t_user')->where('tutor_id',$t_user->id)->first();
        $countries = Country::orderBy('name','ASC')->get();
        $institutes = Institute::orderBy('title','ASC')->get();
        $departments = Department::orderBy('title','ASC')->get();
        return view('dashboard.tutor.tutor-dashboard',compact('countries','institutes','departments','tutor'));
    }
    public function profileUpdateView()
    {
        $t_user = Auth::guard('tutor')->user();
        $tutor = TutorPersonalInfo::with('t_user')->where('tutor_id',$t_user->id)->first();
        $countries      = Country::orderBy('name','ASC')->get();
        $cities         = City::orderBy('name','ASC')->get();
        $locations      = Location::orderBy('name','ASC')->get();
        $institutes     = Institute::orderBy('title','ASC')->get();
        $departments     = Department::orderBy('title','ASC')->get();
        $categories      = Category::orderBy('name','ASC')->get();
        $courses         = Course::orderBy('name','ASC')->get();
        $tutor_teaching_methods = TeachingMethod::orderBy('name','ASC')->get();
        $days            = Day::orderBy('title','ASC')->get();
        $subjects  = Subject::orderBy('title','ASC')->get();
        $preferred_locations = TutorPreferedLocation::where('tutor_id',$t_user->id)->get();
        $tutor_info = Tutor::with(['tutor_personal_info','tutor_education','tutor_categories','tutor_course','tutor_subject','tutor_prefered_locations','tutor_days','teaching_method'])->where('id',$t_user->id)->first();
//        return $tutor_info->getProfileComplete;
        return view('dashboard.tutor.pages.profile-update',
            compact('tutor','days','countries','institutes','departments',
            'categories','tutor_info','cities','locations','courses',
            'subjects','tutor_teaching_methods','preferred_locations'));
    }

}
