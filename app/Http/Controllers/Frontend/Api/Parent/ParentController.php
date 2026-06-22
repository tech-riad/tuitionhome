<?php

namespace App\Http\Controllers\Frontend\Api\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\FnfLead;
use App\Models\Lead;
use App\Models\ParentLog;
use App\Models\JobOffer;
use App\Models\PopupImageData;
use App\Models\HiringRequest;
use App\Models\Parents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmailOtp;
use App\Services\AdnSmsService;
use Exception;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\JobOfferServiceInterface;
use App\Mail\PasswordResetEmail;
use App\Models\JobApplication;
use App\Models\ParentPersonalInfo;
use App\Models\ParentStatusNote;
use App\Models\Subject;
use App\Models\Tutor;
use App\Models\TutorReview;
use App\Models\VideoTutoial;
use App\Transformers\JobOfferResource;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use File;
use Illuminate\Support\Facades\Cache;

class ParentController extends Controller
{
    use ApiResponse;
//    Parents register method
    private $adnSmsService;
    private $jobOfferRepository;
    public function __construct( AdnSmsService $adnSmsService, JobOfferServiceInterface $jobOfferRepository)
    {
        $this->adnSmsService = $adnSmsService;
        $this->jobOfferRepository = $jobOfferRepository;
    }

