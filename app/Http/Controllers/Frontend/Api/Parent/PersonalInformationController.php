<?php

namespace App\Http\Controllers\Frontend\Api\Parent;

use App\Http\Controllers\Controller;
use App\Models\ParentPersonalInfo;
use App\Models\Parents;
use App\ParentsModule\ContactInfo;
use App\ParentsModule\ParentsPersonalInfoUpdate;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use mysql_xdevapi\RowResult;
use Exception;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PersonalInformationController extends Controller
{
    use ApiResponse;
    public function ContactInfoUpdate(Request $request)
    {
        try{

            $validator = Validator()->make($request->all(),[
                'country_id'=>'required',
                'city_id' =>'required',
                'location_id'=>'required',
                'address'=>'nullable',
                'additional_number'=>'nullable|regex:/(01)[0-9]{9}/',
                'whatsup_number'=>'nullable|regex:/(01)[0-9]{9}/',
                'facebook_link'=>'nullable',
                'opinion'=>'nullable',
            ]);
            if ($validator->fails())
            {
                return response()->json(['status'=>'false','error'=>$validator->errors()],422);
            }
            $contact_info = new ParentsPersonalInfoUpdate();
            if (Auth::user()->id)
            {
                $contact_info->contactInfo($request);
                return response()->json(['status'=>'true','message'=>'Contact information saved successfully.']);
            }else
            {
                return response()->json(['status'=>'false','error'=>'Parents Id not Found!']);
            }



        }catch(Exception $e)
        {
            return $this->resposeError('',$e->getMessage());
        }



    }

    public function personalInfoUpdate(Request $request)
    {
        try{

            $validator = Validator()->make($request->all(),[
                'gender'=>'nullable',
                'date_of_birth' =>'nullable',
                'profession'=>'nullable',
                'about_us'=>'nullable',
            ]);
            if ($validator->fails())
            {
                return response()->json(['status'=>'false','error'=>$validator->errors()]);
            }
            $contact_info = new ParentsPersonalInfoUpdate();
            if (Auth::user()->id)
            {
                $contact_info->personalInfo($request);
                return response()->json(['status'=>'true','message'=>'Personal Information Saved Successfuly!']);

            }else
            {
                return response()->json(['status'=>'false','error'=>'Parents Id not Found!']);
            }


        }catch(Exception $e)
        {
            return $this->resposeError('',$e->getMessage());
        }


    }
    public function kidsInfoUpdate(Request $request)
    {
        try{
            $validator = Validator()->make($request->all(),[
                'children_number'=>'nullable',
                'class_name' =>'nullable',
                'category'=>'nullable',
                'institute'=>'nullable',
            ]);
            if ($validator->fails())
            {
                return response()->json(['status'=>'false','error'=>$validator->errors()]);
            }
            $kids_info = new ParentsPersonalInfoUpdate();
            if (Auth::user()->id)
            {
                $kids_info->kidsInfo($request);
                return response()->json(['status'=>'true','message'=>'Kids Information Saved Successfuly!']);

            }else
            {
                return response()->json(['status'=>'false','error'=>'Parents Id not Found!']);
            }



        }catch(Exception $e)
        {
            return $this->resposeError('',$e->getMessage());
        }

    }
    public function allInfoShow()
    {
        try {
            $show_parent = Parents::with([
                'parents_personalInfo',
                'parent_notices' => function ($query) {
                    $query->where('status', 1)
                          ->select('parent_id', 'description', 'created_at')
                          ->orderBy('id','desc');
                }
            ])
            ->where('id', Auth::user()->id)
            ->get();

            if (!$show_parent) {
                return response()->json(['status' => false, 'message' => 'No user found!']);
            }

            $show_parent->makeHidden(['otp', 'email_otp']);

            return response()->json([
                'status'  => true,
                'message' => 'User information retrieved successfully',
                'data'    => $show_parent,
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }
    }

}
