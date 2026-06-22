<?php

namespace App\Http\Controllers\Frontend\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class TutorLoginController extends Controller
{

    public function TutorLoginCheck(Request $request)
    {

//        $phone = $request->email;
        $request->validate([
            'email' =>'required',
            'password'=> 'required|min:6'
        ]);


        if(is_numeric($request->get('email'))){
            if (Auth::guard('tutor')->attempt(['phone'=>$request->email,'password'=>$request->password]))
            {
                return redirect()->route('tutor.dashboard');
            }else
            {
                return redirect()->back()->with('user_nameError','user name or password invalid');
            }

        }
        elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            $request->validate([
                'email' =>'required|regex:/(.+)@(.+)\.(.+)/i',
            ]);
            if (Auth::guard('tutor')->attempt($request->only('email', 'password')))
            {
                return redirect()->route('tutor.dashboard');
            }else
            {
                return redirect()->back()->with('user_nameError','user name or password invalid');
            }

        }


    }
    public function logout(Request $request)
    {



        Auth::guard('tutor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('tutor.login');

    }
}
