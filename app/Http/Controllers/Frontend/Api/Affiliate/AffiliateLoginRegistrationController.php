<?php

namespace App\Http\Controllers\Frontend\Api\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\AffiliateUser;
use App\Services\AdnSmsService;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use DateTime;
use Dotenv\Validator;
use Exception;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AffiliateLoginRegistrationController extends Controller
{
    use ApiResponse;
//    Parents register method
    private $adnSmsService;
    public function __construct( AdnSmsService $adnSmsService)
    {
        $this->adnSmsService = $adnSmsService;
    }
    private function createCustomToken($user, $scope)
    {
        $token = $user->createToken($user->name, [$scope]);

        // Customize the token as needed
        $token->token->expires_at = now()->addDays(7);
        $token->token->save();

        return $token->accessToken;
    }

    private function sendOtpToUser($phoneNumber, $message, $affiliateId)
    {
        try {
            // \Log::info('Attempting to send OTP to phone number: ' . $phoneNumber);
            // \Log::info('OTP Message: ' . $message);

            $result = $this->adnSmsService->sendOtp($phoneNumber, $message);

            if (is_array($result) && array_key_exists('status', $result)) {
                if ($result['status']) {
                    // \Log::info('OTP SMS Sent successfully', ['tutor_id' => $tutorId]);
                } else {
                    \Log::error('Error sending OTP SMS', ['affioliate_id' => $affiliateId, 'error_message' => $result['message']]);
                }
            } else {
                \Log::error('Unexpected response from sendOtp method', ['affioliate_id' => $affiliateId, 'response' => $result]);
            }
        } catch (\Exception $e) {
            \Log::error('Exception while sending OTP SMS', ['affioliate_id' => $affiliateId, 'exception_message' => $e->getMessage()]);
        }
    }
    public function register(Request $request)
    {
        $validator = Validator()->make($request->all(),[
            'name' => 'required',
            'email' => 'nullable',
            'phone'=> 'required|regex:/(01)[0-9]{9}/|unique:affiliate_users',
            'password' => 'required|min:8',
            'confirm_password' =>'same:password'
        ]);
        if ($validator->fails())
        {
            return response()->json(['status'=>false,'error'=>$validator->errors()]);
        }

        $expiry = Carbon::now()->addMinutes(10);
        $dateTime = new DateTime($expiry);
        $minutes = $dateTime->format('h:i');


        $affiliate = new AffiliateUser();
        $affiliate->name = $request->name;
        $affiliate->phone = $request->phone;
        $affiliate->email = $request->email;
        $affiliate->gender = $request->gender;
        $affiliate->password = Hash::make($request->password);
        $affiliate->otp = rand(1234,9999);
        $affiliate->otp_expiry=$expiry;
        $affiliate->save();

        $affiliate->get_affiliate_unique_id();


        $data = [

            "id" => $affiliate->id,
            "name" => $affiliate->name,
            "phone" => $affiliate->phone,
            "otp" => $affiliate->otp,

        ];

        return response()->json(['status'=>true,'message'=>'Registration Successfully!','data' =>$data]);

    }

    public function VerifyPhone(Request $request)
    {

        try{

            $validator = Validator()->make($request->all(),[
                'phone_otp' => 'required|numeric',
            ]);
            if ($validator->fails())
            {
                return response()->json(['status'=>false,'error'=>$validator->errors()]);
            }
            $check_Otp = AffiliateUser::where('phone',$request->phone)->first();
            if ($check_Otp->phone_verified_at)
            {
                return response()->json(['status'=>false,'error'=>'your Phone Number Already Verified! ']);
            }
             if($check_Otp->otp && Carbon::now()->lt($check_Otp->otp_expiry))
                {
                if ($check_Otp->otp == $request->phone_otp)
                {
                    $check_Otp->phone_verified_at =now();
                    $check_Otp->save();

                    // $token = $this->createCustomToken($check_Otp, 'affiliates');


                    return response()->json(['status'=>true,'message'=>'Phone verified successfully!','id'=>$check_Otp->id]);
                }else
                {
                    return response()->json(['status'=>false,'error'=>'your otp is invalid!']);
                }
            }else
            {
                return $this->resposeError('Your Otp is expired! resend again','');
            }



        }catch(Exception $e)
        {
            return $this->resposeError('',$e->getMessage());
        }

    }

    public function resend(Request $request)
    {
        try{

            $expiry = Carbon::now()->addMinutes(10);
            $dateTime = new DateTime($expiry);
            $minutes = $dateTime->format('h:i');
            $phone = $request->phone;
            $affiliate = AffiliateUser::where('phone',$phone)->first();



            if ($affiliate ) {
                    if( $affiliate->resend_otp_count != 3){
                        $affiliate->otp = rand(1234,9999);
                        $affiliate->otp_expiry =$expiry;
                        $affiliate->resend_otp_count += 1;
                        $affiliate->last_otp_resend = now();
                        $affiliate->update();
                        $resend_otp_information = [
                            'phone' => $affiliate->phone,
                            'affiliate_id' =>$affiliate->id,
                            'otp' =>$affiliate->otp,
                        ];
                        // $this->sendOtpToUser($phone, 'Your OTP is: ' . $affiliate->otp, $affiliate->id);
                        return $this->resposeSuccess('Otp Send Successfully',$resend_otp_information);

                    }else{
                        return $this->resposeError('Already Otp send 3 times! Please try after 24 hours or contact with admin','');

                    }
                }else {


                    return $this->resposeError('User Not Found!','');

                }
            }catch(Exception $e)
            {
                return response()->json(['error' => $e->getMessage()], 500);
            }

    }

    public function phoneChange(Request $request)
    {
        try {

            $validator = Validator()->make($request->all(),[
                'existing_phone' => 'required|regex:/(01)[0-9]{9}/',
                'new_phone' => 'required|regex:/(01)[0-9]{9}/|unique:affiliate_users,phone',

            ]);
            if ($validator->fails())
            {
                return response()->json(['status'=>false,'error'=>$validator->errors()]);
            }

            $affiliate = AffiliateUser::where('phone', $request->existing_phone)->first();

            if (!$affiliate) {
                return response()->json(['status' => false, 'error' => 'Affiliate Id not found for the provided existing phone number'], 404);
            }

            $expiry = Carbon::now()->addMinutes(10);

            $affiliate->otp = rand(1234, 9999);
            $affiliate->otp_expiry = $expiry;

            $affiliate->phone = $request->new_phone;
            $affiliate->phone_verified_at = Null;


            $updated = $affiliate->update();

            if (!$updated) {
                return response()->json(['status' => false, 'error' => 'Failed to update affiliate information'], 500);
            }

            $this->sendOtpToUser($request->new_phone, 'Your OTP is: ' . $affiliate->otp, $affiliate->id);

            return response()->json(['status' => true, 'message' => 'Affiliate Number Update Successful!']);
        } catch (Exception $e) {
            \Log::error($e);
            return response()->json(['status' => false, 'error' => 'Internal Server Error'], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator()->make($request->all(), [
                'phone'    => 'required',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }

            $credentials = [
                'password' => $request->password,
            ];

            if (is_numeric($request->get('phone'))) {
                $credentials['phone'] = $request->phone;
            } elseif (filter_var($request->get('phone'), FILTER_VALIDATE_EMAIL)) {
                $credentials['email'] = $request->phone;
            } else {
                return response()->json(['status' => false, 'message' => 'Invalid phone number or email format']);
            }

            if (Auth::guard('affiliate')->attempt($credentials)) {
                $affiliate = Auth::guard('affiliate')->user();

                if($affiliate->phone_verified_at != null)
                {
                    $token = $this->createCustomToken($affiliate, 'affiliates');
                    return response()->json(['status' => true, 'message' => 'Login Successfully!', 'token' => $token, 'user' => $affiliate]);
                }else
                {
                 return response()->json(['status'=>false,'message'=>'Please verified your phone']);
                }

            } else {
                return response()->json(['status' => false, 'message' => 'Username or password invalid']);
            }
        } catch (Exception $e) {
            return $this->resposeError('', $e->getMessage());
        }

    }
}
