<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\DeskNumber;
use App\Models\UserLoginLog;
use App\Services\AdnSmsService;
use Carbon\Carbon;
use Faker\Provider\UserAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EmployeeController extends Controller
{

    private $adnSmsService;
    public function __construct( AdnSmsService $adnSmsService)
    {
        $this->adnSmsService = $adnSmsService;
    }

    public function Emlogin()
    {
        return view('auth.employee.login');
    }

    public function EmCheckLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            $message = $this->validateLoginTime($user);
            if ($message !== true) {
                Auth::logout();
                return redirect()->back()->with('message', $message);
            }

            if ($user->role_id == 1) {
                $sendsnmotp = rand(100000, 999999);
                $user->sms_otp = $sendsnmotp;
                $user->phone_verified_at = null;
                $user->save();

                $phoneNumber = $user->phone;
                
                $otp = ('Your OTP For "TuitionHome" Admin Login Is : ' . $sendsnmotp);

                $this->sendOtpToUser($phoneNumber, $otp);

                return redirect()->route('employee.otp')->with('message', 'Enter OTP to proceed.');
            } else {

                $em_user_agent = $request->header('User-Agent');
                $userAgents = DeskNumber::pluck('user_agent');

                if ($userAgents->contains($em_user_agent)) {
                    $this->logUserLogin($user, $request);
                    return redirect()->route('employee.dashboard');
                } else {
                    $message = 'You don’t have permission to login';
                    Auth::logout();
                    return redirect()->back()->with('message', $message);
                }
            }
        }

        return redirect()->back()->with('message', 'Your credentials are wrong!');
    }


    private function logUserLogin($user, $request)
    {
        $userLog = new UserLoginLog();
        $userLog->user_id = $user->id;
        $userLog->name = $user->name;
        $userLog->phone = $user->phone;
        $userLog->login_at = Carbon::now();
        $userLog->user_agent = $request->header('User-Agent');
        $userLog->ip_address = $request->ip();
        $userLog->save();
    }


    public function EmployeeOtp()
    {
        return view('auth.employee.otp-page');

    }
    public function checkOtp(Request $request)
    {
       $request->validate([
          'employee_otp' => 'required|numeric|min:4'
       ]);
       $user = Auth::user();
       if ($user->sms_otp == $request->employee_otp)
       {
           $user->phone_verified_at = Carbon::now();
           $user->save();
           return redirect()->route('employee.dashboard')->with('message','phone verified successfully! ');
       }else
       {
           return redirect()->back()->with('message','your otp is invalid');
       }


    }

    public function otpGenerate()
    {
        $otp = rand(1234,9999);
        return $otp;
    }

    private function sendOtpToUser($phoneNumber, $message)
    {
        try {

            $result = $this->adnSmsService->sendOtp($phoneNumber, $message);

            if (is_array($result) && array_key_exists('status', $result)) {
                if ($result['status']) {

                } else {
                }
            } else {
            }
        } catch (\Exception $e) {
        }
    }

    public function timeset()
    {
        $currentTime = Carbon::now();
        echo $currentTime;
    }

    public function browserCheck($request)
    {
        $user_agent =  request()->header('User-Agent');
        return $user_agent;
    }

    protected function validateLoginTime($user)
    {
        $now = now();

        if (!$user) {
            return "User is not authenticated.";
        }

        if ($user->role_id == 1) {
            return true;
        } else {
            $allowedStartTime = now()->setTime(8, 0, 0);
            $allowedEndTime = now()->setTime(23, 0, 0);

            if ($now < $allowedStartTime || $now > $allowedEndTime) {
                return "Login is only allowed between 8:00 AM and 11:00 PM.";
            }
        }

        return true;
    }

    public function empLogout(Request $request)
    {
        $user = Auth::user();

        $userLog = new UserLoginLog();
        $userLog->user_id = $user->id;
        $userLog->name = $user->name;
        $userLog->phone = $user->phone;
        $userLog->logout_at = Carbon::now();
        $userLog->logout_reason = $request->logout_reason;
        $userLog->logout_duration_apx = $request->logout_duration_apx;
        $userLog->user_agent = request()->header('User-Agent');
        $userLog->ip_address = request()->ip();
        $userLog->save();

        Auth::logout();
        Session::forget('last_activity');
        return redirect()->route('employee.login')->with('message', 'Logout Successfully');
    }



}