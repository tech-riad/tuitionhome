<?php

namespace App\Http\Controllers\Backend\Tutor;

use App\Http\Controllers\Controller;
use App\Models\InactiveTutor;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InactiveTutorController extends Controller
{
    public function index(Request $request)
    {

        $all_tutor_count       = DB::table('tutors')->count();
        $male_tutor_count      = Tutor::where('gender', 'male')->where('is_active',1)->count();
        $female_tutor_count    = Tutor::where('gender', 'female')->where('is_active',1)->count();
        $premium_tutor_count   = Tutor::where('is_premium', '=', 1)->where('is_active',1)->count();
        $featured_tutor_count  = Tutor::where('is_featured', '=', 1)->where('is_active',1)->count();

        $uniqueTutorsTakenToday = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT tutor_id) AS unique_tutors_taken_today'))
        ->whereDate('taken_at', now())
        ->first();
        $uniqueTutorsShortlistedToday = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT tutor_id) AS unique_tutors_shortlisted_today'))
        ->whereDate('shortlisted_date', now())
        ->first();
        $unique_tutors_confirmed = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT tutor_id) AS unique_tutors_confirmed'))
        ->whereNotNull('confirm_date')
        ->first();
        $unique_tutors_applied = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT tutor_id) AS unique_tutors_applied'))
        ->first();
        $all_tutor_confirm = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT tutor_id) AS unique_tutors_confirm'))
        ->where('current_stage','confirm')
        ->count();


        $input = $request->input('pagination_limit') ?? 50;

        $tutors = InactiveTutor::with([
            'tutor_personal_info',
            'tutor_education',
            'tutor_prefered_locations',
            'tutor_course',
            'tutor_subject',
            'tutor_categories',
            'tutor_days',
            'teaching_method',
        ])->orderBy('id', 'desc')->paginate(50);

        return view('backend.tutor.inactivetutor', compact('tutors', 'all_tutor_count', 'male_tutor_count',
            'female_tutor_count', 'premium_tutor_count', 'featured_tutor_count', 'input','uniqueTutorsShortlistedToday','uniqueTutorsTakenToday'
            ,'unique_tutors_confirmed','unique_tutors_applied','all_tutor_confirm'));
    }
}
