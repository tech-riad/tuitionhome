<?php

namespace App\Http\Controllers\Frontend\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Country;
use App\Models\CropImage;
use App\Models\Curriculam;
use App\Models\Department;
use App\Models\Institute;
use App\Models\Study;
use App\Models\Tutor;
use App\Models\TutorCategory;
use App\Models\TutorCourse;
use App\Models\TutorDay;
use App\Models\TutorEducation;
use App\Models\TutorLog;
use App\Models\TutorPersonalInfo;
use App\Models\TutorPreferedLocation;
use App\Models\TutorSubject;
use App\Models\TutorTeachingMethod;
use App\Models\TutorTypeUniversity;
use App\TutorModule\Tutor_Crediantial;
use App\TutorModule\Tutor_Education_info;
use App\TutorModule\TutorCertificate;
use App\TutorModule\Tutoring_Info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmailOtp;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class TutorController extends Controller
{

    public function index()
    {
        $countries = Country::orderBy('name','ASC')->get();
        $institutes = Institute::orderBy('title','ASC')->get();
        $departments = Department::orderBy('title','ASC')->get();
        return view('frontend.tutor.personal-info',compact('countries','institutes','departments'));
    }

    public function store(Request $request)
    {
        $tutorInfo = new Tutoring_Info();
        if (Auth::guard('tutor')->user())
        {
            $tutor = Tutor::find(Auth::guard('tutor')->user()->id);
             $tutor->give_personal_info = 'yes';
            $tutor->save();

        if ($request->country)
        {       $tutor_personal_info = new TutorPersonalInfo();
                    $tutor_personal_info->tutor_id = $tutor->id;
                    $tutor_personal_info->country_id = $request->country;
                    $tutor_personal_info->city_id = $request->city;
                    $tutor_personal_info->location_id = $request->location;
                    $tutor_personal_info->save();

        }
        if ($request->preferable_locations)
        {
            foreach ($request->preferable_locations as $prelocation)
            {
                $tutorInfo->preferredLocation($tutor->id,$prelocation);

            }


        }
        if ($request->institute)
        {

                $tutordefult = new TutorTypeUniversity();
                $tutordefult->tutor_id = $tutor->id;
                $tutordefult->university = $request->institute;
                $tutordefult->department_id = $request->department;
                $tutordefult->save();

        }
        elseif ($request->institute_name)
        {
            $tutordegree = new TutorEducation();
            $tutordegree->tutor_id = $tutor->id;
            $tutordegree->institute_id = $request->institute_name;
            $tutordegree->department_id = $request->department;
            $tutordegree->save();
        }


    }
        return response()->json(['message'=>'Registration successfully']);


    }


    public function tutoring_info(Request $request)
    {

        $tutor_id = Auth::guard('tutor')->user();
        $tutor_id->tutor_prefered_locations()->sync($request->preferred_location);
        $tutor_id->tutor_days()->sync($request->available_day);
        $tutor_id->teaching_method()->sync($request->preferred_teaching_method);
        $tutor_id->tutor_categories()->sync($request->tutoring_category);
        $tutor_id->tutor_course()->sync($request->tutoring_class_course);
        $tutor_id->course_subjects()->sync($request->favourite_subject);

        $tutorInfo = new Tutoring_Info();
        $tutorInfo->tutor_information($request,$tutor_id);
        $message =['success'=> 'tutoring Information update successfully'];
        return response()->json($message);


    }

    public function education_info()
    {
        $tutor = profile_pic();
        $tutor_id = Auth::guard('tutor')->user()->id;
        $schools = Institute::where('type','school')->orWhere('type', 'school and college')->where('approved', '1')->OrderBy('title','asc')->get();
        $colleges = Institute::where('type','college')->orWhere('type', 'school and college')->where('approved', '1')->OrderBy('title','asc')->get();
        $universities = Institute::where('type','university')->where('approved', '1')->OrderBy('title','asc')->get();
        $departments = Department::OrderBy('title','asc')->get();
        $studies= Study::OrderBy('title','asc')->get();
        $curriculas= Curriculam::OrderBy('title','asc')->get();
        $ssc_tutor = TutorEducation::with('institutes')->where(['tutor_id'=>$tutor_id,'degree_name'=>'ssc'])->first();
        $hsc_tutor = TutorEducation::with('institutes')->where(['tutor_id'=>$tutor_id,'degree_name'=>'hsc'])->first();
        $honours_tutor = TutorEducation::with(['institutes','departments','studyType'])->where(['tutor_id'=>$tutor_id,'degree_name'=>'honours'])->first();
        $masters_tutor = TutorEducation::with(['institutes','departments','studyType'])->where(['tutor_id'=>$tutor_id,'degree_name'=>'masters'])->first();
        return view('dashboard.tutor.pages.tutor-education-info',compact('schools','colleges','universities',
            'departments','tutor','studies','curriculas','ssc_tutor','hsc_tutor','honours_tutor','masters_tutor'));

    }

    public function tutoreducation_info(Request $request)
    {
        $tutor_education_info = new Tutor_Education_info();
        $tutor_education_info->updateSSC($request);
        $tutor_education_info->updateHSC($request);
        $tutor_education_info->updateHONS($request);
        $tutor_education_info->updateMasters($request);
        return "successfully updated";

    }


    public function personal_info()
    {
        $tutor = profile_pic();
        $tutor_id = Auth::guard('tutor')->user()->id;
        $tutor_personal_info = TutorPersonalInfo::where('tutor_id',$tutor_id)->first();
        return view('dashboard.tutor.pages.tutor-personal-info',compact('tutor_personal_info','tutor'));
    }

    public function personal_info_save(Request $request)
    {
       $tutor_id = Auth::guard('tutor')->user()->id;

           $tutor_update = TutorPersonalInfo::where('tutor_id',$tutor_id)->first();
           $tutor_update->blood_group = $request->blood_group;
           $tutor_update->religion = $request->religion;
           $tutor_update->nationality = $request->nationality;
           $tutor_update->full_address = $request->present_address;
           $tutor_update->permanent_full_address = $request->permanent_address;
           $tutor_update->nid_number = $request->nid;
           $tutor_update->date_of_birth = $request->date_of_birth;
           $tutor_update->fathers_name = $request->father_name;
           $tutor_update->mothers_name = $request->mother_name;
           $tutor_update->fathers_phone = $request->father_phone;
           $tutor_update->mothers_phone = $request->mother_phone;
           $tutor_update->emargency_name = $request->emargency_contact_name;
           $tutor_update->emargency_phone = $request->emargency_contact_phone;
           $tutor_update->facebook_link = $request->facebook_link;
           $tutor_update->linkedin_link = $request->linkedin_link;
           $tutor_update->twitter_link = $request->twitter_link;
           $tutor_update->instagram_link = $request->instagram_link;
           $tutor_update->about_yourself = $request->about_yourself;
           $tutor_update->reason_hired = $request->reason_hired;
           $tutor_update->tutoring_experience = $request->job_experience;
           $tutor_update->personal_opinion = $request->personal_opinion;
           $tutor_update->save();
        return "successfully updated";

    }
   public function crediantial()
    {
        $tutor = profile_pic();
        $tutor_id  = Auth::guard('tutor')->user()->id;
        $tutor_crop_image = CropImage::where('tutor_id',$tutor_id)->latest()->first();
        $tutor_certificates = Certificate::all();
//        return $tutor_certificates;
        return view('dashboard.tutor.pages.tutor-crediantial-info',compact('tutor','tutor_crop_image','tutor_certificates'));
    }

    public function crediantial_store(Request $request)
    {
        $file = $request->crediantial_file;
        $type = $request->type;

        $tutor_crediantial = new Tutor_Crediantial();
        if ($type == 'SSC')
        {
            $tutor_crediantial->SSC_crediantial($file,$type);
        }
        if ($type == 'HSC')
        {
            $tutor_crediantial->HSC_crediantial($file,$type);
        }
        if ($type == 'honours')
        {
            $tutor_crediantial->HONS_crediantial($file,$type);
        }
        if ($type == 'masters')
        {
            $tutor_crediantial->Mast_crediantial($file,$type);
        }

        return redirect()->back()->with('updatemessage','Certificate Update successfully');


    }

    public function cropCertificate(Request $request)
    {

        $tutor_crediantial = new TutorCertificate();
        if ($request->file('sscCertificate'))
        {
//            $validator = Validator::make($request->file('sscCertificate'),[
//                "sscCertificate"             => "mimes:jpg,jpeg,png |max:100",
//            ],[
//                'sscCertificate.max'         => 'Input SSC Certificate Image Less Than 100 KB',
//                "sscCertificate:mimes"       => 'This must be a file of type: jpg, jpeg, png',
//
//            ]);
//            if ($validator->fails()) {
//                return redirect(route('crediantial'))
//                    ->withErrors($validator);
//            }
            $tutor_crediantial->ssc_c($request);
            return response()->json(['status' => 1, 'msg' => 'Image has been cropped and Upload successfully.']);
        }
        if ($request->file('sscMarksheet'))
        {
            $validator = Validator::make($request->file('sscMarksheet'),[
                "sscMarksheet"             => "mimes:jpg,jpeg,png |max:100",

            ],[
                'sscMarksheet.max'         => 'Input SSC Marksheet Image Less Than 100 KB',
                "sscMarksheet:mimes"               => 'This must be a file of type: jpg, jpeg, png',

            ]);
            $tutor_crediantial->ssc_m($request);
            return response()->json(['status' => 1, 'msg' => 'Image has been cropped and Upload successfully.']);
        }
        if ($request->file('hscCertificate'))
        {
            $tutor_crediantial->hsc_c($request);
            return response()->json(['status' => 1, 'msg' => 'Image has been cropped and Upload successfully.']);
        }
        if ($request->file('hscMarksheet'))
        {
            $tutor_crediantial->hsc_m($request);
            return response()->json(['status' => 1, 'msg' => 'Image has been cropped and Upload successfully.']);
        }
        if ($request->file('upload_cv'))
        {
            $tutor_crediantial->upload_cv($request);
            return response()->json(['status' => 1, 'msg' => 'Image has been cropped and Upload successfully.']);
        }

        if ($request->file('birth_nid_certificate'))
        {
            $tutor_crediantial->birth_nid($request);
            return response()->json(['status' => 1, 'msg' => 'Image has been cropped and Upload successfully.']);
        }
        if ($request->file('u_admission_certificate'))
        {
            $tutor_crediantial->admission_certificate($request);
            return response()->json(['status' => 1, 'msg' => 'Image has been cropped and Upload successfully.']);
        }
        if ($request->file('others'))
        {
            $tutor_crediantial->other($request);
            return response()->json(['status' => 1, 'msg' => 'Image has been cropped and Upload successfully.']);
        }


    }

    public function viewProfile()
    {
        $t_user = Auth::guard('tutor')->user();
        $tutor_categories = TutorCategory::with('category')->where('tutor_id',$t_user->id)->get();
        $tutor_courses = TutorCourse::where('tutor_id',$t_user->id)->get();
//        return $tutor_courses;
        $tutor_subjects = TutorSubject::where('tutor_id',$t_user->id)->get();
        $tutor = TutorPersonalInfo::with(['t_user','country','city','location', 't_user.tutor_categories'])->where('tutor_id',$t_user->id)->first();
        $ssc_tutor = TutorEducation::with(['institutes','curriculam'])->where(['tutor_id'=>$t_user->id,'degree_name'=>'ssc'])->first();
        $preferred_locations = TutorPreferedLocation::where('tutor_id',$t_user->id)->get();
        $hsc_tutor = TutorEducation::with(['institutes','curriculam'])->where(['tutor_id'=>$t_user->id,'degree_name'=>'hsc'])->first();
        $honours_tutor = TutorEducation::with(['institutes','departments','studyType'])->where(['tutor_id'=>$t_user->id,'degree_name'=>'honours'])->first();
        $masters_tutor = TutorEducation::with(['institutes','departments','studyType'])->where(['tutor_id'=>$t_user->id,'degree_name'=>'masters'])->first();
        return view('dashboard.tutor.pages.profile-view',
            compact('tutor','ssc_tutor','hsc_tutor','honours_tutor',
            'masters_tutor','preferred_locations','tutor_categories','tutor_courses','tutor_subjects'));

    }

    public function profilePic(Request $request)
    {

        $path = 'files/profile/';
        $file = $request->file('profile_pic');
        $new_image_name = 'UIMG' . date('Ymd') . uniqid() . '.jpg';
        $upload = $file->move(public_path($path), $new_image_name);
        if (!$upload) {
            return response()->json(['status' => 0, 'msg' => 'Something went wrong, try again later']);

        } else {

            $tutor_id = Auth::guard('tutor')->user()->id;
            $imageSave = TutorPersonalInfo::where('tutor_id', $tutor_id)->first();
            if ($imageSave->pic !=null) {
                unlink($path . $imageSave->pic);
            }
            $imageSave->pic = $new_image_name;
            $imageSave->save();
            return response()->json(['status' => 1, 'msg' => 'Image has been cropped successfully.', 'name' => $new_image_name]);

        }

    }

    public function jobBoard()
    {
        return view('dashboard.tutor.pages.job-board');
    }

    public function payment()
    {
        return view('dashboard.tutor.pages.payment');
    }
    public function confirmation()
    {
        return view('dashboard.tutor.pages.confirmation');
    }
    public function membership()
    {
        return view('dashboard.tutor.pages.membership');
    }
     public function setting()
    {
        $tutor_info = Tutor::where('id',auth::guard('tutor')->user()->id)->first();
        return view('dashboard.tutor.pages.Setting',compact('tutor_info'));
    }
    public function notification()
    {
        return view('dashboard.tutor.pages.notification');
    }
    public function accountStatus()
    {
        $current_user = Auth::guard('tutor')->user();
        return view('dashboard.tutor.pages.account_status',compact('current_user'));
    }
    public function changePassword()
    {
        return view('dashboard.tutor.pages.change_password');
    }
//    public function accountDeactivate()
//    {
//
//        return view('dashboard.tutor.pages.account-deactivate',);
//    }

    public function changeEmail(Request $request)
    {
        $tutor_id = Auth::guard('tutor')->user()->id;
        if ($request->email)
        {
            $email_otp = rand(1234,9999);
            $email = $request->email;
            $update_email = Tutor::find($tutor_id)->first();
            $update_email->email = $email;
            $update_email->email_otp = $email_otp;
            $update_email->save();
            $tutor_log = new TutorLog();
            $tutor_log->tutor_id = $tutor_id;
            $tutor_log->email = $request->email;
            $tutor_log->save();
            if ( $update_email->email_varified_at == null)
            {
                Mail::to($request->email)->send( new VerifyEmailOtp([
                    'name'=> $update_email->name,
                    'otp'=> $email_otp,
                ]));
                return redirect()->route('email-verification-code');

            }else
            {
                return redirect()->back()->with('message','This E-email Already verified');
            }


        }


    }
    public function changePhone(Request $request)
    {
        $tutor_id = Auth::guard('tutor')->user()->id;
        if ($request->phone)
        {

            $update_phone = Tutor::find($tutor_id)->first();
            if ($update_phone->phone != $request->phone)
            {
                $update_phone->phone = $request->phone;
                $update_phone->otp = rand(1234,9999);
                $update_phone->save();
                $tutor_log = new TutorLog();
                $tutor_log->tutor_id = $tutor_id;
                $tutor_log->phone = $request->phone;
                $tutor_log->save();
                return redirect()->route('tutor.otp');
            }else
            {
                return redirect()->back()->with('message','This Phone Already verified');
            }


        }
    }
    public function changeName(Request $request)
    {
        $tutor_id = Auth::guard('tutor')->user()->id;
       $update_name = Tutor::find($tutor_id)->first();
       $update_name->name = $request->name;
       $update_name->save();
       $tutor_log = new TutorLog();
       $tutor_log->tutor_id = $tutor_id;
       $tutor_log->name = $request->name;
       $tutor_log->save();
       return redirect()->back()->with('message','Name Update Successfully');
    }

    public function emailVerification()
    {
        $tutor_id = Auth::guard('tutor')->user()->id;
        $tutor_email = Tutor::find($tutor_id)->pluck('email')->first();

        return view('email.verification-page',compact('tutor_email'));
    }
    public function emailVerified(Request $request)
    {
       $request->validate([
          'email_otp' => 'required'
       ]);
        $tutor_id  = Auth::guard('tutor')->user()->id;
        $check_Otp = Tutor::find($tutor_id)->first();
        if ($check_Otp->email_otp == $request->email_otp)
        {
            $check_Otp->email_varified_at =now();
            $check_Otp->save();
            return redirect()->route('tutor.Setting')->with('message','E-mail verified successfully!');
        }else
        {
            return redirect()->back()->with('error','your otp is invalid');
        }

    }

    public function change_password(Request $request)
    {
        $request->validate([
            'current_pass' => 'required',
            'new_pass' => 'required|min:6',
            'confirm_pass' => 'required|same:new_pass',
        ]);

        $current_user = Auth::guard('tutor')->user();
        if(Hash::check($request->current_pass,$current_user->password))
        {
            $current_user->password = Hash::make($request->new_pass);
            $current_user->save();
            return redirect()->back()->with('message','Password change Successfully!');
        }else
        {
            return redirect()->back()->with('error','Current passsword did not match!');
        }

    }

    public function deactivateAccount( Request $request)
    {
        if ($request->deactivate)
        {
            $deactive_tutor = Auth::guard('tutor')->user();
            $deactive_tutor->is_active = 0;
            $deactive_tutor->save();
            return redirect()->back()->with('message','your Account Deactive Successfully!');
        }
        if ($request->activate)
        {
            $activate_tutor = Auth::guard('tutor')->user();
            $activate_tutor->is_active = 1;
            $activate_tutor->save();
            return redirect()->back()->with('message','your Account Activate Successfully!');
        }


    }






}
