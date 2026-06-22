<?php

namespace App\Http\Controllers\Frontend\Api\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Counting;
use App\Models\Tutor;
use App\Models\TutorLog;
use App\Models\SmsBalance;
use App\Models\UnverifiedTutor;
use App\Services\AdnSmsService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Cache;

class TutorLoginRegisterController extends Controller
{
    use ApiResponse;

    private $adnSmsService;
    public function __construct( AdnSmsService $adnSmsService)
    {
        $this->adnSmsService = $adnSmsService;
    }

    // private function sendOtpToUser($phoneNumber, $message, $tutorId)
    // {

    //     try {
    //         $result = $this->adnSmsService->sendOtp($phoneNumber, $message);


    //         if (is_array($result) && array_key_exists('status', $result)) {
    //             if ($result['status']) {
    //                 \Log::info('OTP SMS Sent successfully', ['tutor_id' => $tutorId]);
    //             } else {
    //                 \Log::error('Error sending OTP SMS', ['tutor_id' => $tutorId, 'error_message' => $result['message']]);
    //             }
    //         } else {
    //             \Log::error('Unexpected response from sendSms method', ['tutor_id' => $tutorId, 'response' => $result]);
    //         }
    //     } catch (\Exception $e) {
    //         \Log::error('Exception while sending OTP SMS', ['tutor_id' => $tutorId, 'exception_message' => $e->getMessage()]);
    //     }
    // }

    private function createCustomToken($user, $scope)
    {
        $token = $user->createToken($user->name, [$scope]);

        $token->token->expires_at = now()->addDays(7);
        $token->token->save();

        return $token->accessToken;
    }
    public function allUser()
    {
        $tutors = Tutor::all();
        $total  = $tutors->count();
        return $this->resposeSuccess('Total tutors = '.$total,$tutors);
    }

    private function sendOtpToUser($phoneNumber, $message, $tutorId)
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
//  Number Change if the given number is incorrect first time only for registration
    public function phoneChange(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'existing_phone' => 'required|regex:/(01)[0-9]{9}/',
                'new_phone' => 'required|regex:/(01)[0-9]{9}/|unique:unverified_tutors,phone|unique:tutors,phone',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $unverifiedTutor = UnverifiedTutor::where('phone', $request->existing_phone)->first();

            if (!$unverifiedTutor) {
                return response()->json(['status' => false, 'error' => 'Tutor not found for the provided existing phone number'], 404);
            }

            $expiry = Carbon::now()->addMinutes(10);

            $unverifiedTutor->otp = rand(1234, 9999);
            $unverifiedTutor->otp_expiry = $expiry;

            $unverifiedTutor->phone = $request->new_phone;
            $unverifiedTutor->ip_address = $request->ip();
            $unverifiedTutor->user_agent = $request->header('User-Agent');

            $updated = $unverifiedTutor->update();

            if (!$updated) {
                return response()->json(['status' => false, 'error' => 'Failed to update tutor information'], 500);
            }

            $this->sendOtpToUser($request->new_phone, 'Your OTP is: ' . $unverifiedTutor->otp, $unverifiedTutor->id);

            return response()->json(['status' => true, 'message' => 'Tutor Registration Successful!']);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'error' => 'Internal Server Error'], 500);
        }
    }
// Register In Unverified Table
    public function registerStore(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'             => 'required',
                'phone'            => 'required|regex:/(01)[0-9]{9}/|unique:unverified_tutors,phone|unique:tutors,phone',
                'email'            => 'required|email|unique:unverified_tutors,email|unique:tutors,email',
                'gender'           => 'required',
                'password'         => 'required|min:6',
                'confirm_password' => 'required|same:password',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $registeredTutor = Tutor::where('phone', $request->phone)->first();

            if ($registeredTutor) {
                return response()->json(['status' => true, 'message' => 'You Are Already Registered Please Login!']);
            }

            $existingUnverifiedTutor = UnverifiedTutor::where('phone', $request->phone)->first();

            if ($existingUnverifiedTutor) {
                return response()->json(['status' => true, 'message' => 'Tutor Already Exists Please Verify Your Phone!']);
            }

            $unverifiedTutor = new UnverifiedTutor();
            $expiry = Carbon::now()->addMinutes(10);

            $unverifiedTutor->otp          = rand(1234, 9999);
            $unverifiedTutor->otp_expiry   = $expiry;
            $unverifiedTutor->name         = $request->name;
            $unverifiedTutor->phone        = $request->phone;
            $unverifiedTutor->email        = $request->email;
            $unverifiedTutor->gender       = $request->gender;
            $unverifiedTutor->ip_address   = $request->ip();
            $unverifiedTutor->role_id      = 3;
            $unverifiedTutor->password     = Hash::make($request->password);
            $unverifiedTutor->user_agent   = $request->header('User-Agent');
            $unverifiedTutor->save();

            $this->sendOtpToUser($request->phone, 'Your profile registration OTP for "TuitionHome" is: ' . $unverifiedTutor->otp, $unverifiedTutor->id);

            return response()->json(['status' => true, 'message' => 'Tutor Registration Successful!']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => 'Internal Server Error'], 500);
        }
    }
