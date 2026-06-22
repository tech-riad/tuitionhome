<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use App\Models\PwaDownload;
use App\Models\TutorEducation;
use App\Models\TutorTypeUniversity;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pwaCounting = PwaDownload::first();


        return view('home',compact('pwaCounting'));
    }

    public function dashboard()
    {
        $pwaCounting = PwaDownload::first();
        return view('dashboard.tutor.tutor-dashboard',compact('pwaCounting'));
    }
    public function crop()
    {
        return view('image-crop');
    }
    public function instituteChange()
    {
        $institutes       = Institute::orderBy('id', 'desc')->get();
        return view('backend.setting.ins_change',compact('institutes'));
    }



    public function updateInstitute(Request $request){
        $validated = $request->validate([
            'frominstitute' => 'required',
            'toinstitute' => 'required',
        ]);
        $from = $request->frominstitute;
        $to = $request->toinstitute;
        if($from == $to){
            return redirect()->back()->with('success', 'Institute Changed for 0 tutors! You selected same institute for both!');
        }
        $affected = TutorEducation::where('institute_id', $from)->update(['institute_id'=> $to]);
        Institute::destroy($from);
        return redirect()->back()->with('success', 'Institute Changed for '. $affected .' tutors!');
    }
}
