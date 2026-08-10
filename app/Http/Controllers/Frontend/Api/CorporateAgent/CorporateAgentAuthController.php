<?php

namespace App\Http\Controllers\Frontend\Api\CorporateAgent;

use App\Http\Controllers\Controller;
use App\Models\CorporateAgent;
use App\Models\UnverifiedCorporateAgent;
use App\Transformers\CorporateAgentResource;
use App\Services\AdnSmsService;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CorporateAgentAuthController extends Controller
{
    use ApiResponse;

    private $adnSmsService;

    public function __construct(AdnSmsService $adnSmsService)
    {
        $this->adnSmsService = $adnSmsService;
    }

    private function createCustomToken($user, $scope)
    {
        $token = $user->createToken($user->name, [$scope]);

        $token->token->expires_at = now()->addDays(7);
        $token->token->save();

        return $token->accessToken;
    }

    private function sendOtpToUser($phoneNumber, $otp)
    {
        try {
            $message = 'Your TuitionHome corporate agent OTP is: ' . $otp;
            $this->adnSmsService->sendOtp($phoneNumber, $message);
        } catch (Exception $exception) {
            // keep silent on SMS failure, response includes OTP for debugging or local use
        }
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'phone' => 'required|regex:/(01)[0-9]{9}/|unique:corporate_agents,phone|unique:unverified_corporate_agents,phone',
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $expiry = Carbon::now()->addMinutes(10);

            $unverified = UnverifiedCorporateAgent::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role_id' => '3',
                'otp' => rand(1234, 9999),
                'otp_expiry' => $expiry,
            ]);

            // $this->sendOtpToUser($unverified->phone, $unverified->otp);

            $data = [
                'id' => $unverified->id,
                'name' => $unverified->name,
                'phone' => $unverified->phone,
                'otp' => $unverified->otp,
            ];

            return response()->json(['status' => true, 'message' => 'Corporate agent registration successful. Please verify your phone with OTP.', 'data' => $data]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'error' => 'Internal Server Error'], 500);
        }
    }

    public function verifyPhone(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required|regex:/(01)[0-9]{9}/',
                'otp' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $unverified = UnverifiedCorporateAgent::where('phone', $request->phone)->first();
            if (!$unverified || $unverified->otp !== $request->otp || $unverified->otp_expiry < now()) {
                return response()->json(['status' => false, 'error' => 'Invalid or expired OTP']);
            }

            $corporateAgent = CorporateAgent::create([
                'name' => $unverified->name,
                'phone' => $unverified->phone,
                'password' => $unverified->password,
                'role_id' => $unverified->role_id,
                'otp' => $unverified->otp,
                'otp_expiry' => $unverified->otp_expiry,
                'phone_verified_at' => now(),
            ]);

            $corporateAgent->get_corporate_agent_unique_id();
            $corporateAgent->refresh();

            $token = $this->createCustomToken($corporateAgent, 'corporate_agents');

            $unverified->delete();

            return response()->json(['status' => true, 'message' => 'Corporate agent verified successfully.', 'data' => ['token' => $token, 'user' => new CorporateAgentResource($corporateAgent)]]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'error' => 'Internal Server Error'], 500);
        }
    }

    public function resendOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required|regex:/(01)[0-9]{9}/',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $unverified = UnverifiedCorporateAgent::where('phone', $request->phone)->first();
            if (!$unverified) {
                return response()->json(['status' => false, 'error' => 'User not found']);
            }

            $cacheKey = 'otp_request_count_' . $unverified->phone;
            $otpRequestCount = Cache::get($cacheKey, 0);
            if ($otpRequestCount >= 1) {
                return response()->json(['status' => false, 'message' => 'You can only request one OTP every 2 minutes. Please try again later.']);
            }

            Cache::put($cacheKey, $otpRequestCount + 1, now()->addSeconds(120));

            if ($unverified->otp_resend_count >= 3 && Carbon::now()->diffInMinutes($unverified->last_otp_resend) < 24 * 60) {
                return response()->json(['status' => false, 'message' => 'You have reached the maximum OTP resend limit for today. Please try again after 24 hours.']);
            }

            $unverified->otp = rand(1234, 9999);
            $unverified->otp_expiry = Carbon::now()->addMinutes(10);
            $unverified->otp_resend_count += 1;
            $unverified->last_otp_resend = now();
            $unverified->save();

            $this->sendOtpToUser($unverified->phone, $unverified->otp);

            return response()->json(['status' => true, 'message' => 'OTP resent successfully.', 'data' => ['phone' => $unverified->phone, 'otp' => $unverified->otp]]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'error' => 'Internal Server Error'], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }

            $field = is_numeric($request->phone) ? 'phone' : (filter_var($request->phone, FILTER_VALIDATE_EMAIL) ? 'email' : null);
            if (!$field) {
                return response()->json(['status' => false, 'message' => 'Invalid phone number or email format']);
            }

            $agent = CorporateAgent::where($field, $request->phone)->first();
            if (!$agent || !Hash::check($request->password, $agent->password)) {
                return response()->json(['status' => false, 'message' => 'Username or password invalid']);
            }

            if (!$agent->phone_verified_at) {
                return response()->json(['status' => false, 'message' => 'Please verify your phone first']);
            }

            $token = $this->createCustomToken($agent, 'corporate_agents');
            return response()->json(['status' => true, 'message' => 'Login successfully!', 'token' => $token, 'user' => new CorporateAgentResource($agent)]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'error' => 'Internal Server Error'], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();
            return response()->json(['status' => true, 'message' => 'Successfully logged out.']);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'error' => 'Unable to logout'], 500);
        }
    }

    public function basicInfo(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'email'  => 'required|email',
                'gender' => 'required|in:male,female',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $corporateAgent = auth()->user(); // Assuming the user is authenticated and you want to get the currently logged-in corporate agent

            // অথবা সরাসরি:
            // $corporateAgent = Auth::guard('c-api')->user();

            if (!$corporateAgent) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 401);
            }

            $corporateAgent->update([
                'email'  => $request->email,
                'gender' => $request->gender,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Corporate Agent Basic Info Updated Successfully',
                'data'    => new CorporateAgentResource($corporateAgent->fresh()),
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ], 500);
        }
    }


    public function checkPhone(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required|regex:/(01)[0-9]{9}/',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $phone = $request->phone;

            $corporateAgentPasswordReset = CorporateAgent::where('phone', $phone)->first();

            if ($corporateAgentPasswordReset === null) {
                return response()->json(['status' => false, 'message' => 'User Not Found!']);
            } elseif ($corporateAgentPasswordReset->phone !== $phone) {
                return response()->json(['status' => false, 'message' => 'Invalid phone number for the user!']);
            } else {
                $otpRequestLimit = 1;
                $otpRequestTimeFrame = 120;

                $cacheKey = 'otp_request_count_' . $corporateAgentPasswordReset->phone;
                $otpRequestCount = Cache::get($cacheKey, 0);

                if ($otpRequestCount >= $otpRequestLimit) {
                    return response()->json(['status' => false, 'message' => 'You can only request one OTP every 2 minutes. Please try again later.']);
                }

                Cache::put($cacheKey, $otpRequestCount + 1, now()->addSeconds($otpRequestTimeFrame));

                $otpResendLimit = 3;
                $otpResendTimeFrame = 24 * 60;

                if ($corporateAgentPasswordReset->otp_resend_count >= $otpResendLimit && Carbon::now()->diffInMinutes($corporateAgentPasswordReset->last_otp_resend) < $otpResendTimeFrame) {
                    return $this->resposeError('You have reached the maximum OTP resend limit for today. Please try again after 24 hours. Or contact TuitionHome Admin over the phone', '');
                }

                $phone_otp = rand(1234, 9999);
                $otpExpiry = now()->addMinutes(10);
                $corporateAgentPasswordReset->otp = $phone_otp;
                $corporateAgentPasswordReset->otp_expiry = $otpExpiry;

                // $this->sendOtpToUser($request->phone, 'Your password recovery OTP for "TuitionHome" is: ' . $phone_otp, $corporateAgentPasswordReset->id);

                // Update OTP resend count and timestamp
                $corporateAgentPasswordReset->otp_resend_count += 1;
                $corporateAgentPasswordReset->last_otp_resend = now();
                $corporateAgentPasswordReset->save();

                return response()->json(['status' => true, 'message' => 'OTP sent successfully!', 'phone' => $corporateAgentPasswordReset->phone,'otp' => $corporateAgentPasswordReset->otp]);
            }
        } catch (ValidationException $e) {
            return response()->json(['status' => false, 'error' => $e->errors()]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }
    }

     public function updatePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'corporate_agent_id' => 'required',
                'new_password'         => 'required|min:6',
                'confirm_password'     => 'required|same:new_password',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $current_user = CorporateAgent::find($request->corporate_agent_id);


            if ($current_user) {
                if ($current_user->otp_expiry > $current_user->phone_verified_at ){
                    $current_user->password = Hash::make($request->new_password);
                    $current_user->save();

                    return response()->json(['status' => true, 'message' => 'Password changed successfully!']);

            }
            else{
                return response()->json(['status' => false, 'message' => 'verified phone first!']);
            }
        }

        } catch (Exception $e) {

        }
    }

    public function verifyOtpAndSavePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required|exists:corporate_agents,phone',
                'phone_otp'   => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $corporate_agent = CorporateAgent::where('phone',$request->phone)->first();
            if ($corporate_agent) {
                if ($corporate_agent->otp && Carbon::now()->lt($corporate_agent->otp_expiry)) {
                    if ($corporate_agent->otp == $request->phone_otp) {
                        $corporate_agent->phone_verified_at = now();
                        $corporate_agent->save();

                        $data = [
                            'corporate_agent_id' => $corporate_agent->id,
                            'corporate_agent_phone' => $corporate_agent->phone,
                            'otp' => $corporate_agent->otp,
                        ];
                        return response()->json(['status' => true, 'message' => 'Phone verified successfully!', 'data' => $data]);
                    } else {
                        return $this->resposeError('Your OTP is invalid!', '');
                    }
                } else {
                    return $this->resposeError('Your OTP is expired! Resend OTP and try again.', '');
                }
            } else {
                return $this->resposeError('User not found!', '');
            }


        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['status' => false, 'error' => 'Internal Server Error'], 500);
        }

    }
}