// Verify Unverified tutor in Unverified Table & save tutor Table
    public function verifyOtpAndSave(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required|exists:unverified_tutors,phone',
                'otp'   => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $unverifiedTutor = UnverifiedTutor::where('phone', $request->phone)->first();

            if (!$unverifiedTutor || $unverifiedTutor->otp !== $request->otp || $unverifiedTutor->otp_expiry < now()) {
                return response()->json(['status' => false, 'error' => 'Invalid OTP']);
            }

            $tutor = new Tutor();
            $tutor->name               = $unverifiedTutor->name;
            $tutor->phone              = $unverifiedTutor->phone;
            $tutor->email              = $unverifiedTutor->email;
            $tutor->gender             = $unverifiedTutor->gender;
            $tutor->otp                = $unverifiedTutor->otp;
            $tutor->otp_expiry         = $unverifiedTutor->otp_expiry;
            $tutor->ip_address         = $unverifiedTutor->ip_address;
            $tutor->role_id            = $unverifiedTutor->role_id;
            $tutor->password           = $unverifiedTutor->password;
            $tutor->user_agent         = $unverifiedTutor->user_agent;
            $tutor->login_at           = now();
            $tutor->phone_varified_at  = now();
            $tutor->save();
            $tutor->get_tutor_unique_id();



            $token = $this->createCustomToken($tutor, 'tutors');

            $data = [
                "id" => $tutor->id,
                "token" => $token,
            ];

            $tutorSmsBalance = new SmsBalance();

            $tutorSmsBalance->tutor_id = $tutor->id;
            $tutorSmsBalance->save();

            $tutor_logs = new TutorLog();
            $tutor_logs->tutor_id = $tutor->id;
            $tutor_logs->name     = $unverifiedTutor->name;
            $tutor_logs->email    = $unverifiedTutor->email;
            $tutor_logs->phone    = $unverifiedTutor->phone;
            $unverifiedTutor->delete();

            $tutor_logs->save();


            $counting = new Counting();
            $counting->tutor_id = $tutor->id;
            $counting->applied_job = 0;
            $counting->shortlisted_job = 0;
            $counting->appointed_job = 0;
            $counting->confirmed_job = 0;
            $counting->cancel_job = 0;
            $counting->payment_job = 0;
            $counting->save();

            return response()->json(['status' => true, 'message' => 'Your profile registration has been verified successfully.', 'data' => $data]);


        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => 'Internal Server Error'], 500);
        }
    }
