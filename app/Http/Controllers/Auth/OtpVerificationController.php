<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Sms;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Tutor;
use Illuminate\Support\Facades\Auth;

class OtpVerificationController extends Controller
{
    //
    public function otp()
    {
        return view('frontend.tutor.tutor-otp-verify');
    }

    public function verifyOtp(Request $request)
    {
        $tutor_id = $request->tutor_id;
        $tutor_otp = $request->otp;
        $tutor = Tutor::find($tutor_id);

           if ($tutor && $tutor->otp == $tutor_otp)
           {
               $tutor->phone_varified_at = now();
               $tutor->phone_change_count = '1';
               $tutor->save();
               if ($tutor->phone_change_count != null)
               {
                   return redirect()->route('tutor.Setting')->with('message','phone verified successfully!');
               }else
               {
                   return redirect()->route('tutor.dashboard');
               }


           }else
           {
               return redirect()->back()->with('message','Your Otp Invalid');

           }


    }

    public function resendOtp()
    {
        $tutor = Auth::guard('tutor')->user();
        if ($tutor->otp != null)
        {
            $tutor->otp = rand(1234,9999);
            $tutor->save();
            return redirect()->back()->with('remessage','Your Otp Send Successfully');
        }
    }





}
