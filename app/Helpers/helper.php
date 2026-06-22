<?php

use App\Models\TutorPersonalInfo;
use App\Models\TutorTypeUniversity;
use Illuminate\Support\Facades\Auth;

function imgUpload($image, $dir=null)
{
    $extension = $image->getClientOriginalExtension();
    $name = rand(1000,3000);
    $imageName = $name.'.'.$extension;
    if ($dir)
    {
        $directory = $dir;
    }else
    {
        $directory = "public/backend/images/";
    }
    $imageUrl = $directory.$imageName;
    $image->move($directory,$imageName);
    return $imageUrl;
}

function profile_pic()
{
    $t_user = Auth::guard('tutor')->user();
    $tutor = TutorPersonalInfo::with('t_user')->where('tutor_id',$t_user->id)->first();
    if ($tutor->pic != null )
    {
        return true;
    }else
    {
        return false;
    }
}

function is_active()
{
    $current_user = Auth::guard('tutor')->user();
    if ($current_user->is_active == 1)
    {
       return true;
    }else
    {
        return false;
    }
}


function certificateUpload($image, $dir=null)
{
    $extension = $image->getClientOriginalExtension();
    $name = rand(1000,3000);
    $imageName = $name.'.'.$extension;
    if ($dir)
    {
        $directory = $dir;
    }else
    {
        $directory = "public/backend/images/";
    }
    $imageUrl = $directory.$imageName;
    $image->move($directory,$imageName);
    return $imageUrl;
}






