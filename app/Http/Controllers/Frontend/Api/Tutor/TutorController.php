<?php

namespace App\Http\Controllers\Frontend\Api\Tutor;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tutor\CreateEducationRequest;
use App\Http\Requests\Tutor\CreatePersonalRequest;
use App\Interfaces\JobOfferServiceInterface;
use App\Mail\VerifyEmailOtp;
use App\Mail\ActiveDeactiveMail;
use App\Models\Tutor;
use App\Models\PopupImageData;
use App\Models\VerificationRequest;
use Intervention\Image\Facades\Image;
use App\Models\PremiumMembership;
use App\Models\TutorStatusNote;
use App\Models\TutorEducation;
use App\Models\PremiumMesbership;
use App\Models\TutorLog;
use App\Models\TutorPersonalInfo;
use App\Models\TutorPreferedLocation;
use App\Models\TutorTypeUniversity;
use App\TutorModule\Tutor_Education_info;
use App\TutorModule\Tutoring_Info;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\TutorServiceInterface;
use App\Jobs\SendOtpSmsJob;
use App\Mail\PasswordResetEmail;
use App\Models\Institute;
use App\Models\JobApplication;
use App\Models\Parents;
use App\Models\User;
use App\Models\AffiliateRequest;
use App\Models\VideoTutoial;
use App\Models\JobOffer;
use App\Models\TutorCertificate;
use App\Services\AdnSmsService;
use App\Services\CloudflareR2Service;
use App\Traits\ApiResponse;
use App\Transformers\JobOfferResource;
use App\Transformers\TutorResource;
use App\TutorModule\Tutor_Crediantial;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryException;
use Dotenv\Exception\ValidationException;
use File;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\CorporatePartnerRequest;
use App\Models\SmsBalance;
use App\Models\UnverifiedTutor;
use App\Models\Counting;
use Illuminate\Support\Facades\DB;

class TutorController extends Controller
{
    const STATUS_KEY = 'status';
    const MESSAGE_KEY = 'message';

    private $tutorRepository;
    private $adnSmsService;
    use ApiResponse;
    private $jobOfferRepository;




    public function __construct(TutorServiceInterface $tutorRepository, AdnSmsService $adnSmsService,JobOfferServiceInterface $jobOfferRepository)
    {
        $this->tutorRepository = $tutorRepository;
        $this->adnSmsService = $adnSmsService;
        $this->jobOfferRepository = $jobOfferRepository;

    }

    public function sendCPRequest(Request $request)
    {
        $request = CorporatePartnerRequest::where('tutor_id',Auth::user()->id)->first();
        if($request)
        {
            return response()->json(['message' => 'Already Sended']);

        }else{
            $request = new CorporatePartnerRequest();
            $request->tutor_id = Auth::user()->id;
            $request->save();
            return response()->json([
                'message' => 'Request sent successfully',


                ]);

        }

    }
    public function getCPRequestStatus()
    {
        $request = CorporatePartnerRequest::where('tutor_id', Auth::id())->first();

        return response()->json([
            'status' => $request ? $request->status : null,
            'exists' => (bool) $request,
        ]);
    }

    public function latLongSave(Request $request)
    {
        $lat  = $request->lat;
        $long = $request->long;

        Tutor::where('id', Auth::id())->update([
            'lat'  => $lat,
            'long' => $long,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Location updated successfully'
        ]);
    }
     public function latLongGate(Request $request)
    {
        $tutor = Tutor::where('id', Auth::id())
            ->select('lat','long')
            ->first();

        return response()->json([
            'status' => true,
            'data' => $tutor
        ]);
    }

    public function getAffRequestStatus()
    {
        $request = AffiliateRequest::where('tutor_id',Auth::user()->id)->first();

        return response()->json([

            'status' => $request->request_status ?? '' ,
        ]);



    }
    public function platformStatus($unique_id)
    {
        $tutor = Tutor::where('unique_id',$unique_id)->first();

        $isShortlisted = true;
        $isconfirm = true;
        $isclosed = true;
        $applied     = JobApplication::where('tutor_id', $tutor->id)->count();
        $shortlisted = JobApplication::where('tutor_id', $tutor->id)
                        ->when($isShortlisted, function ($query) {
                            return $query->where('is_shortlisted', 1);
                        })->count();
        $appointed = JobApplication::where('tutor_id', $tutor->id)
                        ->when($isShortlisted, function ($query) {
                            return $query->whereNotNull('taken_at');
                        })->count();
        $confirm = JobApplication::where('tutor_id', $tutor->id)
                    ->when($isconfirm, function ($query) {
                        return $query->whereNotNull('confirm_date');
                    })->count();
        $cancel = JobApplication::where('tutor_id', $tutor->id)
                        ->where(function ($query) {
                            $query->whereNotNull('closed_date')
                                ->orWhereNotNull('repost_date');
                        })->count();

        return response()->json([
            'applied'     => $applied,
            'shortlisted' => $shortlisted,
            'appointed'   => $appointed,
            'confirm'     => $confirm,
            'cancel'      => $cancel,

        ]);


    }

    public function getTutorial()
    {
        try {
            $video = VideoTutoial::where('tutorial_type', 'tutor')->paginate(12);

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

        }
    }


    public function getProfilePicture($id)
    {
        $tutor = Tutor::where('unique_id', $id)->first();

        if (!$tutor || !$tutor->image) {
            return response()->json([
                'error' => 'Tutor or image not found'
            ], 404);
        }

        $imagePath = 'tutor-images/' . $tutor->image;

        if (!Storage::disk('r2')->exists($imagePath)) {
            return response()->json([
                'error' => 'Image file not found'
            ], 404);
        }

        // Get image from R2
        $imageContent = Storage::disk('r2')->get($imagePath);

        // Base64
        $base64Image = base64_encode($imageContent);

        // Create GD image from binary string
        $image = imagecreatefromstring($imageContent);

        if (!$image) {
            return response()->json([
                'error' => 'Unsupported image type'
            ], 400);
        }

        // Get top-left pixel color
        $rgb = imagecolorat($image, 5, 5);

        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;

        $hexColor = sprintf("#%02x%02x%02x", $r, $g, $b);

        imagedestroy($image);

        return response()->json([
            'image_url' => Storage::disk('r2')->url($imagePath),
            'base64Image' => $base64Image,
            'background_color' => $hexColor,
            'rgb' => [
                'r' => $r,
                'g' => $g,
                'b' => $b,
            ]
        ], 200, [], JSON_UNESCAPED_SLASHES);
    }

    public function preferedLocationJob(Request $request)
    {
        $tutor_id = Auth::user()->id;

        $tutor = Tutor::where('id',$tutor_id)->first();

        $prefered_locations = TutorPreferedLocation::where('tutor_id', $tutor_id)->pluck('location_id');

        $jobOffers = JobOffer::whereIn('location_id', $prefered_locations)
                                ->where('is_active', 1)
                                ->where(function($query) use ($tutor) {
                                    $query->where('tutor_gender', $tutor->gender)
                                        ->orWhere('tutor_gender', 'any');
                                })
                                ->get();


        return $this->resposeSuccess('data get successfully', [
            'jobOffers'      => JobOfferResource::collection($jobOffers),
        ]);
    }

    public function allCounting()
    {
        $registerTutor     = Tutor::count();
        $totalApplications = JobApplication::count();
        $liveTutionJob     = JobOffer::where('is_active',1)->count();
        $totalParents      = Parents::count();
        $totalUser         = User::count();

        return $this->resposeSuccess('data get successfully', [

            'registerTutor'      => $registerTutor,
            'totalApplications'  => $totalApplications,
            'liveTutionJob'      => $liveTutionJob,
            'stakeHolders'       => $registerTutor + $totalParents + $totalUser,

        ]);

    }


    // public function updateOtherTable()
    // {
    //     $response = Http::get('https://production.tuitionterminal.com.bd/api/get-personal-infos');

    //     if ($response->successful()) {
    //         $data = $response->json();

    //         foreach ($data as $entry) {
    //             $tutor = TutorPersonalInfo::updateOrCreate(
    //                 ['tutor_id' => $entry['tutor_id']],
    //                 [
    //                     'city_id' => $entry['city_id'],
    //                     'location_id' => $entry['location_id'],
    //                     'additional_phone' => $entry['additional_phone'],
    //                     'full_address' => $entry['full_address'],
    //                     'permanent_full_address' => $entry['permanent_full_address'],
    //                     'nid_number' => $entry['id_number'],
    //                     'nationality' => $entry['nationality'],
    //                     'facebook_profile' => $entry['facebook_profile'],
    //                     'blood_group' => $entry['blood_group'],
    //                     'date_of_birth' => $entry['date_of_birth'],
    //                     'fathers_name' => $entry['fathers_name'],
    //                     'mothers_name' => $entry['mothers_name'],
    //                     'fathers_phone' => $entry['fathers_phone'],
    //                     'mothers_phone' => $entry['mothers_phone'],
    //                     'emergency_name' => $entry['emergency_name'],
    //                     'emergency_phone' => $entry['emergency_phone'],
    //                     'short_description' => $entry['short_description'],
    //                     'reason_hired' => $entry['reasones_to_get_hired'],
    //                 ]
    //             );
    //         }

    //         return response()->json(['message' => 'Data updated successfully']);
    //     } else {
    //         Log::error('Failed to retrieve personal info from API: ' . $response->status());
    //         return response()->json(['error' => 'Failed to retrieve personal info from API'], 500);
    //     }
    // }