// Resend Unverified tutor OTP
    public function resendRegisterOtp(Request $request)
    {
        try {
            $phone = $request->phone;
            $tutor = UnverifiedTutor::where('phone',$phone)->first();

            if ($tutor) {
                $otpRequestLimit = 1;
                $otpRequestTimeFrame = 120;

                $cacheKey = 'otp_request_count_' . $tutor->phone;
                $otpRequestCount = Cache::get($cacheKey, 0);

                if ($otpRequestCount >= $otpRequestLimit) {
                    return $this->resposeError('You can only request one OTP every 2 minutes. Please try again later.', '');
                }


                Cache::put($cacheKey, $otpRequestCount + 1, now()->addSeconds($otpRequestTimeFrame));


                $otpResendLimit = 3;
                $otpResendTimeFrame = 24 * 60;

                if ($tutor->otp_resend_count >= $otpResendLimit && Carbon::now()->diffInMinutes($tutor->last_otp_resend) < $otpResendTimeFrame) {
                    return $this->resposeError('You have reached the maximum OTP resend limit for today. Please try again after 24 hours.Or Contact with Tuition Home Admin Over The Phone', '');
                }


                $tutor->increment('otp_resend_count');
                $tutor->last_otp_resend = now();
                $tutor->save();

                $expiry = Carbon::now()->addMinutes(10);
                $dateTime = new DateTime($expiry);
                $minutes = $dateTime->format('h:i');

                $tutor->otp = rand(1234, 9999);
                $tutor->otp_expiry = $expiry;
                $tutor->save();

                $resend_otp_information = [
                    'tutor_phone' => $tutor->phone,
                ];

                $this->sendOtpToUser($tutor->phone, 'Your profile registration OTP for "TuitionHome" is: ' . $tutor->otp, $tutor->id);
                return $this->resposeSuccess('Otp Resend Successfully', $resend_otp_information);
            } else {
                return $this->resposeError('User Not Found!', '');
            }
        } catch (Exception $e) {
        }

    }


    public function login(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
            }

            $loginValue = $request->input('email');
            $field = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
            $unverifiedTutor = UnverifiedTutor::where($field, $loginValue)->first();
            if($unverifiedTutor)
            {
                return response()->json(['status' => false, 'message' => 'Please verify your phone','error'=>'Unverified']);

            }

            $credentials = $this->getLoginCredentials($request->email);

            if (auth('tutor')->attempt($credentials)) {
                $tutor = auth('tutor')->user();

                if ($tutor->phone_varified_at !== null) {
                    $token = $this->createCustomToken($tutor, 'tutors');
                    $tutor->update(['login_at' => now()]);
                    $tutor->deactive_mail_send = 0;
                    $tutor->update();




                    $userData = $this->formatUserData($tutor);

                    return response()->json(['status' => true, 'message' => 'Login Successfully!', 'token' => $token, 'user' => $userData]);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Invalid username or password'], 401);
            }
        } catch (Exception $e) {
            return $this->resposeError('', $e->getMessage());
        }
    }

    protected function formatUserData($tutor)
    {
        $allowedFields = [
            'id'
        ];
        $userData = array_intersect_key($tutor->toArray(), array_flip($allowedFields));

        return $userData;
    }


    protected function getLoginCredentials($email)
    {
        if (is_numeric($email)) {
            return ['phone' => $email, 'password' => request('password')];
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['email' => $email, 'password' => request('password')];
        } else {
            return null;
        }
    }

// আপাতত কোন কাজে লাগছে নাহ
    public function VerifyPhone(Request $request)
    {
        try {
            $validator = Validator()->make($request->all(), [
                'phone_otp' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }
            $id = $request->tutor_id;
            $tutor = Tutor::find($id);

            if ($tutor) {
                if ($tutor->otp && Carbon::now()->lt($tutor->otp_expiry)) {
                    if ($tutor->otp == $request->phone_otp) {
                        $tutor->phone_varified_at = now();
                        $tutor->save();
                        return $this->resposeSuccess('Phone verified successfully!', '');
                    } else {
                        return $this->resposeError('Your OTP is invalid!', '');
                    }
                } else {
                    return $this->resposeError('Your OTP is expired! Resend OTP and try again.', '');
                }
            } else {
                return $this->resposeError('User Not Found!', '');
            }
        } catch (Exception $e) {
            return $this->resposeError('', $e->getMessage());
        }
    }

// আপাতত কোন কাজে লাগছে নাহ
    public function resend(Request $request)
    {
        try {
            $id = $request->tutor_id;
            $tutor = Tutor::find($id);

            if ($tutor) {
                $otpRequestLimit = 1;
                $otpRequestTimeFrame = 120;

                $cacheKey = 'otp_request_count_' . $tutor->phone;
                $otpRequestCount = Cache::get($cacheKey, 0);

                if ($otpRequestCount >= $otpRequestLimit) {
                    return $this->resposeError('You can only request one OTP every 2 minutes. Please try again later.', '');
                }


                Cache::put($cacheKey, $otpRequestCount + 1, now()->addSeconds($otpRequestTimeFrame));


                $otpResendLimit = 3;
                $otpResendTimeFrame = 24 * 60;

                if ($tutor->otp_resend_count >= $otpResendLimit && Carbon::now()->diffInMinutes($tutor->last_otp_resend) < $otpResendTimeFrame) {
                    return $this->resposeError('You have reached the maximum OTP resend limit for today. Please try again after 24 hours.Or Contact with Tuition Home Admin Over The Phone', '');
                }


                $tutor->increment('otp_resend_count');
                $tutor->last_otp_resend = now();
                $tutor->save();

                $expiry = Carbon::now()->addMinutes(10);
                $dateTime = new DateTime($expiry);
                $minutes = $dateTime->format('h:i');

                $tutor->otp = rand(1234, 9999);
                $tutor->otp_expiry = $expiry;
                $tutor->save();

                $resend_otp_information = [
                    'tutor_id' => $tutor->id,
                ];

                $this->sendOtpToUser($tutor->phone, 'Your OTP is: ' . $tutor->otp, $tutor->id);
                return $this->resposeSuccess('Otp Resend Successfully', $resend_otp_information);
            } else {
                return $this->resposeError('User Not Found!', '');
            }
        } catch (Exception $e) {
            return response()->json('', $e->getMessage());
        }
    }


}