<?php

namespace App\ParentsModule;

use App\Models\ParentLog;
use App\Models\ParentPersonalInfo;
use Illuminate\Support\Facades\Auth;

class ParentsPersonalInfoUpdate
{

    public function contactInfo($request)
    {

        $check_parents = ParentPersonalInfo::where('parents_id',Auth::user()->id)->first();
        if ($check_parents != null)
        {
            $check_parents->country_id = $request->country_id;
            $check_parents->city_id = $request->city_id;
            $check_parents->location_id = $request->location_id;
            $check_parents->address_details = $request->address;
            $check_parents->additional_phone = $request->additional_number;
            $check_parents->whats_up_phone = $request->whatsup_number;
            $check_parents->facebook_profile = $request->facebook_link;
            $check_parents->personal_opinion = $request->opinion;
            $check_parents->save();

        }else
        {
            $contact_info = new ParentPersonalInfo();
            $contact_info->parents_id = Auth::user()->id;
            $contact_info->country_id = $request->country_id;
            $contact_info->city_id = $request->city_id;
            $contact_info->location_id = $request->location_id;
            $contact_info->address_details = $request->address;
            $contact_info->additional_phone = $request->additional_number;
            $contact_info->whats_up_phone = $request->whatsup_number;
            $contact_info->facebook_profile = $request->facebook_link;
            $contact_info->personal_opinion = $request->opinion;
            $contact_info->save();

        }
        $parents_log = new ParentLog();
        $parents_log->parents_id  = Auth::user()->id;
        $parents_log->country_id  = $request->country_id;
        $parents_log->city_id  = $request->city_id;
        $parents_log->location_id = $request->location_id;
        $parents_log->address_details = $request->address;
        $parents_log->additional_phone = $request->additional_number;
        $parents_log->whats_up_phone = $request->whatsup_number;
        $parents_log->facebook_profile = $request->facebook_link;
        $parents_log->save();


    }
    public function personalInfo($request)
    {

        $check_parents = ParentPersonalInfo::where('parents_id',Auth::user()->id)->first();
        if ($check_parents != null)
        {

            $check_parents->gender = $request->gender;
            $check_parents->date_of_birth = $request->date_of_birth;
            $check_parents->profession = $request->profession;
            $check_parents->about_us = $request->about_us;
            $check_parents->save();

        }else
        {
            $personal_info = new ParentPersonalInfo();
            $personal_info->parents_id = Auth::user()->id;
            $personal_info->gender = $request->gender;
            $personal_info->date_of_birth = $request->date_of_birth;
            $personal_info->profession = $request->profession;
            $personal_info->about_us = $request->about_us;
            $personal_info->save();

        }

    }
    public function kidsInfo($request)
    {

        $check_parents = ParentPersonalInfo::where('parents_id',Auth::user()->id)->first();
        if ($check_parents != null)
        {
            $check_parents->children_number = $request->children_number;
            $check_parents->class = $request->class_name;
            $check_parents->category = $request->category;
            $check_parents->institute_name = $request->institute;
            $check_parents->save();

        }else
        {
            $kids_info = new ParentPersonalInfo();
            $kids_info->parents_id = Auth::user()->id;
            $kids_info->children_number = $request->children_number;
            $kids_info->class = $request->class_name;
            $kids_info->category = $request->category;
            $kids_info->institute_name = $request->institute;
            $kids_info->save();

        }

    }
}