    public function updateOtherTable()
    {
        $response = Http::get('https://production.tuitionterminal.com.bd/api/get-personal-infos');

        if ($response->successful()) {
            $data = $response->json();

            foreach ($data as $entry) {
                $entry = array_map(function($value) {
                    return $value === 'NULL' ? null : $value;
                }, $entry);

                Log::info('Entry Data: ' . json_encode($entry));

                $tutor = TutorPersonalInfo::updateOrCreate(
                    ['tutor_id' => $entry['tutor_id']],
                    [
                        'city_id' => $entry['city_id'] ?? null,
                        'location_id' => $entry['location_id'] ?? null,
                        'additional_phone' => $entry['additional_phone'] ?? null,
                        'full_address' => $entry['full_address'] ?? null,
                        'permanent_full_address' => $entry['permanent_full_address'] ?? null,
                        'nid_number' => $entry['id_number'] ?? null,
                        'nationality' => $entry['nationality'] ?? null,
                        'facebook_profile' => $entry['facebook_profile'] ?? null,
                        'blood_group' => $entry['blood_group'] ?? null,
                        'date_of_birth' => $entry['date_of_birth'] ?? null,
                        'fathers_name' => $entry['fathers_name'] ?? null,
                        'mothers_name' => $entry['mothers_name'] ?? null,
                        'fathers_phone' => $entry['fathers_phone'] ?? null,
                        'mothers_phone' => $entry['mothers_phone'] ?? null,
                        'emergency_name' => $entry['emergency_name'] ?? null,
                        'emergency_phone' => $entry['emergency_phone'] ?? null,
                        'short_description' => $entry['short_description'] ?? null,
                        'reason_hired' => $entry['reason_hired'] ?? null,

                    ]
                );
            }

            return response()->json(['message' => 'Data updated successfully']);
        } else {
            return response()->json(['error' => 'Failed to retrieve personal info from API'], 500);
        }
    }



    private function sendOtpToUser($phoneNumber, $message, $tutorId)
    {
        try {
            $result = $this->adnSmsService->sendOtp($phoneNumber, $message);

            if (is_array($result) && array_key_exists('status', $result))
            {
                if ($result['status']) {
                } else {
                }
            } else {
            }
        } catch (\Exception $e) {
        }
    }




    public function getSscInstitute()
    {

        try{

            $institute = Institute::orderBy('title','asc')->where('type' ,'school')
            ->orWhere('type' ,'school and college')
            ->get();
            if (count($institute) > 0)
            {
                return response()->json(['status'=>true,'message'=>'Ssc Institute get Successfully!','data'=>$institute]);
            }else
            {
                return response()->json(['status'=>false,'message'=>'Institute Not Found!']);
            }

        }catch(Exception $e)
        {

        }

    }



    public function getHscInstitute()
    {

        try{

            $institute = Institute::orderBy('title','asc')->where('type' ,'college')
            ->orWhere('type' ,'school and college')
            ->get();
            if (count($institute) > 0)
            {
                return response()->json(['status'=>true,'message'=>'Hsc Institute get Successfully!','data'=>$institute]);
            }else
            {
                return response()->json(['status'=>false,'message'=>'Institute Not Found!']);
            }

        }catch(Exception $e)
        {

        }

    }



    public function getUniversityInstitute()
    {

        try{

            $institute = Institute::orderBy('title','asc')->where('type' ,'university')
            ->orWhere('type' ,'college')
            ->get();
            if (count($institute) > 0)
            {
                return response()->json(['status'=>true,'message'=>'University Institute get Successfully!','data'=>$institute]);
            }else
            {
                return response()->json(['status'=>false,'message'=>'Institute Not Found!']);
            }

        }catch(Exception $e)
        {

        }

    }




    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $validator = Validator()->make($request->all(), [
                'country_id'           => 'nullable',
                'city_id'              => 'nullable',
                'location_id'          => 'nullable',
                'preferred_location'   => 'nullable',
            ]);
            $id = $request->tutor_id;

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $tutorInfo = new Tutoring_Info();

            if ($request->country_id) {
                TutorPersonalInfo::updateOrCreate(
                    ['tutor_id' => $id],
                    [
                        'country_id'   => $request->country_id,
                        'city_id'      => $request->city_id,
                        'location_id'  => $request->location_id,
                    ]
                );
            }
            $tutorInfo->tutor_information($request,$request->tutor_id);

            $tutor = Tutor::updateOrCreate(['id' => $request->tutor_id], [

            ]);

            if ($request->has('preferred_location')) {
                $tutor->tutor_prefered_locations()->sync($request->preferred_location, true);
            }
            $tutor_education_info = new Tutor_Education_info();
            $tutor_education_info->updateHONS($request);




            if ($request->institute) {
                TutorTypeUniversity::updateOrCreate(
                    ['tutor_id' => $id],
                    [
                        'university'      => $request->institute,
                        'degree_name'     => 'honours',
                        'department_id'   => $request->department,
                    ]
                );
            } elseif ($request->institute_name) {
                TutorEducation::updateOrCreate(
                    ['tutor_id' => $id],
                    [
                        'institute_id'   => $request->institute_name,
                        'degree_name'    => 'honours',
                        'department_id'  => $request->department,
                    ]
                );
            }

            $tutor_profile_message = Tutor::find($id);
            $complete = $tutor_profile_message->getProfileComplete();

            return response()->json(['message' => 'Basic Information fill-up successfully. Now your profile is ' . $complete . ' % done.']);

        } catch (Exception $e) {

        }
    }
    public function showTutor($id)
    {
        try{


            $get_tutor =new TutorResource( $this->tutorRepository->showTutor($id)->first());



            if ($get_tutor != null)
            {
                return response()->json(['status'=>true,'message' => 'Get Tutor Successfully!', 'tutor' =>$get_tutor]);
            }else
            {
                return response()->json(['status'=>false,'message' => 'Tutor Not found!']);
            }

        }catch(Exception $e)
        {

        }
    }

    public function tutorInfoSave(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "tutoring_category"          => "nullable",
                "tutoring_class_course"      => "nullable",
                "favourite_subject"          => "nullable",
                "tutoring_experience"        => "nullable",
                "available_day"              => "nullable",
                "preferred_teaching_method"  => "nullable",
                "expected_salary"            => "nullable",
                "available_from"             => "nullable",
                "available_to"               => "nullable",
                "country_id"                 => "nullable",
            ]);

            if ($validator->fails()) {
                return response()->json([self::STATUS_KEY => false, 'error' => $validator->errors()]);
            }
            $tutorInfo = new Tutoring_Info();
            $tutorInfo->tutor_information($request,$request->tutor_id);

            $tutor = Tutor::updateOrCreate(['id' => $request->tutor_id], [

            ]);

            if ($request->has('preferred_location')) {
                $tutor->tutor_prefered_locations()->sync($request->preferred_location, true);
            }

            if ($request->has('available_day')) {
                $tutor->tutor_days()->sync($request->available_day, true);
            }

            if ($request->has('preferred_teaching_method')) {
                $tutor->teaching_method()->sync($request->preferred_teaching_method, true);
            }

            if ($request->has('tutoring_category')) {
                $tutor->tutor_categories()->sync($request->tutoring_category, true);
            }

            if ($request->has('tutoring_class_course')) {
                $tutor->tutor_course()->sync($request->tutoring_class_course, true);
            }

            if ($request->has('favourite_subject')) {
                $tutor->course_subjects()->sync($request->favourite_subject, true);
            }

            $complete = $tutor->getProfileComplete();
            $message = 'Tutoring information saved successfully. Now your profile is ' . $complete . ' % done.';

            // dd($request->all());
            return response()->json([self::STATUS_KEY => true, self::MESSAGE_KEY => $message]);

        } catch (ValidationException $e) {
        } catch (QueryException $e) {
        }
    }
    public function educationInfoSave(CreateEducationRequest $request)
    {
        try{

            $tutor_education_info = new Tutor_Education_info();
            $tutor_education_info->updateSSC($request);
            $tutor_education_info->updateHSC($request);
            $tutor_education_info->updateHONS($request);
            $tutor_education_info->updateMasters($request);

            $tutor_profile_message = Tutor::find($request->tutor_id);
            $complete = $tutor_profile_message->getProfileComplete();

            return response()->json(['status'=>'success','message'=>'Tutor educational information has been saved successfully.Now your profile is ' . $complete .' % completed.']);

        }catch(Exception $e)
        {
        }


    }

    public function personalInfoSave(CreatePersonalRequest $request)
    {
        try{

            if ($request->tutor_id)
            {
                $tutor_id = $request->tutor_id;
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
                $tutor_update->emergency_name = $request->emargency_contact_name;
                $tutor_update->emergency_phone = $request->emargency_contact_phone;
                $tutor_update->facebook_link = $request->facebook_link;
                $tutor_update->linekdin_link = $request->linkedin_link;
                $tutor_update->twitter_link = $request->twitter_link;
                $tutor_update->instagram_link = $request->instagram_link;
                $tutor_update->about_yourself = $request->about_yourself;
                $tutor_update->reason_hired = $request->reason_hired;
                $tutor_update->tutoring_experience_details = $request->tutoring_experience_details;
                $tutor_update->personal_opinion = $request->personal_opinion;
                $tutor_update->additional_phone = $request->additional_phone;
                $tutor_update->save();

                $tutor_profile_message = Tutor::find($tutor_id);
                $tutor_profile_message->gender = $request->gender;
                // $tutor_profile_message->name = $request->name;
                $tutor_profile_message->save();
                $complete = $tutor_profile_message->getProfileComplete();

                $tutor_logs = new TutorLog();
                $tutor_logs->tutor_id          = $tutor_id;
                $tutor_logs->father_name       = $request->father_name;
                $tutor_logs->father_phone      = $request->father_phone;
                $tutor_logs->mother_name       = $request->mother_name;
                $tutor_logs->mother_phone      = $request->mother_phone;
                $tutor_logs->emargency_name    = $request->emargency_contact_name;
                $tutor_logs->emargency_phone   = $request->emargency_contact_phone;
                $tutor_logs->facebook_link     = $request->facebook_link;
                $tutor_logs->linkedin_link     = $request->linkedin_link;
                $tutor_logs->twitter_link      = $request->twitter_link;
                $tutor_logs->instagram_link    = $request->instagram_link;
                $tutor_logs->nid_number        = $request->instagram_link;
                $tutor_logs->nid_number        = $request->nid;
                $tutor_logs->edited_user       = Auth::user()->id;
                $tutor_logs->permanent_full_address = $request->permanent_address;

                $tutor_logs->date_of_birth     = $request->date_of_birth;
                $tutor_logs->save();


               return  response()->json(['status'=>true,'message'=>'Tutor personal info has been saved succssfully.Now your profile is ' . $complete .' % done.']);

            }else
            {
                return response()->json(['status'=> false,'message'=> 'Tutor ID not found']);
            }

        }catch(Exception $e)
        {
        }


    }

    public function updateName(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $tutor_id = $request->tutor_id;

            try {
                $update_name = Tutor::findOrFail($tutor_id);
                $update_name->name = $request->name;

                if (!$update_name->save()) {
                    return response()->json(['status' => false, 'message' => 'Failed to update name']);
                }

                $tutor_log = new TutorLog();
                $tutor_log->tutor_id     = $tutor_id;
                $tutor_log->name         = $request->name;
                $tutor_log->edited_user  = Auth::user()->id;
                $tutor_log->save();

                return response()->json(['status' => true, 'message' => 'Name updated successfully']);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response()->json(['status' => false, 'message' => 'Tutor not found']);
            }
        } catch (Exception $e) {

        }
    }

