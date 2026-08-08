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
        return $this->resposeSuccess('Corporate agent is authenticated', new CorporateAgentResource($request->user()));
    }
}