    public function checkEmail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'email|required',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }



            $email = $request->email;

            $parent = Parents::where('email', $email)->first();



            if ($parent === null) {
                return response()->json(['status' => false, 'message' => 'User Not Found!']);
            } elseif ($parent->email !== $email) {
                return response()->json(['status' => false, 'message' => 'Invalid email for the user!']);
            } else {
                $email_otp = rand(1234, 9999);
                $parent->email_otp = $email_otp;
                Mail::to($email)->send( new PasswordResetEmail([
                    'name'=> $parent->name,
                    'otp'=> $email_otp,
                    'email'=> $parent->email,
                ]));
                $parent->save();
                return response()->json(['status' => true, 'message' => 'Email sended successfull!']);
            }
        } catch (ValidationException $e) {
            return response()->json(['status' => false, 'error' => $e->errors()]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }
    }

    public function latLongSave(Request $request)
    {
        $lat  = $request->lat;
        $long = $request->long;
    
        Parents::where('id', Auth::id())->update([
            'lat'  => $lat,
            'long' => $long,
        ]);
    
        return response()->json([
            'status' => true,
            'message' => 'Location updated successfully'
        ]);
    }
     public function latLongGate()
    {
        $parent = Parents::where('id', Auth::id())
            ->select('lat','long')
            ->first();
    
        return response()->json([
            'status' => true,
            'data' => $parent
        ]);
    }
    public function updatePasswordEmail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'parent_id'           => 'required',
                'new_password'       => 'required|min:6',
                'confirm_password'   => 'required|same:new_password',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $current_user = Parents::find($request->parent_id);

            if ($current_user) {
                if ($current_user->email_verified_at != null ){
                    $current_user->password = Hash::make($request->new_password);
                    $current_user->save();

                    return response()->json(['status' => true, 'message' => 'Password changed successfully!']);

            }
            else{
                return response()->json(['status' => false, 'message' => 'Verified Email FIrst!']);
            }
        }

        } catch (Exception $e) {
            return $this->resposeError('', $e->getMessage());
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email'       => 'email|required',
                'email_otp'   => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $parent = Parents::where('email',$request->email)->first();
            if ($parent) {
                    if ($parent->email_otp == $request->email_otp) {
                        $parent->email_verified_at = now();
                        $parent->save();

                        $data = [
                            'parent_id' => $parent->id,
                        ];
                        return response()->json(['status' => true, 'message' => 'Email verified successfully.', 'data' => $data]);
                    } else {
                        return $this->resposeError('Your OTP is invalid!', '');
                    }

            } else {
                return $this->resposeError('User Not Found!', '');
            }
            $parent_info = [
                'parent_id' => $parent->id,
            ];
            return $this->resposeSuccess('Update Your Password Now', $parent_info);

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => 'Internal Server Error'], 500);
        }

    }



    public function getTutorial()
    {
        try {
            $video = VideoTutoial::where('tutorial_type', 'parent')->paginate(12);

            $data = [];

            foreach ($video as $item) {
                $data[] = [
                    'id' => $item->id,
                    'video_type' => $item->tutorial_type,
                    'title' => $item->video_title,
                    'link' => $item->video_link,
                ];
            }

            return response()->json([
                'video' => $data,
                'meta' => [
                    'current_page' => $video->currentPage(),
                    'per_page' => $video->perPage(),
                    'total' => $video->total(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function allUser()
    {
        $parents = Parents::all();
        $total = $parents->count();
        return $this->resposeSuccess('Total Parents = '.$total,$parents);
    }
    private function createCustomToken($user, $scope)
    {
        $token = $user->createToken($user->name, [$scope]);

        $token->token->expires_at = now()->addDays(7);
        $token->token->save();

        return $token->accessToken;
    }
    private function sendOtpToUser($phoneNumber, $message, $parentId)
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
    public function register(Request $request)
    {
        try{

            $validator = Validator()->make($request->all(),[
                'name' => 'required',
                'email' => 'nullable',
                'phone'=> 'required|regex:/(01)[0-9]{9}/|unique:parents',
                'password' => 'required|min:6',
                'confirm_password' =>'same:password'
            ]);

            if ($validator->fails())
            {
                return response()->json(['status'=>false,'error'=>$validator->errors()]);
            }
        //        $data = $request->all();
            $expiry = Carbon::now()->addMinutes(10);
            $dateTime = new DateTime($expiry);
            $minutes = $dateTime->format('h:i');
            $parent = new Parents();
            $parent->name = $request->name;
            $parent->phone = $request->phone;
            $parent->email = $request->email;
            $parent->password = Hash::make($request->password);
            $parent->otp = rand(1234,9999);
            $parent->otp_expiry=$expiry;
            $parent->save();

            $parent->get_parent_unique_id();
            $parent_log =  new ParentLog();
            $parent_log->parents_id = $parent->id;
            $parent_log->name = $request->name;
            $parent_log->phone = $request->phone;
            $parent_log->save();

            $data = [

                "id" => $parent->id,
                "name" => $parent->name,
                "phone" => $parent->phone,

            ];
            $this->sendOtpToUser($request->phone, 'Your OTP is: ' . $parent->otp, $parent->id);


            return response()->json(['status'=>true,'message'=>'Your profile registration has been verified successfully.','data' =>$data]);

        }catch(Exception $e)
        {
            return $this->resposeError('',$e->getMessage());
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

            if (Auth::guard('parent')->attempt($credentials)) {
                $parent = Auth::guard('parent')->user()->makeHidden(['otp', 'email_otp']);

                if($parent->phone_verified_at != null)
                {
                    $token = $this->createCustomToken($parent, 'parents');
                    return response()->json(['status' => true, 'message' => 'Login Successfully!', 'token' => $token, 'user' => $parent]);
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

    public function updateName(Request $request)
    {

            $validator = Validator()->make($request->all(),[
               'name'=> 'required'
            ]);
            if ($validator->fails())
            {
                return response()->json(['status'=>false,'error'=>$validator->errors()]);
            }
        try {
            $update_name = Parents::find(Auth::user()->id);
            if ($update_name)
            {
                $update_name->name = $request->name;
                $update_name->save();
                $parent_log = new ParentLog();
                $parent_log->parents_id = Auth::user()->id;
                $parent_log->name = $request->name;
                $parent_log->save();
                return response()->json(['status'=>true,'message'=>'Name Update Successfully!']);

            }else
            {
                return response()->json(['status'=>false,'message'=>'Id not Found! ']);
            }

        }catch (Exception $e)
        {
            return response()->json(['status'=>$e->getCode(),'message'=> $e->getMessage()]);
        }

    }


    public function updatePhone(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone'     => 'required|regex:/(01)[0-9]{9}/|unique:parents',
                'parent_id'  => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $update_phone = Parents::where('id',$request->parent_id)->first();

            // dd($update_phone);

            if ($update_phone) {
                if ($update_phone->phone != $request->phone) {


                    $phone_otp = rand(1234, 9999);
                    $otpExpiry = now()->addMinutes(5);
                    $update_phone->otp = $phone_otp;
                    $update_phone->otp_expiry = $otpExpiry;
                    $this->sendOtpToUser($request->phone, 'Your OTP is: ' . $phone_otp, $update_phone->id);

                    $update_phone->save();


                    return response()->json(['status' => true, 'message' => 'OTP sent successfully!', 'otp' => $phone_otp]);

                } else {
                    return response()->json(['status' => false, 'message' => 'The number is already verified.']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Tutor ID not found!']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
    public function verifyPhoneOtpAndUpdate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'otp'        => 'required|numeric',
                'parent_id'   => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $check_Otp = Parents::find($request->parent_id);

            if ($check_Otp->otp && Carbon::now()->lt($check_Otp->otp_expiry)) {
                if ($check_Otp->otp == $request->otp) {
                    if ($request->has('phone')) {

                        $check_Otp->phone_verified_at = now();
                        $check_Otp->phone = $request->phone;
                        $check_Otp->save();

                        $parent_log = new ParentLog();
                        $parent_log->parents_id = $request->parent_id;
                        $parent_log->phone = $request->phone;
                        $parent_log->save();

                        $parent_log->save();

                        return response()->json(['status' => true, 'message' => 'Phone verified and updated successfully!']);
                    } else {
                        return response()->json(['status' => false, 'error' => 'Phone number is required for verification and update!']);
                    }
                } else {
                    return response()->json(['status' => false, 'error' => 'Invalid OTP!']);
                }
            } else {
                return response()->json(['status' => false, 'error' => 'Your OTP is expired! Resend again.', 'otp_expiry' => $check_Otp->otp_expiry, 'current_time' => now()]);
            }




        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
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
            $check_Otp = Parents::find($request->id);
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

                    $token = $this->createCustomToken($check_Otp, 'parents');


                    return response()->json(['status'=>true,'message'=>'Phone verified successfully!','data' => $token,'id'=>$check_Otp->id]);
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

    public function phoneChange(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'existing_phone' => 'required|regex:/(01)[0-9]{9}/',
                'new_phone' => 'required|regex:/(01)[0-9]{9}/|unique:parents,phone',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $parent = Parents::where('phone', $request->existing_phone)->first();

            if (!$parent) {
                return response()->json(['status' => false, 'error' => 'Parent not found for the provided existing phone number'], 404);
            }

            $expiry = Carbon::now()->addMinutes(10);

            $parent->otp = rand(1234, 9999);
            $parent->otp_expiry = $expiry;

            $parent->phone = $request->new_phone;

            $updated = $parent->update();

            if (!$updated) {
                return response()->json(['status' => false, 'error' => 'Failed to update parent information'], 500);
            }

            $this->sendOtpToUser($request->new_phone, 'Your OTP is: ' . $parent->otp, $parent->id);

            return response()->json(['status' => true, 'message' => 'Parent Number Update Successful!']);
        } catch (Exception $e) {
            \Log::error($e);
            return response()->json(['status' => false, 'error' => 'Internal Server Error'], 500);
        }
    }

    public function resend(Request $request)
    {
        try{

            $expiry = Carbon::now()->addMinutes(10);
            $dateTime = new DateTime($expiry);
            $minutes = $dateTime->format('h:i');
            $phone = $request->phone;
            $parent = Parents::where('phone',$phone)->first();



            if ($parent ) {
                    if( $parent->resend_otp_count != 3){
                        $parent->otp = rand(1234,9999);
                        $parent->otp_expiry =$expiry;
                        $parent->resend_otp_count += 1;
                        $parent->last_otp_resend = now();
                        $parent->update();
                        $resend_otp_information = [
                            'phoen' => $parent->phone,
                            'parent_id' =>$parent->id,
                        ];
                        $this->sendOtpToUser($phone, 'Your OTP is: ' . $parent->otp, $parent->id);
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
    public function getEmail($id)
    {
        try{


        $get_email = Parents::findOrFail($id)->pluck('email');
        if ($get_email)
        {
            return response()->json(['staus'=>true,'message'=> 'Email get successfully','email'=>$get_email]);
        }else
        {
            return response()->json(['staus'=>false,'message'=> 'Email Not found']);
        }

        }catch(Exception $e)
        {
            return $this->resposeError('',$e->getMessage());
        }


    }
    public function updateEmail(Request $request)
    {

        try{

            $validator = Validator()->make($request->all(),[
                'email'=> 'required|email',
            ]);
            if ($validator->fails())
            {
                return response()->json(['status'=>false,'error'=>$validator->errors()]);
            }

            $email_otp = rand(1234,9999);
            $email = $request->email;
            $update_email = Parents::find(Auth::user()->id);

            $update_email->email_otp = $email_otp;

            $update_email->save();

            $parent_log = new ParentLog();
            $parent_log->parents_id = Auth::user()->id;
            $parent_log->email = $request->email;
            $parent_log->save();


                Mail::to($request->email)->send( new VerifyEmailOtp([
                    'name'=> $update_email->name,
                    'email'=> $update_email->email,
                    'otp'=> $email_otp,
                ]));
                return response()->json(['status'=>true,'message'=>'Email verification code sent Successfully!']);



        }catch(Exception $e)
        {
            return $this->resposeError('',$e->getMessage());
        }



    }

    public function emailVerified(Request $request)
    {

        try{
            $validator = Validator()->make($request->all(),[
                'email_otp' => 'required|numeric',
                'email'=> 'required|email',
             ]);

             if ($validator->fails())
             {
                 return response()->json(['status'=>false,'error'=>$validator->errors()]);
             }
             $check_Otp = Parents::find(Auth::user()->id);
             if ($check_Otp->email_otp == $request->email_otp)
             {
                 $check_Otp->email_verified_at =now();
                 $check_Otp->email =$request->email;
                 $check_Otp->save();
                 return response()->json(['status'=>true,'message'=>'E-mail verified successfully!']);
             }else
             {
                 return response()->json(['status'=>false,'error'=>'your otp is invalid!']);
             }


        }catch(Exception $e)
        {
            return $this->resposeError('',$e->getMessage());
        }

    }

    public function change_password(Request $request)
    {
        try{

            $validator = Validator()->make($request->all(),[
                'current_password' => 'required',
                'new_password' => 'required|min:6',
                'confirm_password' => 'required|same:new_password',
            ]);
            if ($validator->fails())
            {
                return response()->json(['status'=>false,'error'=>$validator->errors()]);
            }

            $current_user = Parents::find(Auth::user()->id);

            if($current_user){
                if(Hash::check($request->current_password,$current_user->password))
            {
                $current_user->password = Hash::make($request->new_password);
                $current_user->save();
                return response()->json(['status'=>true,'message'=>'Password change Successfully!']);
            }else
            {
                return response()->json(['status'=>false,'message'=>'Current password did not match!']);
            }

            }


        }catch(Exception $e)
        {
            return $this->resposeError('',$e->getMessage());
        }



    }

    public function logout(Request $request)
    {
        try{

            $request->user()->token()->revoke();
            return response()->json([
                'status' =>true,
                'message' => 'Successfully logged out.'
            ]);



        }catch(Exception $e)
        {
            return $this->resposeError('',$e->getMessage());
        }

    }


    public function jobStore(Request $request)
    {
        try{

            $validator = Validator()->make($request->all(),[

                'country_id' => 'required',
                'city_id' => 'required',
                'location_id' => 'required',
                'student_gender' => 'required',
                'address' => 'required',
                'category_id' => 'required',
                'course_id' => 'required',
                'subject_id' => 'required',
                'tutor_gender' => 'required',

            ]);
            if ($validator->fails())
            {
                return response()->json(['status'=>false,'error'=>$validator->errors()]);
            }

            if (Auth::user()->id)
            {
                $parent = ParentPersonalInfo::updateOrCreate(
                    ['parents_id' => Auth::user()->id],
                    [
                        'country_id' => $request->country_id,
                        'city_id' => $request->city_id,
                        'location_id' => $request->location_id
                    ]
                );


                $job_request = new Lead();
                $job_request->parents_id = Auth::user()->id;
                $job_request->country_id = $request->country_id;
                $job_request->city_id = $request->city_id;
                $job_request->location_id = $request->location_id;
                $job_request->student_gender = $request->student_gender;
                $job_request->address = $request->address;
                $job_request->category_id = $request->category_id;
                $job_request->course_id = $request->course_id;
                $job_request->subject_id = implode(',',$request->subject_id);
                $job_request->tutor_gender = $request->tutor_gender;
                $job_request->addition_requirement = $request->additional_requirement;
                $job_request->save();
                return response()->json(['status'=>true,'message'=>'Job created successfully!']);
            }else
            {
                return response()->json(['status'=>false,'message'=>'Parents id not found!']);
            }


        }catch(Exception $e)
        {
            return $this->resposeError('',$e->getMessage());
        }


    }

    public function fnfStore(Request $request)
    {

        try{

            $validator = Validator()->make($request->all(),[

                'name' => 'nullable',
                'location' => 'nullable',
                'tutor_gender' => 'nullable',
                'course' => 'nullable',
                'subject' => 'nullable',
                'phone' => 'required|regex:/^01[0-9]{9}$/|max:11',

            ]);
            if ($validator->fails())
            {
                return response()->json(['status'=>false,'error'=>$validator->errors()]);
            }

            if ($request->id)
            {
                $fnf_request = new FnfLead();
                $fnf_request->parents_id = $request->id;
                $fnf_request->name = $request->name;
                $fnf_request->location = $request->location;
                $fnf_request->tutor_gender = $request->tutor_gender;
                $fnf_request->course = $request->course;
                $fnf_request->subject = $request->subject;
                $fnf_request->phone = $request->phone;
                $fnf_request->save();
                return response()->json(['status'=>true,'message'=>'FnF references created successfully.']);

            }else
            {
                return response()->json(['status'=>true,'message'=>'Parents id not found Please input parents id!']);
            }

        }catch(Exception $e)
        {
            return $this->resposeError('',$e->getMessage());
        }


    }

    public function liveOnJob(Request $request)
    {

        $perPage = $request->input('per_page', 12);

        $jobOffers = JobOffer::where('parent_id',Auth::user()->id)
                    ->where('is_active',1)
                    ->paginate($perPage);

        $paginationMeta = [
            'current_page' => $jobOffers->currentPage(),
            'per_page' => $jobOffers->perPage(),
            'total' => $jobOffers->total(),
            'totalJobOffers' => $jobOffers->count(),
        ];

        return $this->resposeSuccess('data get successfully', [
            'job_offers' => JobOfferResource::collection($jobOffers),
            'meta' => $paginationMeta,
        ]);
    }
    public function liveOffJob(Request $request)
    {

        $perPage = $request->input('per_page', 12);

        $jobOffers = JobOffer::where('parent_id',Auth::user()->id)
                    ->where('is_active',0)
                    ->paginate($perPage);


        $paginationMeta = [
            'current_page' => $jobOffers->currentPage(),
            'per_page' => $jobOffers->perPage(),
            'total' => $jobOffers->total(),
            'totalJobOffers' => $jobOffers->count(),
        ];

        return $this->resposeSuccess('data get successfully', [
            'job_offers' => JobOfferResource::collection($jobOffers),
            'meta' => $paginationMeta,
        ]);
    }

    public function requestJobStatus(Request $request, $id)
    {
        $countPending = Lead::where('parents_id', $id)
                            ->where('status', 'Pending')
                            ->count();

        $countApproved = Lead::where('parents_id', $id)
                            ->where('status', 'Accepted')
                            ->count();

        $countCancel = Lead::where('parents_id', $id)
                        ->where('status', 'Cancel')
                        ->count();
        // Request Job
        $pendingJob = [];
        $requestJobPending = Lead::where('parents_id', $id)
                                ->where('status', 'Pending')
                                ->orderBy('id','desc')
                                ->get();

        foreach ($requestJobPending as $job) {
            $pendingJob[] = $this->requestjob($job);
        }
        // Approved Job
        $approvedJob = [];
        $requestJobApproved = Lead::where('parents_id', $id)
                                ->where('status', 'Accepted')
                                ->orderBy('id','desc')
                                ->get();

        foreach ($requestJobApproved as $job) {
            $approvedJob[] = $this->requestjob($job);
        }
        // Approved Job
        $cancelJob = [];
        $requestJobCancel = Lead::where('parents_id', $id)
                                ->where('status', 'Cancel')
                                ->orderBy('id','desc')
                                ->get();

        foreach ($requestJobCancel as $job) {
            $cancelJob[] = $this->requestjob($job);
        }

        $platformStatus = [
            'countPending'  => $countPending,
            'countApproved' => $countApproved,
            'countCancel'   => $countCancel,
        ];

        return $this->resposeSuccess('Data retrieved successfully', [
            'status'        => $platformStatus,
            'pendingJob'    => $pendingJob,
            'approvedJob'   => $approvedJob,
            'cancelJob'     => $cancelJob,
        ]);
    }



    //
    public function requestPostedJobStatus($id)
    {
        $approveJobCount = JobOffer::where('parent_id',$id)->count();
        $liveOnJobCount = JobOffer::where('parent_id',$id)->where('is_active',1)->count();
        $liveOffJobCount = JobOffer::where('parent_id',$id)->where('is_active',0)->count();

        return $this->resposeSuccess('Data retrieved successfully', [
            'approveJobCount'        => $approveJobCount,
            'liveOnJobCount'         => $liveOnJobCount,
            'liveOffJobCount'        => $liveOffJobCount,
        ]);
    }
    // Job Status
    public function parentJobStatus($id)
    {
        $requestedJobCount = Lead::where('parents_id', $id)->count();
        $approvedJobCount = Lead::where('parents_id', $id)
                            ->where('status', 'Accepted')
                            ->count();
        $appointedJobCount = JobOffer::where('parent_id', $id)
                            ->where(function ($query) {
                                $query->whereNotNull('taken_by_1')
                                      ->orWhereNotNull('taken_by_2');
                            })
                            ->count();

        $allJob = JobOffer::where('parent_id', $id)->pluck('id');
        $confirmJobCount = JobApplication::whereIn('job_offer_id',$allJob)
                            ->where('current_stage','confirm')->count();
        $allJobIds = JobOffer::where('parent_id', $id)->pluck('id');


        $cancelJobCount = JobOffer::where('parent_id', $id)
                            ->whereHas('jobApplications', function ($query) {
                                $query->where('current_stage', 'closed');
                            })
                            ->whereDoesntHave('jobApplications', function ($query) {
                                $query->where('current_stage', '!=', 'closed');
                            })
                            ->count();





        // Request Job
        $requestJob = [];
        $requestJobAll = Lead::where('parents_id', $id)
                                ->orderBy('id','desc')
                                ->get();

        foreach ($requestJobAll as $job) {
            $requestJob[] = $this->requestjob($job);
        }
        // Approve Job
        $approveJob = [];
        $approveJobAll = JobOffer::where('parent_id', $id)
                          ->orderBy('id', 'desc')
                          ->get();

        foreach ($approveJobAll as $jobOffer) {
            $approveJob[] = new JobOfferResource($jobOffer);
        }

        // Appointed Job
        $appointedJob = [];
        $approveJobOfferIds = JobOffer::where('parent_id', $id)
                                ->pluck('id');

        $appointedJobs = JobApplication::whereIn('job_offer_id', $approveJobOfferIds)
                                ->whereNotNull('taken_at')
                                ->pluck('job_offer_id');


        foreach ($appointedJobs as $jobOffer) {
            $job = JobOffer::where('id',$jobOffer)->first();
            $appointedJob[] = new JobOfferResource($job);
        }
        // Confirm Job
        $confirmJob = [];
        $confirmJobOfferIds = JobOffer::where('parent_id', $id)
                                ->pluck('id');

        $confirmJobs = JobApplication::whereIn('job_offer_id', $confirmJobOfferIds)
                                ->where('current_stage','confirm')
                                ->pluck('job_offer_id');


        foreach ($confirmJobs as $jobOffer) {
            $job = JobOffer::where('id',$jobOffer)->first();
            $confirmJob[] = new JobOfferResource($job);
        }
        // Close Job

        $closeJobOfferIds = JobOffer::where('parent_id', $id)
            ->pluck('id');

        $closedApplications = JobApplication::whereIn('job_offer_id', $closeJobOfferIds)
            ->select('job_offer_id', 'current_stage')
            ->get()
            ->groupBy('job_offer_id');

        $closedJobOfferIds = [];

        foreach ($closedApplications as $jobOfferId => $applications) {
            if ($applications->every(fn($app) => $app->current_stage === 'closed')) {
                $closedJobOfferIds[] = $jobOfferId;
            }
        }

        $closeJob = JobOffer::whereIn('id', $closedJobOfferIds)
            ->get()
            ->map(fn($job) => new JobOfferResource($job));



        return $this->resposeSuccess('Data retrieved successfully', [
            'requestedJobCount'  => $requestedJobCount,
            'approvedJobCount'  => $approvedJobCount,
            'appointedJobCount'  => $appointedJobCount,
            'confirmJobCount'  => $confirmJobCount,
            'cancelJobCount'  => $cancelJobCount,
            'requestJob'  => $requestJob,
            'approveJob'  => $approveJob,
            'appointedJob'  => $appointedJob,
            'confirmJob'  => $confirmJob,
            'closeJob'  => $closeJob,
        ]);
    }

    // Job Function
    public function requestjob($job)
    {

        $subjectIds = explode(',', $job->subject_id);


        $subjectNames = Subject::whereIn('id', $subjectIds)->pluck('title')->toArray();
        return [
            'slNo'          => $job->id,
            'courseName'    => $job->course->name ?? '',
            'cityName'      => $job->city->name ?? '',
            'locationName'  => $job->location->name ?? '',
            'categoryName'  => $job->category->name ?? '',
            'tutorGender'   => $job->tutor_gender ?? '',
            'studentGender' => $job->student_gender ?? '',
            'status'        => $job->status,
            'subjectNames'  => $subjectNames,
            'created_at'    => $job->created_at->format('Y-m-d H:i:s'),
            'jobStatus'    => $job->status ?? '',
        ];
    }

    public function parentConfirmLatter($id)
    {
        $confirmJobsData = [];

        $confirmJobOfferIds = JobOffer::where('parent_id', $id)->pluck('id');

        $confirmJobs = JobApplication::whereIn('job_offer_id', $confirmJobOfferIds)
                                    ->where('current_stage', 'confirm')
                                    ->get();

        foreach ($confirmJobs as $jobApplication) {
            $job = JobOffer::find($jobApplication->job_offer_id);
            $tutor = Tutor::find($jobApplication->tutor_id);

            if ($job && $tutor) {
                $tutor_id = $tutor->unique_id ?? null;
                $application_status = $jobApplication->application_status;
                $application_id = $jobApplication->id;

                $confirmJobsData[] = [
                    'job' => new JobOfferResource($job),
                    'tutor_id' => $tutor_id,
                    'application_status' => $application_status,
                    'application_id' => $application_id,
                ];
            }
        }

        return $this->resposeSuccess('Data retrieved successfully', [
            'confirmJobs' => $confirmJobsData,
        ]);
    }
    public function parentConfirmLatterStatus(Request $request,$id)
    {
        $application = JobApplication::where('id',$id)->first();
        $application->application_status = $request->application_status;
        $application->update();

        return response()->json(['staus'=>true,'message'=> 'Your status has been changed successfully.']);

    }


    public function sendRequest(Request $request)
    {
        if($request->request_type == 'category')
        {
            $hirerequest = new HiringRequest();
            $hirerequest->parent_id = Auth::user()->id;
            $hirerequest->category_id = $request->category_id;
            $hirerequest->category_title = $request->category_title;
            $hirerequest->request_type = $request->request_type;
            $hirerequest->save();

            return response()->json(['staus'=>true,'message'=> 'Your requirement sent successfully']);
        }elseif($request->request_type == 'tutor')
        {
            $hirerequest = new HiringRequest();
            $hirerequest->parent_id = Auth::user()->id;
            $hirerequest->tutor_id = $request->tutor_id;
            $hirerequest->request_type = $request->request_type;
            $hirerequest->save();

            return response()->json(['staus'=>true,'message'=> 'Your requirement sent successfully']);

        }
    }

    public function tutorCategoryRequest(Request $request)
    {
        $per_page = $request->per_page;
        $tutorHireRequests = HiringRequest::where('parent_id', Auth::user()->id)
            ->with(['hiringRequestNotes' => function ($query) {
                $query->where('note_type', 'parent_note')->orderBy('id', 'desc');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate($per_page);


        $transformedRequests = $tutorHireRequests->map(function ($request) {
            return [
                'id' => $request->id,
                'parent_id' => $request->parent_id,
                'status' => $request->status,
                'category_id' => $request->category_id,
                'tutor_id' => $request->tutor_id,
                'tutor_name' => $request->tutor->name ?? '',
                'request_type' => $request->request_type,
                'category_title' => $request->category_title,
                'added_by' => $request->added_by,
                'created_at' => $request->created_at->toISOString(),
                'updated_at' => $request->updated_at->toISOString(),
                'hiring_request_notes' => $request->hiringRequestNotes->map(function ($note) {
                    return [
                        'id' => $note->id,
                        'content' => $note->note,
                        'created_at' => $note->created_at->toISOString(),
                    ];
                }),
            ];
        });


        return $this->resposeSuccess('Data retrieved successfully', [
            'data' => $transformedRequests,
            'meta' => [
                'current_page' => $tutorHireRequests->currentPage(),
                'total' => $tutorHireRequests->total(),
                'per_page' => $tutorHireRequests->perPage(),
                'last_page' => $tutorHireRequests->lastPage(),
                'next_page_url' => $tutorHireRequests->nextPageUrl(),
                'prev_page_url' => $tutorHireRequests->previousPageUrl(),
            ],
        ]);
    }


    public function tutorCategorySearch(Request $request)
    {
        $per_page = $request->per_page ?? 10;
        $search = $request->search;

        $query = HiringRequest::where('parent_id', Auth::user()->id)
            ->with(['hiringRequestNotes' => function ($query) {
                $query->where('note_type', 'parent_note')->orderBy('id', 'desc');
            }]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tutor_id', 'LIKE', "%$search%")
                ->orWhere('category_title', 'LIKE', "%$search%")
                ->orWhere('request_type', 'LIKE', "%$search%");
            });
        }

        $tutorHireRequests = $query->orderBy('created_at', 'desc')->paginate($per_page);

        $transformedRequests = $tutorHireRequests->map(function ($request) {
            return [
                'id' => $request->id,
                'parent_id' => $request->parent_id,
                'status' => $request->status,
                'category_id' => $request->category_id,
                'tutor_id' => $request->tutor_id,
                'tutor_name' => $request->tutor->name ?? '',
                'request_type' => $request->request_type,
                'category_title' => $request->category_title,
                'added_by' => $request->added_by,
                'created_at' => $request->created_at->toISOString(),
                'updated_at' => $request->updated_at->toISOString(),
                'hiring_request_notes' => $request->hiringRequestNotes->map(function ($note) {
                    return [
                        'id' => $note->id,
                        'content' => $note->note,
                        'created_at' => $note->created_at->toISOString(),
                    ];
                }),
            ];
        });

        return $this->resposeSuccess('Data retrieved successfully', [
            'data' => $transformedRequests,
            'meta' => [
                'current_page' => $tutorHireRequests->currentPage(),
                'total' => $tutorHireRequests->total(),
                'per_page' => $tutorHireRequests->perPage(),
                'last_page' => $tutorHireRequests->lastPage(),
                'next_page_url' => $tutorHireRequests->nextPageUrl(),
                'prev_page_url' => $tutorHireRequests->previousPageUrl(),
            ],
        ]);
    }

    public function parentFnfJobStatus($id)
    {
        $pendingJobsData = [];
        $approveJobsData = [];
        $cancelJobsData = [];
        $pendingJobs = FnfLead::where('status','Pending')->get();
        $approveJobs = FnfLead::where('status','Accepted')->get();
        $cancelJobs = FnfLead::where('status','Cancel')->get();

        foreach ($pendingJobs as $pendingJob) {
            $pendingJobsData[] = [
                'slNo'          => $pendingJob->id,
                'courseName'    => $pendingJob->course ?? '',
                'locationName'  => $pendingJob->location ?? '',
                'tutorGender'   => $pendingJob->tutor_gender ?? '',
                'status'        => $pendingJob->status,
                'subjectNames'  => $pendingJob->subject,
                'created_at'    => $pendingJob->created_at->format('Y-m-d H:i:s'),
            ];
        }
        foreach ($approveJobs as $approveJob) {
            $approveJobsData[] = [
                'slNo'          => $approveJob->id,
                'courseName'    => $approveJob->course ?? '',
                'locationName'  => $approveJob->location ?? '',
                'tutorGender'   => $approveJob->tutor_gender ?? '',
                'status'        => $approveJob->status,
                'subjectNames'  => $approveJob->subject,
                'created_at'    => $approveJob->created_at->format('Y-m-d H:i:s'),
            ];
        }
        foreach ($cancelJobs as $cancelJob) {
            $cancelJobsData[] = [
                'slNo'          => $cancelJob->id,
                'courseName'    => $cancelJob->course ?? '',
                'locationName'  => $cancelJob->location ?? '',
                'tutorGender'   => $cancelJob->tutor_gender ?? '',
                'status'        => $cancelJob->status,
                'subjectNames'  => $cancelJob->subject,
                'created_at'    => $cancelJob->created_at->format('Y-m-d H:i:s'),
            ];
        }


        return $this->resposeSuccess('Data retrieved successfully', [

            'pendingJobsData'  => $pendingJobsData,
            'approveJobsData'  => $approveJobsData,
            'cancelJobsData'  => $cancelJobsData,
        ]);
    }


    public function profileImageUpload(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'parent_id' => 'required|exists:parents,id',
                'image'    => 'required|mimes:jpg,jpeg,png,bmp|max:2000',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()], 400);
            }

            $parent_id = $request->input('parent_id');
            $parent = Parents::findOrFail($parent_id);

            if ($parent->image) {
                $oldImagePath = public_path('storage/parent-images/' . $parent->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $parent_id . '_' . rand(1234, 9999) . time() . '.jpg';
                $imagePath = public_path('storage/parent-images');

                if (!File::exists($imagePath)) {
                    File::makeDirectory($imagePath, 0755, true);
                }

                $imageFullPath = $imagePath . '/' . $imageName;

                // Load the image
                $imgResource = null;
                switch (strtolower($image->getClientOriginalExtension())) {
                    case 'jpg':
                    case 'jpeg':
                        $imgResource = imagecreatefromjpeg($image->getPathname());
                        break;
                    case 'bmp':
                        $imgResource = imagecreatefrombmp($image->getPathname());
                        break;
                    case 'png':
                        $imgResource = imagecreatefrompng($image->getPathname());
                        break;
                    default:
                        throw new \Exception('Unsupported image format');
                }

                if ($imgResource) {
                    imagejpeg($imgResource, $imageFullPath, 100);
                    imagedestroy($imgResource);
                    $parent->image = $imageName;
                    $parent->save();
                }
            }


            $log_image = new ParentLog();
            if ($request->hasFile('image')) {
                $logImage = $request->file('image');
                $logImageName = $parent_id . '_' . rand(1234, 9999) . time() . '.png';
                $logImagePath = public_path('storage/parent-log-images');

                if (!File::exists($logImagePath)) {
                    File::makeDirectory($logImagePath, 0755, true);
                }

                $logImageFullPath = $logImagePath . '/' . $logImageName;

                $logImgResource = null;
                switch ($logImage->getClientOriginalExtension()) {
                    case 'jpg':
                    case 'jpeg':
                        $logImgResource = imagecreatefromjpeg($logImage->getPathname());
                        break;
                    case 'bmp':
                        $logImgResource = imagecreatefrombmp($logImage->getPathname());
                        break;
                    case 'png':
                        $logImgResource = imagecreatefrompng($logImage->getPathname());
                        break;
                }

                if ($logImgResource) {
                    imagepng($logImgResource, $logImageFullPath);
                    imagedestroy($logImgResource);
                    $log_image->image = $logImageName;
                    $log_image->parents_id = $parent_id;
                    $log_image->save();
                }
            }

            return response()->json(['message' => 'Profile Picture uploaded successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Tutor not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function tutorCategoryRequestfilter(Request $request)
    {
        $tutorHireRequestsQuery = HiringRequest::where('parent_id', Auth::user()->id)
            ->with(['hiringRequestNotes' => function ($query) {
                $query->where('note_type', 'parent_note')->orderBy('id', 'desc');
            }]);

        // Apply filters
        if ($request->filled('datef')) {
            $tutorHireRequestsQuery->whereDate('created_at', '>=', $request->input('datef'));
        }

        if ($request->filled('datet')) {
            $tutorHireRequestsQuery->whereDate('created_at', '<=', $request->input('datet'));
        }

        if ($request->filled('request_type')) {
            $tutorHireRequestsQuery->where('request_type', $request->input('request_type'));
        }

        if ($request->filled('status')) {
            $tutorHireRequestsQuery->where('status', $request->input('status'));
        }

        $perPage = $request->input('per_page', 10);
        $tutorHireRequests = $tutorHireRequestsQuery->paginate($perPage);

        $transformedRequests = $tutorHireRequests->map(function ($request) {
            return [
                'id' => $request->id,
                'parent_id' => $request->parent_id,
                'status' => $request->status,
                'category_id' => $request->category_id,
                'tutor_id' => $request->tutor_id ?? '',
                'tutor_name' => $request->tutor->name ?? '',
                'request_type' => $request->request_type,
                'category_title' => $request->category_title,
                'added_by' => $request->added_by,
                'created_at' => $request->created_at->toISOString(),
                'updated_at' => $request->updated_at->toISOString(),
                'hiring_request_notes' => $request->hiringRequestNotes->map(function ($note) {
                    return [
                        'id' => $note->id,
                        'content' => $note->note,
                        'created_at' => $note->created_at->toISOString(),
                    ];
                }),
            ];
        });


        return $this->resposeSuccess('Data retrieved successfully', [
            'data' => $transformedRequests,
            'meta' => [
                'current_page' => $tutorHireRequests->currentPage(),
                'per_page' => $tutorHireRequests->perPage(),
                'total' => $tutorHireRequests->total(),
                'last_page' => $tutorHireRequests->lastPage(),
                'from' => $tutorHireRequests->firstItem(),
                'to' => $tutorHireRequests->lastItem(),
                'next_page_url' => $tutorHireRequests->nextPageUrl(),
                'prev_page_url' => $tutorHireRequests->previousPageUrl(),
            ],
        ]);
    }


    public function smsAlert(Request $request)
    {
        $parent = Parents::where('id',Auth::user()->id)->first();


        if ($request->is_sms == 0)
        {
            $parent->is_sms = 0;
            $parent->update();
            return response()->json(['status' => true, 'message' => 'Sms alert deactive successfull!']);
        }elseif($request->is_sms == 1)
        {
            $parent->is_sms = 1;
            $parent->update();
            return response()->json(['status' => true, 'message' => 'Sms alert active successfull!']);

        }

    }

    public function activeDeactiveAccount(Request $request)
    {
        try {
            $parent = Parents::find(auth::user()->id);

            if ($request->deactivate) {
                if ($parent->is_active == 1) {
                    $parent->is_active = 0;
                    $parent->is_sms = 0;
                    $parent->deactivate_by_parent = $parent->id;
                    $parent->update();

                    $parentStstusNote = new ParentStatusNote();
                    $parentStstusNote->status = '0';
                    $parentStstusNote->changed_by = 'By Parent Own';
                    $parentStstusNote->changed_note = 'Deactivate By Own';
                    $parentStstusNote->parent_id = $parent->id;
                    $parentStstusNote->save();

                    return response()->json(['status' => true, 'message' => 'Your account deactivated Successfully!!']);
                } else {
                    return response()->json(['status' => true, 'message' => 'Your account is already deactivated!!']);
                }
            }

            if ($request->activate) {
                if ($parent->deactivate_by_admin != null) {
                    return response()->json(['status' => false, 'message' => 'To unlock your profile, please contact the administrator.']);
                } else {
                    if ($parent->is_active == 0) {
                        $parent->is_active = 1;
                        $parent->is_sms = 1;
                        $parent->update();

                        $parentStstusNote = new ParentStatusNote();
                        $parentStstusNote->status = 1;
                        $parentStstusNote->changed_by = 'By Tutor Own';
                        $parentStstusNote->changed_note = 'Activate By own';
                        $parentStstusNote->parent_id = $parent->id;
                        $parentStstusNote->save();
                        return response()->json(['status' => true, 'message' => 'Your account activated successfully!!']);
                    } else {
                        return response()->json(['status' => true, 'message' => 'Your account is already active!!']);
                    }
                }
            }
        } catch (Exception $e) {
            return $this->resposeError('', $e->getMessage());
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
            $parentPasswordReset = Parents::where('phone', $phone)->first();

            if (!$parentPasswordReset) {
                return response()->json(['status' => false, 'message' => 'User Not Found!']);
            }

            // Reset OTP resend count if 60 minutes have passed
            if ($parentPasswordReset->last_otp_resend && Carbon::now()->diffInMinutes($parentPasswordReset->last_otp_resend) >= 1440) {
                $parentPasswordReset->last_otp_resend = null;
                $parentPasswordReset->resend_otp_count = 0;
                $parentPasswordReset->save();
            }

            // OTP Request Rate Limiting (1 request per 2 minutes)
            $otpRequestLimit = 1;
            $otpRequestTimeFrame = 120; // 2 minutes

            $cacheKey = 'otp_request_count_' . $parentPasswordReset->phone;
            $otpRequestCount = Cache::get($cacheKey, 0);

            if ($otpRequestCount >= $otpRequestLimit) {
                return response()->json(['status' => false, 'message' => 'You can only request one OTP every 2 minutes. Please try again later.']);
            }

            Cache::put($cacheKey, $otpRequestCount + 1, now()->addSeconds($otpRequestTimeFrame));

            // OTP Resend Limit (3 times per 24 hours)
            $otpResendLimit = 3;
            $otpResendTimeFrame = 24 * 60; // 24 hours in minutes

            if ($parentPasswordReset->resend_otp_count >= $otpResendLimit && Carbon::now()->diffInMinutes($parentPasswordReset->last_otp_resend) < $otpResendTimeFrame) {
                return response()->json([
                    'status' => false,
                    'message' => 'You have reached the maximum OTP resend limit for today. Please try again after 24 hours or contact Tuition Home Admin over the phone.',
                ]);
            }

            // Generate and store OTP
            $phone_otp = rand(1234, 9999);
            $otpExpiry = now()->addMinutes(10);
            $parentPasswordReset->otp = $phone_otp;
            $parentPasswordReset->otp_expiry = $otpExpiry;

            $this->sendOtpToUser($request->phone, 'Your password recovery OTP is: ' . $phone_otp, $parentPasswordReset->id);

            // Update OTP resend count and timestamp
            $parentPasswordReset->resend_otp_count += 1;
            $parentPasswordReset->last_otp_resend = now();
            $parentPasswordReset->save();

            return response()->json([
                'status' => true,
                'message' => 'OTP sent successfully!',
                'phone' => $parentPasswordReset->phone,
            ]);

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
                'parent_id'           => 'required',
                'new_password'       => 'required|min:6',
                'confirm_password'   => 'required|same:new_password',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $current_user = Parents::find($request->parent_id);

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
            return $this->resposeError('', $e->getMessage());
        }
    }

    public function verifyOtpAndSavePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required|exists:tutors,phone',
                'phone_otp'   => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $parent = Parents::where('phone',$request->phone)->first();
            if ($parent) {
                if ($parent->otp && Carbon::now()->lt($parent->otp_expiry)) {
                    if ($parent->otp == $request->phone_otp) {
                        $parent->phone_verified_at = now();
                        $parent->save();

                        $data = [
                            'parent_id' => $parent->id,
                            'parent_phone' => $parent->phone,
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
            $parent_info = [
                'parent_id' => $parent->id,
                'parent_phone' => $parent->phone,
            ];
            return $this->resposeSuccess('Update your password now', $parent_info);


        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['status' => false, 'error' => 'Internal Server Error'], 500);
        }

    }

    public function popupImageData()
    {
        $popupImage = PopupImageData::where('parent_id',auth::user()->id)->where('status',1)->get();
        if ($popupImage)
        {
            return response()->json(['status'=>true,'message'=>'Get popup image successfully!','data'=>$popupImage]);
        }else
        {
            return response()->json(['status'=>false,'message'=>'Popup image not found!']);
        }
    }


     // Forgot Password Change By Email OTP
    public function checkResetEmail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $email = $request->email;
            $parent = Parents::where('email', $email)->first();


            if (!$parent) {
                return response()->json(['status' => false, 'message' => 'User Not Found!']);
            }

            $token = Str::random(64);
            $otp = rand(1000, 9999);

            $parent->reset_token = $token;
            $parent->token_expires_at = now()->addMinutes(60);
            $parent->email_otp = $otp;
            $parent->save();

            $resetLink = url('/api/v1/reset-password-by-email?parent_id=' . $parent->id . '&token=' . $token);

            Mail::to($email)->send(new PasswordResetEmail([
                'name' => $parent->name,
                'email' => $parent->email,
                'link' => $resetLink,
                'otp' => $parent->email_otp,
            ]));

            return response()->json(['status' => true, 'message' => 'Password reset link & OTP sent!']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }
    }


    public function updateResetPasswordEmail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'parent_id'         => 'required|integer',
                'new_password'     => 'required|min:6',
                'confirm_password' => 'required|same:new_password',
                'token'            => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $parent = Parents::find($request->parent_id);
            if (!$parent) {
                return response()->json(['status' => false, 'message' => 'User not found']);
            }

            if (
                $parent->reset_token !== $request->token ||
                !$parent->token_expires_at ||
                now()->gt($parent->token_expires_at)
            ) {
                return response()->json(['status' => false, 'message' => 'Invalid or expired token']);
            }

            if ($parent->email_verified_at) {
                $parent->password = Hash::make($request->new_password);
                $parent->reset_token = null;
                $parent->token_expires_at = null;
                $parent->email_otp = null;
                $parent->email_verified_at = null;
                $parent->save();

                return response()->json(['status' => true, 'message' => 'Password changed successfully!']);
            }

            return response()->json(['status' => false, 'message' => 'Please verify your email first!']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => 'Something went wrong']);
        }
    }


    public function verifyResetOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'email_otp' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $parent = Parents::where('email', $request->email)->first();
            if (!$parent) {
                return response()->json(['status' => false, 'message' => 'User not found!']);
            }

            if ($parent->email_otp == $request->email_otp) {
                $parent->email_verified_at = now();
                $parent->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Email verified successfully!',
                    'data' => ['patent_id' => $parent->id, 'token' => $parent->reset_token]
                ]);
            }

            return response()->json(['status' => false, 'message' => 'Invalid OTP']);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['status' => false, 'error' => 'Internal Server Error'], 500);
        }
    }



    public function verifyResetLinkEmail(Request $request)
    {
        $request->validate([
            'parent_id' => 'required|integer',
            'token' => 'required|string',
        ]);

        $parent = Parents::find($request->parent_id);

        if ($parent && $parent->reset_token === $request->token) {
            if (now()->gt($parent->token_expires_at)) {
                return response()->json(['status' => false, 'message' => 'Link has expired']);
            }
            $parent->email_verified_at = now();
            $parent->update();


            // Redirect to frontend with token and tutor_id
            return redirect()->to("https://tuitionterminal.com.bd/auth/parent/reset-password?parent_id={$parent->id}&token={$request->token}");
        }

        return response()->json(['status' => false, 'message' => 'Invalid or expired link']);
    }

}