// লগইন এর পরে ফোন নাম্বার অপডেট
    public function updatePhone(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone'     => 'required|regex:/(01)[0-9]{9}/|unique:tutors',
                'tutor_id'  => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $update_phone = Tutor::find($request->tutor_id);

            if ($update_phone) {
                if ($update_phone->phone != $request->phone) {


                    $phone_otp = rand(1234, 9999);
                    $otpExpiry = now()->addMinutes(5);
                    $update_phone->otp = $phone_otp;
                    $update_phone->otp_expiry = $otpExpiry;
                    $this->sendOtpToUser($request->phone, 'Your OTP is: ' . $phone_otp, $update_phone->id);

                    $update_phone->save();


                    return response()->json(['status' => true, 'message' => 'OTP sent successfully!']);

                } else {
                    return response()->json(['status' => false, 'message' => 'The number is already verified.']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Tutor ID not found!']);
            }
        } catch (Exception $e) {

        }
    }

    public function verifyPhoneOtpAndUpdate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'otp'        => 'required|numeric',
                'tutor_id'   => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $check_Otp = Tutor::find($request->tutor_id);

            if ($check_Otp->otp && Carbon::now()->lt($check_Otp->otp_expiry)) {
                if ($check_Otp->otp == $request->otp) {
                    if ($request->has('phone')) {
                        // if ($check_Otp->phone_varified_at) {
                        //     return response()->json(['status' => false, 'error' => 'Phone number is already verified!', 'phone_varified_at' => $check_Otp->phone_varified_at]);
                        // }

                        $check_Otp->phone_varified_at = now();
                        $check_Otp->phone = $request->phone;
                        $check_Otp->save();

                        $tutor_logs = new TutorLog();
                        $tutor_logs->tutor_id     = $request->tutor_id;
                        $tutor_logs->phone        = $request->phone;
                        $tutor_logs->edited_user  = Auth::user()->id;

                        $tutor_logs->save();

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

        }
    }


    public function resendOtpVeryficationCode(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tutor_id'   => 'required',
                'phone'      => 'required|regex:/(01)[0-9]{9}/',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $tutor = Tutor::find($request->tutor_id);

            if ($tutor) {
                // if ($tutor->phone_varified_at) {
                //     return response()->json(['status' => false, 'error' => 'Phone number is already verified!', 'phone_varified_at' => $tutor->phone_varified_at]);
                // }

                if ($tutor->otp && Carbon::now()->gte($tutor->otp_expiry)) {
                    $phone_otp = rand(1234, 9999);
                    $otpExpiry = now()->addMinutes(5);
                    $tutor->otp = $phone_otp;
                    $this->sendOtpToUser($request->phone, 'Your OTP is: ' . $phone_otp, $tutor->id);
                    $tutor->otp_expiry = $otpExpiry;
                    $tutor->save();

                    return response()->json(['status' => true, 'message' => 'New OTP sent successfully!', 'otp' => $phone_otp]);
                } else {
                    return response()->json(['status' => false, 'error' => 'Resending OTP is not allowed at this time.']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Tutor ID not found!']);
            }
        } catch (Exception $e) {

        }
    }




 // Update Email
    public function updateEmail(Request $request)
    {

        try{

            $validator = Validator::make($request->all(),[
                'email' => 'required|email|unique:tutors'
            ]);
            if ($validator->fails())
            {
                return  response()->json(['status'=>false,'error' =>$validator->errors()]);
            }


            $tutor_id     = $request->tutor_id;
            $tutor        = Tutor::where('id',$tutor_id)->first();
            $email        = $request->email;

            if($tutor->email == $email){
                return response()->json(['status' => false, 'message' => 'Please Enter a Defferent Email!']);

            }else{
                $email_otp = rand(1234,9999);
                $tutor->email_otp = $email_otp;
                $tutor->update();

                $tutor_logs = new TutorLog();
                $tutor_logs->email        = $request->email;
                $tutor_logs->tutor_id     = Auth::user()->id;
                $tutor_logs->edited_user  = Auth::user()->id;

                $tutor_logs->save();
                // return response()->json(['status' => true, 'message' => 'Email updated successfull!']);



                    Mail::to($request->email)->send( new VerifyEmailOtp([
                        'name'=> $tutor->name,
                        'otp'=> $email_otp,
                        'email'=> $email,
                    ]));
                    return response()->json(['status' => true, 'message' => 'Email Send Successfull!']);




            }

        }catch(Exception $e)
        {

        }

    }

    public function verifyEmailOtp(Request $request)
    {
        try{
            // dd($request->all());


            $validator = Validator::make($request->all(), [
                'tutor_id'           => 'required',
                'email'              => 'required|unique:users',
                'email_otp'          => 'required',

            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }
            $tutor_id  =  $request->tutor_id;
            $email     =  $request->email;
            $tutor     = Tutor::where('id',$tutor_id)->first();
            if ($tutor->email_otp == $request->email_otp)
            {
                $tutor->email_varified_at =now();
                $tutor->email =$email;
                $tutor->update();
               return response()->json(['status'=>true,'message'=> 'Email verified successfully.']);
            }else
            {
                return response()->json(['status'=>false,'message'=> 'your otp is invalid .']);
            }

        }catch(Exception $e)
        {

        }

    }


    public function changePassword(Request $request)
    {

        try{

            $validator = Validator::make($request->all(),[
                'current_password' => 'required',
                'new_password' => 'required|min:6',
                'confirm_password' => 'required|same:new_password',
            ]);

            if ($validator->fails())
            {
                return response()->json(['status'=>false,'error' => $validator->errors()]);
            }
            $current_user = Tutor::find($request->tutor_id);
            if(Hash::check($request->current_password,$current_user->password))
            {
                $current_user->password = Hash::make($request->new_password);
                $current_user->save();
                return response()->json(['status'=>true,'message' => 'Password change successfully! ']);
            }else
            {
                return response()->json(['status'=>false,'message' => 'Current passsword did not match!']);
            }


        }catch(Exception $e)
        {

        }



    }

    public function activeDeactiveAccount(Request $request)
    {
        try {
            $tutor = Tutor::find(auth::user()->id);

            if ($request->deactivate) {
                if ($tutor->is_active == 1) {
                    $tutor->is_active = 0;
                    $tutor->is_sms = 0;
                    $tutor->deactivate_by_tutor = $tutor->id;
                    $tutor->inactive_date = now();
                    $tutor->update();

                    $tutorStstusNote = new TutorStatusNote();
                    $tutorStstusNote->status = '0';
                    $tutorStstusNote->changed_by = 'By Tutor Own';
                    $tutorStstusNote->changed_note = 'Deactivate By Own';
                    $tutorStstusNote->tutor_id = $tutor->id;
                    $tutorStstusNote->save();

                    return response()->json(['status' => true, 'message' => 'Your account deactivated successfully.']);
                } else {
                    return response()->json(['status' => true, 'message' => 'Your account is already deactivated.']);
                }
            }

            if ($request->activate) {
                if ($tutor->deactivate_by_admin != null) {
                    return response()->json(['status' => false, 'message' => 'To unlock your profile, please contact the administrator.']);
                } else {
                    if ($tutor->is_active == 0) {
                        $tutor->is_active = 1;
                        $tutor->is_sms = 1;
                        $tutor->update();

                        $tutorStstusNote = new TutorStatusNote();
                        $tutorStstusNote->status = 1;
                        $tutorStstusNote->changed_by = 'By Tutor Own';
                        $tutorStstusNote->changed_note = 'Activate By own';
                        $tutorStstusNote->tutor_id = $tutor->id;
                        $tutorStstusNote->save();
                        return response()->json(['status' => true, 'message' => 'Your account activated successfully.']);
                    } else {
                        return response()->json(['status' => true, 'message' => 'Your account is already activate.']);
                    }
                }
            }
        } catch (Exception $e) {

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

        }



    }

    // public function credentialStore(Request $request)
    // {
    //     try {
    //         $validator = Validator::make($request->all(), [
    //             'tutor_id' => 'required',
    //             'ssc_c'              => 'mimes:jpg,jpeg,png,bmp|max:200',
    //             'ssc_m'              => 'mimes:jpg,jpeg,png,bmp|max:200',
    //             'hsc_c'              => 'mimes:jpg,jpeg,png,bmp|max:200',
    //             'hsc_m'              => 'mimes:jpg,jpeg,png,bmp|max:200',
    //             'nid'                => 'mimes:jpg,jpeg,png,bmp|max:200',
    //             'university_c'       => 'mimes:jpg,jpeg,png,bmp|max:200',
    //             'diploma_c'          => 'mimes:jpg,jpeg,png,bmp|max:200',
    //             'post_graduation_c'  => 'mimes:jpg,jpeg,png,bmp|max:200',
    //             'cv'                 => 'mimes:jpg,jpeg,png,bmp|max:200',
    //             'others'             => 'mimes:jpg,jpeg,png|max:200',
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json(['status' => false, 'error' => $validator->errors()]);
    //         }

    //         // dd($request->all());
    //         $tutor_id = $request->input('tutor_id');

    //         $filePaths = [];

    //         $fields = ['ssc_c', 'ssc_m', 'hsc_c', 'hsc_m', 'nid', 'university_c', 'diploma_c', 'post_graduation_c', 'cv', 'others'];
    //         foreach ($fields as $field) {
    //             if ($request->hasFile($field)) {
    //                 $file = $request->file($field);
    //                 $fileName = $tutor_id .rand(1234,9999). time() . '.' . $file->getClientOriginalExtension();
    //                 $file->storeAs('public/tutor-certificate', $fileName);
    //                 $filePaths[$field] = $fileName;

    //                 $logImage = new TutorLog();
    //                 $logImage->tutor_id    = $tutor_id;
    //                 $logImage->{$field}    = $fileName;
    //                 $logImage->edited_user = $tutor_id;
    //                 $logImage->save();

    //                 $file->storeAs('public/log-certificate-images', $fileName);
    //                 }
    //         }

    //         $data = array_merge(['tutor_id' => $tutor_id], $filePaths);

    //         TutorCertificate::updateOrCreate(['tutor_id' => $tutor_id], $data);
    //         $tutor_update = TutorPersonalInfo::where('tutor_id',$tutor_id)->first();
    //         $tutor_update->pic = 1;
    //         $tutor_update->update();


    //         return response()->json(['message' => 'Files uploaded successfully']);
    //     } catch (ModelNotFoundException $e) {
    //         return response()->json(['error' => 'Model not found']);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()]);
    //     }
    // }

    // public function credentialGet()
    // {
    //     try {
    //         $tutor_id = auth()->user()->id;
    //         $credentials = TutorCertificate::where('tutor_id', $tutor_id)->first();

    //         if ($credentials) {
    //             return response()->json(['credentials' => $credentials]);
    //         } else {
    //             return response()->json(['error' => 'Credentials not found'], 404);
    //         }
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    public function credentialStore(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tutor_id' => 'required',
                'ssc_c'              => 'mimes:jpg,jpeg,png,bmp|max:200',
                'ssc_m'              => 'mimes:jpg,jpeg,png,bmp|max:200',
                'hsc_c'              => 'mimes:jpg,jpeg,png,bmp|max:200',
                'hsc_m'              => 'mimes:jpg,jpeg,png,bmp|max:200',
                'nid'                => 'mimes:jpg,jpeg,png,bmp|max:200',
                'university_c'       => 'mimes:jpg,jpeg,png,bmp|max:200',
                'diploma_c'          => 'mimes:jpg,jpeg,png,bmp|max:200',
                'post_graduation_c'  => 'mimes:jpg,jpeg,png,bmp|max:200',
                'cv'                 => 'mimes:jpg,jpeg,png,bmp|max:200',
                'others'             => 'mimes:jpg,jpeg,png|max:200',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            // dd($request->all());
            $tutor_id = $request->input('tutor_id');
            // dd($tutor_id);

            $filePaths = [];

            $r2 = new \App\Services\CloudflareR2Service();

            $fields = [
                'ssc_c',
                'ssc_m',
                'hsc_c',
                'hsc_m',
                'nid',
                'university_c',
                'diploma_c',
                'post_graduation_c',
                'cv',
                'others'
            ];

            $fields = ['ssc_c', 'ssc_m', 'hsc_c', 'hsc_m', 'nid', 'university_c', 'diploma_c', 'post_graduation_c', 'cv', 'others'];

            foreach ($fields as $field) {

                if ($request->hasFile($field)) {
                    // dd($fields);

                    $file = $request->file($field);

                    $fileName = $tutor_id . rand(1234,9999) . time() . '.' . $file->getClientOriginalExtension();

                    // Upload to R2
                    $r2->upload($file, 'tutor-certificate/'.$fileName);

                    // DB তে শুধু filename save হবে
                    $filePaths[$field] = $fileName;

                    // dd($filePaths);

                    $logImage = new TutorLog();
                    $logImage->tutor_id    = $tutor_id;
                    $logImage->{$field}    = $fileName;
                    $logImage->edited_user = $tutor_id;
                    $logImage->save();

                    // Log Folder
                    $r2->upload($file, 'log-certificate-images/'.$fileName);
                }
            }

            $data = array_merge(['tutor_id' => $tutor_id], $filePaths);

            TutorCertificate::updateOrCreate(['tutor_id' => $tutor_id], $data);
            $tutor_update = TutorPersonalInfo::where('tutor_id',$tutor_id)->first();
            $tutor_update->pic = 1;
            $tutor_update->update();


            return response()->json(['message' => 'Files uploaded successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Model not found']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function credentialGet()
    {
        try {

            $tutor_id = auth()->user()->id;

            $credentials = TutorCertificate::where('tutor_id', $tutor_id)->first();

            if (!$credentials) {
                return response()->json([
                    'error' => 'Credentials not found'
                ], 404);
            }

            $fields = [
                'ssc_c',
                'ssc_m',
                'hsc_c',
                'hsc_m',
                'nid',
                'university_c',
                'diploma_c',
                'post_graduation_c',
                'cv',
                'others'
            ];

            foreach ($fields as $field) {

                if (!empty($credentials->$field)) {

                    $credentials->$field = url('storage/tutor-certificate/' . $credentials->$field);

                }

            }

            return response()->json([
                'credentials' => $credentials
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 500);

        }
    }
    public function viewf($file)
    {
        try {

            $r2 = new CloudflareR2Service();

            $object = $r2->getObject('tutor-certificate/'.$file);

            return response(
                $object['Body']->getContents(),
                200,
                [
                    'Content-Type'   => $object['ContentType'],
                    'Content-Length' => $object['ContentLength'],
                    'Cache-Control'  => 'public, max-age=31536000',
                ]
            );

        } catch (\Exception $e) {
            abort(404);
        }
    }
    public function getTutor($tutorId)
    {
        try {
             $tutoring = [];
            $tutor = Tutor::find($tutorId);
            $tutor_category  = $tutor->tutor_categories;
            $tutor_course = $tutor->tutor_courses;
            $tutor_course_subject = $tutor->course_subjects;
            foreach($tutor_category as $ca){
                $tutoring['category'][] = $ca->name;
            }
            foreach($tutor_course as $co){
                $tutoring['course'][] = $co->name;
            }
            foreach($tutor_course_subject as $cs){
                $tutoring['subject'][] = $cs->subject->title;
            }
            return response()->json([
            'tutoring_data' =>$tutoring,
            ] );
            // // Retrieve the tutor along with related categories, courses, and subjects
            // $tutor = Tutor::with(['tutor_geTcategories', 'tutor_geTcourses', 'tutor_geTsubjects'])
            //     ->findOrFail($tutorId);

            // // Extracting the relevant information and excluding created_at and updated_at
            // $extractedData = [
            //     'id' => $tutor->id,
            //     'tutor_ge_tcategories' => $this->extractTutorCategories($tutor),
            //     'tutor_ge_tcourses' => $this->extractTutorCourses($tutor),
            //     'tutor_ge_tsubjects.course_id' => $this->extractTutorSubjects($tutor),
            // ];

            // // Return the extracted data as a JSON response
            // return response()->json(['tutor' => $extractedData], 200);
        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    protected function extractTutorCategories($tutor)
    {
        return $tutor->tutor_geTcategories->map(function ($category) {
            unset($category['created_at'], $category['updated_at'], $category['pivot']);
            return $category;
        })->toArray();
    }

    protected function extractTutorCourses($tutor)
    {
        return $tutor->tutor_geTcourses->map(function ($course) {
            unset($course['created_at'], $course['updated_at'], $course['pivot']);
            return $course;
        })->toArray();
    }

    protected function extractTutorSubjects($tutor)
    {
        return $tutor->tutor_geTsubjects->map(function ($subject) {
            unset($subject['created_at'],$subject['id'], $subject['updated_at']);
            return $subject;
        })->toArray();
    }

// Forgot Password Change By Phone OTP

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

            $tutorPasswordReset = Tutor::where('phone', $phone)->first();

            if ($tutorPasswordReset === null) {
                return response()->json(['status' => false, 'message' => 'User Not Found!']);
            } elseif ($tutorPasswordReset->phone !== $phone) {
                return response()->json(['status' => false, 'message' => 'Invalid phone number for the user!']);
            } else {
                $otpRequestLimit = 1;
                $otpRequestTimeFrame = 120;

                $cacheKey = 'otp_request_count_' . $tutorPasswordReset->phone;
                $otpRequestCount = Cache::get($cacheKey, 0);

                if ($otpRequestCount >= $otpRequestLimit) {
                    return response()->json(['status' => false, 'message' => 'You can only request one OTP every 2 minutes. Please try again later.']);
                }

                Cache::put($cacheKey, $otpRequestCount + 1, now()->addSeconds($otpRequestTimeFrame));

                $otpResendLimit = 3;
                $otpResendTimeFrame = 24 * 60;

                if ($tutorPasswordReset->otp_resend_count >= $otpResendLimit && Carbon::now()->diffInMinutes($tutorPasswordReset->last_otp_resend) < $otpResendTimeFrame) {
                    return $this->resposeError('You have reached the maximum OTP resend limit for today. Please try again after 24 hours. Or contact TuitionHome Admin over the phone', '');
                }

                $phone_otp = rand(1234, 9999);
                $otpExpiry = now()->addMinutes(10);
                $tutorPasswordReset->otp = $phone_otp;
                $tutorPasswordReset->otp_expiry = $otpExpiry;

                $this->sendOtpToUser($request->phone, 'Your password recovery OTP for "TuitionHome" is: ' . $phone_otp, $tutorPasswordReset->id);

                // Update OTP resend count and timestamp
                $tutorPasswordReset->otp_resend_count += 1;
                $tutorPasswordReset->last_otp_resend = now();
                $tutorPasswordReset->save();

                return response()->json(['status' => true, 'message' => 'OTP sent successfully!', 'phone' => $tutorPasswordReset->phone]);
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
                'tutor_id'           => 'required',
                'new_password'       => 'required|min:6',
                'confirm_password'   => 'required|same:new_password',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $current_user = Tutor::find($request->tutor_id);

            if ($current_user) {
                if ($current_user->otp_expiry > $current_user->phone_varified_at ){
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
                'phone' => 'required|exists:tutors,phone',
                'phone_otp'   => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $tutor = Tutor::where('phone',$request->phone)->first();
            if ($tutor) {
                if ($tutor->otp && Carbon::now()->lt($tutor->otp_expiry)) {
                    if ($tutor->otp == $request->phone_otp) {
                        $tutor->phone_varified_at = now();
                        $tutor->save();

                        $data = [
                            'tutor_id' => $tutor->id,
                            'tutor_phone' => $tutor->phone,
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
            $tutor_info = [
                'tutor_id' => $tutor->id,
                'tutor_phone' => $tutor->phone,
            ];
            return $this->resposeSuccess('Update your password now', $tutor_info);


        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['status' => false, 'error' => 'Internal Server Error'], 500);
        }

    }

    // Forgot Password Change By Email OTP
    public function checkEmail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $email = $request->email;
            $tutor = Tutor::where('email', $email)->first();

            if (!$tutor) {
                return response()->json(['status' => false, 'message' => 'User Not Found!']);
            }

            $token = Str::random(64);
            $otp = rand(1000, 9999);

            $tutor->reset_token = $token;
            $tutor->token_expires_at = now()->addMinutes(60);
            $tutor->email_otp = $otp;
            $tutor->email_varified_at = null;
            $tutor->save();

            $resetLink = url('/api/v1/reset-password?tutor_id=' . $tutor->id . '&token=' . $token);

            Mail::to($email)->send(new PasswordResetEmail([
                'name' => $tutor->name,
                'email' => $tutor->email,
                'link' => $resetLink,
                'otp' => $tutor->email_otp,
            ]));

            return response()->json(['status' => true, 'message' => 'Password reset link & OTP sent!']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }
    }


    public function updatePasswordEmail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tutor_id'         => 'required|integer',
                'new_password'     => 'required|min:6',
                'confirm_password' => 'required|same:new_password',
                'token'            => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $tutor = Tutor::find($request->tutor_id);
            if (!$tutor) {
                return response()->json(['status' => false, 'message' => 'User not found']);
            }

            if (
                $tutor->reset_token !== $request->token ||
                !$tutor->token_expires_at ||
                now()->gt($tutor->token_expires_at)
            ) {
                return response()->json(['status' => false, 'message' => 'Invalid or expired token']);
            }

            if ($tutor->email_varified_at) {
                $tutor->password = Hash::make($request->new_password);
                $tutor->reset_token = null;
                $tutor->token_expires_at = null;
                $tutor->email_otp = null;
                $tutor->email_varified_at = null;
                $tutor->save();

                return response()->json(['status' => true, 'message' => 'Password changed successfully!']);
            }

            return response()->json(['status' => false, 'message' => 'Please verify your email first!']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => 'Something went wrong']);
        }
    }


    public function verifyOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'email_otp' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $tutor = Tutor::where('email', $request->email)->first();
            if (!$tutor) {
                return response()->json(['status' => false, 'message' => 'User not found!']);
            }

            if ($tutor->email_otp == $request->email_otp) {
                $tutor->email_varified_at = now();
                $tutor->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Email verified successfully!',
                    'data' => ['tutor_id' => $tutor->id, 'token' => $tutor->reset_token]
                ]);
            }

            return response()->json(['status' => false, 'message' => 'Invalid OTP']);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['status' => false, 'error' => 'Internal Server Error'], 500);
        }
    }



    public function verifyResetLink(Request $request)
    {
        $request->validate([
            'tutor_id' => 'required|integer',
            'token' => 'required|string',
        ]);

        $tutor = Tutor::find($request->tutor_id);

        if ($tutor && $tutor->reset_token === $request->token) {
            if (now()->gt($tutor->token_expires_at)) {
                return response()->json(['status' => false, 'message' => 'Link has expired']);
            }
            $tutor->email_varified_at = now();
            $tutor->update();


            // Redirect to frontend with token and tutor_id
            return redirect()->to("https://tuition-terminal-dev.vercel.app/auth/tutor/reset-password?tutor_id={$tutor->id}&token={$request->token}");
        }

        return response()->json(['status' => false, 'message' => 'Invalid or expired link']);
    }


    // Profile Copletion
    public function profileCompletion(Request $request)
    {
        $tutor = auth()->user();
        // dd($tutor);

        if ($tutor) {
            $completed = $tutor->getProfileComplete();

            return response()->json(['profile_completed' => $completed]);
        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }


    // Email Verify
    public function emailVerify(Request $request)
    {
        try{



            $validator = Validator::make($request->all(), [
                'tutor_id'           => 'required',
                'email'              => 'required',

            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }
            $tutor_id     = $request->tutor_id;
            $email        = $request->email;
            $tutor        = Tutor::where('id',$tutor_id)->first();

            // dd($tutor->email , $email);

            if($tutor->email != $email){
                return response()->json(['status' => false, 'message' => 'Email not found!']);

            }else{
                $email_otp = rand(1234,9999);
                $tutor->email_otp = $email_otp;
                $tutor->email_varified_at = null;
                $tutor->save();
                if ( $tutor->email_varified_at == null)
                {
                    Mail::to($email)->send( new VerifyEmailOtp([
                        'name'=> $tutor->name,
                        'otp'=> $email_otp,
                        'email'=> $email,
                    ]));
                    return response()->json(['status' => true, 'message' => 'Email send successfull!']);

                }else
                {
                    return response()->json(['status' => false, 'message' => 'Email not send!']);
                }



            }


        } catch (Exception $e) {

        }
    }

    public function tutorTypeUniversity(Request $request)
    {

        try{
            $validator = Validator::make($request->all(), [
                'tutor_id'                   => 'required',
                'degree_name'                => 'required',
                'university'                 => 'required',
                'type'                       => 'required',
                'department_id'              => 'nullable',

            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $tutotType = new TutorTypeUniversity();
            $tutotType->tutor_id         = $request->tutor_id;
            $tutotType->university       = $request->university;
            $tutotType->degree_name      = $request->degree_name;
            $tutotType->type             = $request->type;
            $tutotType->department_id    = $request->department_id;
            $tutotType->group_or_major   = $request->group_or_major;
            $tutotType->save();

            return response()->json(['status' => true, 'message' => 'Wait for the approval!']);

        } catch (Exception $e) {

        }
    }


    public function profileImageUpload(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tutor_id' => 'required|exists:tutors,id',
                'image'    => 'required|mimes:jpg,jpeg,png,bmp|max:2000',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()], 400);
            }

            $tutor_id = $request->input('tutor_id');
            $tutor = Tutor::findOrFail($tutor_id);

            // Delete old image from R2
            if ($tutor->image) {
                if (Storage::disk('r2')->exists('tutor-images/' . $tutor->image)) {
                    Storage::disk('r2')->delete('tutor-images/' . $tutor->image);
                }
            }

            if ($request->hasFile('image')) {

                $image = $request->file('image');
                $imageName = $tutor_id . '_' . rand(1234, 9999) . time() . '.jpg';

                // Load image
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

                // Convert to JPG in memory
                ob_start();
                imagejpeg($imgResource, null, 100);
                $imageContent = ob_get_clean();

                imagedestroy($imgResource);

                // Upload to R2
                Storage::disk('r2')->put(
                    'tutor-images/' . $imageName,
                    $imageContent
                );

                $tutor->image = $imageName;
                $tutor->save();
            }


            $log_image = new TutorLog();

            if ($request->hasFile('image')) {

                $logImage = $request->file('image');
                $logImageName = $tutor_id . '_' . rand(1234, 9999) . time() . '.png';

                // Load image
                $logImgResource = null;

                switch (strtolower($logImage->getClientOriginalExtension())) {

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

                    default:
                        throw new \Exception('Unsupported image format');
                }

                // Convert to PNG in memory
                ob_start();
                imagepng($logImgResource);
                $logImageContent = ob_get_clean();

                imagedestroy($logImgResource);

                // Upload to R2
                Storage::disk('r2')->put(
                    'tutor-log-images/' . $logImageName,
                    $logImageContent
                );

                $log_image->profile_image = $logImageName;
                $log_image->tutor_id = $tutor_id;
                $log_image->edited_user = $tutor_id;
                $log_image->save();
            }

            return response()->json([
                'message' => 'Profile picture uploaded successfully'
            ]);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'error' => 'Tutor not found'
            ], 404);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function getImage($id)
    {
        $tutor_credentials = TutorCertificate::where('tutor_id', $id)->get();
        $tutor_profile_image = Tutor::find($id);

        $fields = [
            'ssc_c',
            'ssc_m',
            'hsc_c',
            'hsc_m',
            'nid',
            'university_c',
            'diploma_c',
            'post_graduation_c',
            'cv',
            'others'
        ];

        foreach ($tutor_credentials as $credential) {

            foreach ($fields as $field) {

                if (!empty($credential->$field)) {

                    $credential->$field = Storage::disk('r2')->url(
                        'tutor-certificate/' . $credential->$field
                    );

                }

            }

        }

        if ($tutor_profile_image && !empty($tutor_profile_image->image)) {
            $tutor_profile_image->image = Storage::disk('r2')->url(
                'tutor-images/' . $tutor_profile_image->image
            );
        }

        return response()->json([
            'credentials_image' => $tutor_credentials,
            'profile_image' => $tutor_profile_image ? $tutor_profile_image->image : null,
        ], 200, [], JSON_UNESCAPED_SLASHES);
    }

    public function updateStatus(Request $request)
    {
        try {
            $id = $request->tutor_id;
            $tutor = Tutor::find($id);

            if (!$tutor) {
                return response()->json(['status' => false, 'message' => 'Tutor not found']);
            }

            $status = $request->input('status');


            if($status == 0)
            {
                $tutor->inactive_date = now();
            }

            $tutor->is_active = $status;
            $tutor->save();

            return response()->json(['status' => true, 'message' => 'Status updated successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Internal Server Error'], 500);
        }
    }
    // Tutoring History Start


    public function appliedJob()
    {
        try {
            $tutorId = auth::user()->id;
            $tutor = Tutor::find($tutorId);

            if (!$tutor) {
                return response()->json(['error' => 'Tutor not found.'], 404);
            }

            $tutorApplications = JobApplication::where('tutor_id', $tutorId)
                ->with('jobOffer')
                ->orderBy('id','desc')
                ->get();

            $applied_data = [];

            foreach ($tutorApplications as $application) {
                $jobOffer = $application->jobOffer;

                $applied_data[] = [
                    'applied_at' => (new DateTime($application->created_at))->format('Y-m-d H:i:s'),
                    'job_offer'  => [
                        'job_id'       => $jobOffer->id,
                        'posted_date'  => (new DateTime($jobOffer->created_at))->format('Y-m-d H:i:s'),
                        'category'     => $jobOffer->category->name,
                        'course'       => $jobOffer->course->name,
                        'location'     => $jobOffer->location->name,
                        'live_status'  => $jobOffer->is_active,
                    ],
                ];
            }

            return response()->json([
                'total_applied' => $tutorApplications->count(),
                'applied'       => $applied_data,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error retrieving tutor job applications.'], 500);
        }
    }
    public function appointedJob()
    {
        try {
            $tutorId = auth::user()->id;
            $tutor   = Tutor::find($tutorId);

            $isShortlisted = true;

            $tutorApplications = JobApplication::where('tutor_id', $tutorId)
                    ->when($isShortlisted, function ($query) {
                        return $query->whereNotNull('taken_at');
                    })
                    ->with('jobOffer')
                    ->latest('taken_at')
                    ->get();

            $appointed_data = [];

            foreach ($tutorApplications as $application) {
                $jobOffer = $application->jobOffer;

                $appointed_data[] = [
                    'appointed_at' => (new DateTime($application->taken_at))->format('Y-m-d H:i:s'),
                    'job_offer'    => [
                        'job_id'       => $jobOffer->id,
                        'posted_date'  => (new DateTime($jobOffer->created_at))->format('Y-m-d H:i:s'),
                        'category'     => $jobOffer->category->name,
                        'course'       => $jobOffer->course->name,
                        'location'     => $jobOffer->location->name,
                        'live_status'  => $jobOffer->is_active,
                    ],
                ];
            }

            return response()->json([
                'total_applied' => $tutorApplications->count(),
                'appointed'     => $appointed_data,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error retrieving tutor job applications.'], 500);
        }
    }

    public function shortlistedJob()
    {
        try {
            $tutorId = auth::user()->id;
            $tutor = Tutor::find($tutorId);

            if (!$tutor) {
                return response()->json(['error' => 'Tutor not found.'], 404);
            }
            $isShortlisted = true;

            $tutorApplications = JobApplication::where('tutor_id', $tutorId)
                ->when($isShortlisted, function ($query) {
                    return $query->where('is_shortlisted', 1);
                })
                ->with('jobOffer')
                ->orderBy('shortlisted_date','desc')
                ->get();

            $shortlisted_data = [];

            foreach ($tutorApplications as $application) {
                $jobOffer = $application->jobOffer;

                $shortlisted_data[] = [
                    'shortlisted_date' => (new DateTime($application->shortlisted_date))->format('Y-m-d H:i:s'),
                    'job_offer'        => [
                        'job_id'       => $jobOffer->id,
                        'posted_date'  => (new DateTime($jobOffer->created_at))->format('Y-m-d H:i:s'),
                        'category'     => $jobOffer->category->name,
                        'course'       => $jobOffer->course->name,
                        'location'     => $jobOffer->location->name,
                        'live_status'  => $jobOffer->is_active,
                    ],
                ];
            }

            return response()->json([
                'total_shortlisted' => $tutorApplications->count(),
                'shortlisted'       => $shortlisted_data,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error retrieving tutor job applications.'], 500);
        }
    }

    public function confirmJob()
    {
        try {
            $tutorId = auth::user()->id;
            $tutor = Tutor::find($tutorId);

            if (!$tutor) {
                return response()->json(['error' => 'Tutor not found.'], 404);
            }
            $isconfirm = true;


            $tutorApplications = JobApplication::where('tutor_id', $tutorId)
                ->when($isconfirm, function ($query) {
                    return $query->whereNotNull('confirm_date');
                })
                ->with('jobOffer')
                ->latest('confirm_date')
                ->get();

            $confirmed_data = [];
            $totalApplications = $tutorApplications->count();
            $counter = $totalApplications;

            foreach ($tutorApplications as $application) {
                $jobOffer = $application->jobOffer;

                $payment = $application->payment_status;
                $due = $application->due_amount;
                $payment_date_confirm = $application->payment_date;
                $paid_date_confirm = $application->paid_date;

                $payment_status = '';

                if ($payment != null && $due == 0) {
                    $payment_status = 'Payment Successful';
                    $paid_date = $paid_date_confirm;
                } elseif ($payment == null && $due == null) {
                    $payment_status = 'Payment Pending';
                    $payment_date = $payment_date_confirm;
                }

                $confirmed_data[] = [
                    'confirm_date'   => (new DateTime($application->confirm_date))->format('Y-m-d H:i:s'),
                    'charge'         => $application->charge,
                    'payment_date'   => $application->payment_date,
                    'paid_date'      => $application->paid_date,
                    'payment_status' => $payment_status,

                    'job_offer'      => [
                        'application_number' => $this->ordinal($counter),
                        'job_id'             => $jobOffer->id,
                        'posted_date'        => (new DateTime($jobOffer->created_at))->format('Y-m-d H:i:s'),
                        'category'           => $jobOffer->category->name,
                        'tutor_name'         => $application->tutor->name,
                        'tutor_id'           => $application->tutor->unique_id,
                        'tutor_email'        => $application->tutor->email,
                        'course'             => $jobOffer->course->name,
                        'location'           => $jobOffer->location->name,
                        'live_status'        => $jobOffer->is_active,
                    ],
                ];

                $counter--;
            }

            return response()->json([
                'total_confirmed' => $tutorApplications->count(),
                'confirmed_data'  => $confirmed_data,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error retrieving tutor job applications.'], 500);
        }
    }


    private function ordinal($number) {
        $ends = ['th','st','nd','rd','th','th','th','th','th','th'];
        if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
            return $number . 'th';
        }
        return $number . $ends[$number % 10];
    }



    public function paymentCompleteJob()
    {
        try {
            $tutorId = auth::user()->id;
            $tutor   = Tutor::find($tutorId);

            if (!$tutor) {
                return response()->json(['error' => 'Tutor not found.'], 404);
            }
            $paidStatus = true;

            $tutorApplications = JobApplication::where('tutor_id', $tutorId)
                ->whereNotNull('payment_status')
                ->whereNotNull('payment_date')
                ->with('jobOffer')
                ->latest('payment_date','desc')
                ->get();

            $paidJobData = [];

            foreach ($tutorApplications as $application) {
                $jobOffer        = $application->jobOffer;

                $payment_date = (new DateTime($application->payment_date))->format('Y-m-d H:i:s');

                $paidJobData[] = [
                    'payment_date'   => $payment_date,
                    'paid_amount'    => $application->received_amount,

                    'job_offer'      => [
                        'job_id'       => $jobOffer->id,
                        'posted_date'  => (new DateTime($jobOffer->created_at))->format('Y-m-d H:i:s'),
                        'category'     => $jobOffer->category->name,
                        'course'       => $jobOffer->course->name,
                        'location'     => $jobOffer->location->name,
                        'live_status'  => $jobOffer->is_active,
                    ],
                ];
            }

            return response()->json([
                'total_paid'   => $tutorApplications->count(),
                'paidJobData'  => $paidJobData,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error retrieving tutor job applications.'], 500);
        }
    }

    public function dueJob()
    {
        try {
            $tutorId = auth::user()->id;
            $tutor   = Tutor::find($tutorId);

            if (!$tutor) {
                return response()->json(['error' => 'Tutor not found.'], 404);
            }

            $paidStatus = true;

            $tutorApplications = JobApplication::where('tutor_id', $tutorId)
                ->when($paidStatus, function ($query) {
                    return $query->where('payment_status', 'due');
                })
                ->with('jobOffer')
                ->latest('payment_date')
                ->get();

            $tutorDuePaidApplications = JobApplication::where('tutor_id', $tutorId)
                ->where('due_complete', 1)
                ->with('jobOffer')
                ->latest('paid_date')
                ->get();

            $dueData = [];
            $duePaidData = [];

            foreach ($tutorApplications as $application) {
                $jobOffer        = $application->jobOffer;
                $payment         = $application->payment_status;
                $due             = $application->due_amount;
                $due_status      = ($payment == 'due' && $due !== 0) ? 'Due Pending' : null;

                $dueData[] = [
                    'confirm_date'        => (new DateTime($application->confirm_date))->format('Y-m-d H:i:s'),
                    'due_payment_date'    => (new DateTime($application->due_payment_date))->format('Y-m-d H:i:s'),
                    'due_amount'          => $application->due_amount,
                    'due_status'          => $due_status,

                    'job_offer'      => [
                        'job_id'       => $jobOffer->id,
                        'posted_date'  => (new DateTime($jobOffer->created_at))->format('Y-m-d H:i:s'),
                        'category'     => $jobOffer->category->name,
                        'course'       => $jobOffer->course->name,
                        'location'     => $jobOffer->location->name,
                        'live_status'  => $jobOffer->is_active,
                    ],
                ];
            }

            foreach ($tutorDuePaidApplications as $duepaidapplication) {
                $jobOffer        = $duepaidapplication->jobOffer;

                $duePaidData[] = [
                    'confirm_date'        => (new DateTime($duepaidapplication->confirm_date))->format('Y-m-d H:i:s'),
                    'paid_date'           => (new DateTime($duepaidapplication->paid_date))->format('Y-m-d H:i:s'),
                    'due_amount'          => $duepaidapplication->received_amount,
                    'due_status'          => 'Due Paid',

                    'job_offer'      => [
                        'job_id'       => $jobOffer->id,
                        'posted_date'  => (new DateTime($jobOffer->created_at))->format('Y-m-d H:i:s'),
                        'category'     => $jobOffer->category->name,
                        'course'       => $jobOffer->course->name,
                        'location'     => $jobOffer->location->name,
                        'live_status'  => $jobOffer->is_active,
                    ],
                ];
            }

            return response()->json([
                'total_due'      => count($dueData),
                'total_due_paid'  => count($duePaidData),
                'dueData' => $dueData,
                'duePaidData' => $duePaidData,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error retrieving tutor job applications.'], 500);
        }
    }
    public function refundJob()
    {
        try {
            $tutorId = auth::user()->id;
            $tutor   = Tutor::find($tutorId);

            if (!$tutor) {
                return response()->json(['error' => 'Tutor not found.'], 404);
            }

            $paidStatus = true;

            $tutorApplications = JobApplication::where('tutor_id', $tutorId)
                ->when($paidStatus, function ($query) {
                    return $query->where('payment_status', 'refund');
                })
                ->with('jobOffer')
                ->latest('payment_date')
                ->get();
            $refundData = [];

            foreach ($tutorApplications as $application) {
                $jobOffer        = $application->jobOffer;
                $payment         = $application->refund_status;

                $refund_amount   = $application->refund_amount;

                $refund_complete_amount   = $application->refund_complete_amount;

                $refund_status   = $payment == 0 ? 'Refund Pending' : 'Refund Successfull';

                $refundData[] = [
                    'payment_date'             => $application->paid_date,
                    'refund_date'              => $application->refund_date,
                    'refund_paid_date'         => $application->refund_complete_date,
                    'refundable_amount'        => $refund_amount,
                    'paid_amount'              => $refund_complete_amount,
                    'refund_status'            => $refund_status,

                    'job_offer'      => [
                        'job_id'       => $jobOffer->id,
                        'posted_date'  => (new DateTime($jobOffer->created_at))->format('Y-m-d H:i:s'),
                        'category'     => $jobOffer->category->name,
                        'course'       => $jobOffer->course->name,
                        'location'     => $jobOffer->location->name,
                        'live_status'  => $jobOffer->is_active,
                    ],
                ];
            }

            return response()->json([
                'refunTution' => $tutorApplications->count(),
                'refundData'  => $refundData,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error retrieving tutor job applications.'], 500);
        }
    }

    public function canceledJob()
    {
        try {
            $tutorId = auth::user()->id;
            $tutor   = Tutor::find($tutorId);

            if (!$tutor) {
                return response()->json(['error' => 'Tutor not found.'], 404);
            }

            $isclosed = true;

            $tutorApplications = JobApplication::where('tutor_id', $tutorId)
                ->where(function ($query) {
                    $query->whereNotNull('closed_date')
                        ->orWhereNotNull('repost_date');
                })
                ->with('jobOffer')
                ->orderBy('taken_at','desc')
                ->get();


            $closed_data = [];

            foreach ($tutorApplications as $application) {
                $jobOffer = $application->jobOffer;

                $closed_data[] = [
                    'cancel_date'             => $application->closed_date ? (new DateTime($application->closed_date))->format('Y-m-d H:i:s') : (new DateTime($application->repost_date))->format('Y-m-d H:i:s'),
                    'job_offer'  => [
                        'job_id'       => $jobOffer->id,
                        'posted_date'  => (new DateTime($jobOffer->created_at))->format('Y-m-d H:i:s'),
                        'category'     => $jobOffer->category->name,
                        'course'       => $jobOffer->course->name,
                        'location'     => $jobOffer->location->name,
                        'live_status'  => $jobOffer->is_active,
                    ],
                ];
            }

            return response()->json([
                'total_cancel' => $tutorApplications->count(),
                'canceled'     => $closed_data,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error retrieving tutor job applications.'], 500);
        }
    }
    public function tutoringHistory()
    {
        return response()->json([
            'appliedJob'         => $this->appliedJob(),
            'appointedJob'       => $this->appointedJob(),
            'shortlistedJob'     => $this->shortlistedJob(),
            'confirmJob'         => $this->confirmJob(),
            'paymentCompleteJob' => $this->paymentCompleteJob(),
            'dueJob'             => $this->dueJob(),
            'canceled'           => $this->canceledJob(),
            'current_status'     => $this->currentStatusJob(),
            'refund_job'         => $this->refundJob(),
        ]);

    }

    public function currentStatusJob()
    {
        try {
            $tutorId = auth::user()->id;
            $tutor   = Tutor::find($tutorId);

            if (!$tutor) {
                return response()->json(['error' => 'Tutor not found.'], 404);
            }

            $tutorAssignApplications = JobApplication::where('tutor_id', $tutorId)
                ->where('current_stage', 'assign')
                ->latest('taken_at')
                ->with('jobOffer')
                ->get();

            $tutorWaitingApplications = JobApplication::where('tutor_id', $tutorId)
                ->where('current_stage', 'waiting')
                ->with('jobOffer')
                ->latest('taken_at')
                ->get();

            $tutorMeetingApplications = JobApplication::where('tutor_id', $tutorId)
                ->where('current_stage', 'meet')
                ->with('jobOffer')
                ->latest('taken_at')
                ->get();

            $tutorTrialApplications = JobApplication::where('tutor_id', $tutorId)
                ->where('current_stage', 'trial')
                ->with('jobOffer')
                ->latest('taken_at')
                ->get();

            $tutorProblemApplications = JobApplication::where('tutor_id', $tutorId)
                ->where('current_stage', 'problem')
                ->with('jobOffer')
                ->latest('taken_at')
                ->get();

            $assignData = [];
            $waitingData = [];
            $MeetingData = [];
            $trialData = [];
            $problemData = [];

            // Assign
            foreach ($tutorAssignApplications as $application) {
                $jobOffer = $application->jobOffer;

                $formattedCreatedAt = $this->formatDateTime($application->created_at);

                $assignData[] = [
                    'apply_date'   => $formattedCreatedAt,
                    'application_status' => $application->current_stage,
                    'assign_status'=> 'Waiting For Parents Confirmation',
                    'job_offer'    => $this->formatJobOfferData($jobOffer),
                ];
            }

            // Waiting
            foreach ($tutorWaitingApplications as $waitingApplication) {
                $jobOffer = $waitingApplication->jobOffer;
                $formattedCreatedAt = $this->formatDateTime($waitingApplication->created_at);

                $waitingData[] = [
                    'apply_date'   => $formattedCreatedAt,
                    'waiting_date' => $waitingApplication->waiting_date,
                    'waiting_status'       => 'Waiting for parents meetup',
                    'application_status' => $waitingApplication->current_stage,
                    'job_offer'    => $this->formatJobOfferData($jobOffer),
                ];
            }

            // Meet
            foreach ($tutorMeetingApplications as $meetingApplication) {
                $jobOffer = $meetingApplication->jobOffer;

                $formattedCreatedAt = $this->formatDateTime($meetingApplication->created_at);

                $MeetingData[] = [
                    'apply_date'   => $formattedCreatedAt,
                    'meeting_date' => $meetingApplication->meeting_date,
                    'meeting_status'       => 'Waiting for demo class',
                    'application_status' => $meetingApplication->current_stage,
                    'job_offer'    => $this->formatJobOfferData($jobOffer),
                ];
            }

            // Trial
            foreach ($tutorTrialApplications as $trialApplication) {
                $jobOffer = $trialApplication->jobOffer;

                $formattedCreatedAt = $this->formatDateTime($trialApplication->created_at);

                $trialData[] = [
                    'apply_date'   => $formattedCreatedAt,
                    'trial_date'   => $trialApplication->trial_date_1st,
                    'trial_status'       => 'Running Demo Class',
                    'application_status' => $trialApplication->current_stage,
                    'job_offer'    => $this->formatJobOfferData($jobOffer),
                ];

            }

            // Problem
            foreach ($tutorProblemApplications as $problemApplication) {
                $jobOffer = $problemApplication->jobOffer;

                $formattedCreatedAt = $this->formatDateTime($problemApplication->created_at);

                // Convert panding_to string to Carbon instance
                $formattedPendingTo = $problemApplication->panding_to ? Carbon::parse($problemApplication->panding_to)->format('Y-m-d H:i:s') : null;

                $problemData[] = [
                    'apply_date'        => $formattedCreatedAt,
                    'problem_date'      => $formattedPendingTo,
                    'problem_status'    => 'This offer Needs Some Clearence',
                    'application_status'=> $problemApplication->current_stage,
                    'job_offer'         => $this->formatJobOfferData($jobOffer),
                ];
            }
            return response()->json([
                'assign'  => $assignData,
                'waiting' => $waitingData,
                'meeting' => $MeetingData,
                'trial'   => $trialData,
                'problem' => $problemData,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error retrieving tutor job applications.'], 500);
        }
    }

    private function formatJobApplicationData($application, $jobOffer)
    {
        return [
            'apply_date' => $this->formatDateTime($application->created_at),
            'status'     => 'Waiting For parents confirmation',
            'job_offer'  => $this->formatJobOfferData($jobOffer),
        ];
    }

    private function formatJobOfferData($jobOffer)
    {
        return [
            'job_id'       => $jobOffer->id,
            'posted_date'  => $this->formatDateTime($jobOffer->created_at),
            'category'     => $jobOffer->category->name,
            'course'       => $jobOffer->course->name,
            'location'     => $jobOffer->location->name,
        ];
    }

    private function formatDateTime($dateTime)
    {
        return (new DateTime($dateTime))->format('Y-m-d H:i:s');
    }
    // Current Status Job End



    public function getmembershipStatus()
    {
        try {
            $tutorId = auth::user()->id;
            $tutor   = Tutor::find($tutorId);

            if (!$tutor) {
                return response()->json(['error' => 'Tutor not found.'], 404);
            }

            $membershipStatus = [];

            $requestStatus = PremiumMembership::where('tutor_id',$tutorId)->first();
            if($requestStatus != null)
            {
                $membershipStatus = $requestStatus->request_status;

            }


            return response()->json([
                'status' => $membershipStatus,

            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error retrieving tutor job applications.'], 500);
        }
    }
    public function sendMembershipRequest()
    {
        try {
            $tutorId = auth::user()->id;
            $tutor   = Tutor::find($tutorId);

            if (!$tutor) {
                return response()->json(['error' => 'Tutor not found.'], 404);
            }

            $requestStatus = PremiumMembership::where('tutor_id',$tutorId)->first();
            if($requestStatus)
            {
                return response()->json(['message' => 'Already requested.']);

            }

            $sendMembershipRequest = new PremiumMembership ();
            $sendMembershipRequest->tutor_id        = $tutorId;
            $sendMembershipRequest->name            = $tutor->name;
            $sendMembershipRequest->request_status  = 'pending';
            $sendMembershipRequest->package_name    = 'regular';

            $sendMembershipRequest->save();

            return response()->json(['message' => 'Request Sent.']);


        } catch (\Exception $e) {
            return response()->json(['error' => 'Sending Request Error.'], 500);
        }
    }
    public function sendVerifyRequest()
    {
        try {
            $tutorId = auth::user()->id;
            $tutor   = Tutor::find($tutorId);

            if (!$tutor) {
                return response()->json(['error' => 'Tutor not found.'], 404);
            }

            $requestStatus = VerificationRequest::where('tutor_id',$tutorId)->first();
            if($requestStatus)
            {
                return response()->json(['message' => 'Already requested.']);

            }

            $sendVerifyRequest = new VerificationRequest ();
            $sendVerifyRequest->tutor_id        = $tutorId;
            $sendVerifyRequest->name            = $tutor->name;
            $sendVerifyRequest->request_status  = 'pending';


            $sendVerifyRequest->save();

            return response()->json(['message' => 'Request Sent.']);


        } catch (\Exception $e) {
            return response()->json(['error' => 'Sending Request Error.'], 500);
        }
    }


    public function tutorPopupImages()
    {
        $popupImages = PopupImageData::where('tutor_id', auth::user()->id)->where('status',1)->get();
        if ($popupImages->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'No popup images found.']);
        }
        return response()->json(['status' => true, 'message' => 'Popup images retrieved successfully.', 'data' => $popupImages]);
    }
    private function createCustomToken($user, $scope)
{
    $tokenResult = $user->createToken($user->name, [$scope]);

    $tokenResult->token->expires_at = now()->addDays(7);
    $tokenResult->token->save();

    return $tokenResult->accessToken;
}

public function tutorLeadRegistration(Request $request)
{
    try {

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validator = Validator::make($request->all(), [
            'phone'                 => 'required|string|max:20',
            'name'                  => 'required|string|max:255',
            'gender'                => 'required',
            'city_id'               => 'required|integer',
            'location_id'           => 'required|integer',

            'preferred_location'    => 'required',

             

            'hns_institute_id'      => 'required|integer',
            'department_id'         => 'required|integer',
            'university_type'       => 'required',
            'ssc_curriculamn_id'    => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error'  => $validator->errors(),
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Normalize Phone
        |--------------------------------------------------------------------------
        */

        $phone = trim($request->phone);


        /*
        |--------------------------------------------------------------------------
        | Check Existing Tutor
        |--------------------------------------------------------------------------
        */

        $existingTutor = Tutor::where('phone', $phone)->first();

        if ($existingTutor) {
            return response()->json([
                'status'  => false,
                'message' => 'This phone number is already registered.',
            ], 409);
        }


        /*
        |--------------------------------------------------------------------------
        | Generate OTP
        |--------------------------------------------------------------------------
        */

        $otp = random_int(1234, 9999);

        $otpExpiry = now()->addMinutes(10);


        /*
        |--------------------------------------------------------------------------
        | Database Transaction
        |--------------------------------------------------------------------------
        */

        $data = DB::transaction(function () use (
            $request,
            $phone,
            $otp,
            $otpExpiry
        ) {

            /*
            |--------------------------------------------------------------------------
            | Create Tutor
            |--------------------------------------------------------------------------
            */

            $tutor = new Tutor();

            $tutor->otp                 = $otp;
            $tutor->otp_expiry          = $otpExpiry;
            $tutor->name                = trim($request->name);
            $tutor->phone               = $phone;
            $tutor->gender              = $request->gender;
            $tutor->ip_address          = $request->ip();
            $tutor->role_id             = 3;
            $tutor->password            = Hash::make('12345678');
            $tutor->user_agent          = $request->header('User-Agent');
            $tutor->login_at            = now();
            $tutor->phone_varified_at   = now();

            $tutor->save();

            /*
            |--------------------------------------------------------------------------
            | Generate Tutor Unique ID
            |--------------------------------------------------------------------------
            */

            $tutor->get_tutor_unique_id();


            /*
            |--------------------------------------------------------------------------
            | Create Access Token
            |--------------------------------------------------------------------------
            */

            $token = $this->createCustomToken(
                $tutor,
                'tutors'
            );


            /*
            |--------------------------------------------------------------------------
            | SMS Balance
            |--------------------------------------------------------------------------
            */

            $smsBalance = new SmsBalance();
            $smsBalance->tutor_id = $tutor->id;
            $smsBalance->save();


            /*
            |--------------------------------------------------------------------------
            | Tutor Log
            |--------------------------------------------------------------------------
            */

            $tutorLog = new TutorLog();

            $tutorLog->tutor_id = $tutor->id;
            $tutorLog->name     = $tutor->name;
            $tutorLog->email    = $tutor->email ?? null;
            $tutorLog->phone    = $tutor->phone;

            $tutorLog->save();


            /*
            |--------------------------------------------------------------------------
            | Counting
            |--------------------------------------------------------------------------
            */

            $counting = new Counting();

            $counting->tutor_id         = $tutor->id;
            $counting->applied_job      = 0;
            $counting->shortlisted_job  = 0;
            $counting->appointed_job    = 0;
            $counting->confirmed_job    = 0;
            $counting->cancel_job       = 0;
            $counting->payment_job      = 0;

            $counting->save();


            /*
            |--------------------------------------------------------------------------
            | Tutor Personal Information
            |--------------------------------------------------------------------------
            */

            TutorPersonalInfo::updateOrCreate(
                [
                    'tutor_id' => $tutor->id,
                ],
                [
                    'country_id'  => 1,
                    'city_id'     => $request->city_id,
                    'location_id' => $request->location_id,
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | Preferred Locations
            |--------------------------------------------------------------------------
            */

            

            $tutor->tutor_prefered_locations()
                ->sync($request->preferred_location);


            /*
            |--------------------------------------------------------------------------
            | Honours / University Education
            |--------------------------------------------------------------------------
            */

            TutorEducation::updateOrCreate(
                [
                    'tutor_id' => $tutor->id,
                    'degree_name' => 'honours',
                ],
                [
                    'institute_id'    => $request->hns_institute_id,
                    'department_id'   => $request->department_id,
                    'university_type' => $request->university_type,
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | SSC Education
            |--------------------------------------------------------------------------
            */

            TutorEducation::updateOrCreate(
                [
                    'tutor_id'    => $tutor->id,
                    'degree_name' => 'ssc',
                ],
                [
                    'curriculum_id' => $request->ssc_curriculamn_id,
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | Response Data
            |--------------------------------------------------------------------------
            */

            return [
                'id'    => $tutor->id,
                'token' => $token,
            ];
        });


        /*
        |--------------------------------------------------------------------------
        | Success Response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'status'  => true,
            'message' => 'Your profile registration has been completed successfully.',
            'data'    => $data,
        ], 201);


    } catch (\Throwable $e) {

      


        /*
        |--------------------------------------------------------------------------
        | Error Response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'status'  => false,
            'message' => 'Unable to complete registration. Please try again.',
        ], 500);
    }
}






}
