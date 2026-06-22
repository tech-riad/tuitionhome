<?php

namespace App\Http\Controllers\Frontend\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class TutorRegisterController extends Controller
{
//    Tutor register page view

    public function TutorRegister()
    {
        return view('frontend.tutor.tutor-register');
    }

//    tutor register store

    public function TutorRegisterStore(Request $request)
    {
       $request->validate([
          'name' => 'required',
          'phone' => 'required|regex:/(01)[0-9]{9}/|unique:tutors,phone',
           'email' => 'required|email|unique:tutors,email',
           'gender' => 'required',
           'password' => 'required|min:6',
           'cpassword' => 'required|same:password',
       ]);
        $tutor = new Tutor();
        $tutor->otp = rand(1234,9999);
        $tutor->name = $request->name;
        $tutor->phone = $request->phone;
        $tutor->email = $request->email;
        $tutor->gender = $request->gender;
        $tutor->role_id = '3';
        $tutor->password = Hash::make($request->password);
        $tutor->save();

      if (Auth::guard('tutor')->attempt(['email'=>$request->email,'password'=>$request->password]))
      {
          return redirect()->route('tutor.dashboard');
      }


    }


//    Tutor Login Page

    public function TutorLogin()
    {
        return view('frontend.tutor.tutor-login');
    }

    public function smsSend()
    {
        $message = 'hello this is alamin just test purpose send this message';
        $number = '01758262008';
        $cURLConnection = curl_init();
        $url='https://easybulksmsbd.com/sms/api?action=send-sms&api_key=VHVpdGlvbiBUZXJtaW5hbDoxMjM0NTY3&to= '.$number.' &from=SenderID&sms='.$message;
        curl_setopt($cURLConnection, CURLOPT_URL, $url);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        return $res;
    }


}
