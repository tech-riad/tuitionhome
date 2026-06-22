<?php

namespace App\TutorModule;

use App\Models\Certificate;
use App\Models\CropImage;
use Illuminate\Support\Facades\Auth;
class Tutor_Crediantial
{
    public function SSC_crediantial($file,$type)
    {
        $tutor_id = Auth::guard('tutor')->user()->id;
        $check_tutor = Certificate::where(['tutor_id'=>$tutor_id,'type'=>'SSC'])->first();
        $tutor_crop_check = CropImage::where('tutor_id',$tutor_id)->latest()->first();
        $tutor_crop_check->status = 1 ;
        $tutor_crop_check->save();
        if ($check_tutor != null)
        {
            $ssc = Certificate::where(['tutor_id'=>$tutor_id,'type'=>'SSC'])->first();
            $ssc->file_path = $file;
            $ssc->type = $type;
            $ssc->save();
        }else
        {
            $tutor_creadiantial = new Certificate();
            $tutor_creadiantial->tutor_id = $tutor_id;
            $tutor_creadiantial->file_path = $file;
            $tutor_creadiantial->type = $type;
            $tutor_creadiantial->save();
        }

    }
    public function HSC_crediantial($file,$type)
    {
        $tutor_id = Auth::guard('tutor')->user()->id;
        $check_tutor = Certificate::where(['tutor_id'=>$tutor_id,'type'=>'HSC'])->first();
        $check_tutor = Certificate::where(['tutor_id'=>$tutor_id,'type'=>'SSC'])->first();
        $tutor_crop_check = CropImage::where('tutor_id',$tutor_id)->latest()->first();
        $tutor_crop_check->status = 1 ;
        if ($check_tutor != null)
        {
            $ssc = Certificate::where(['tutor_id'=>$tutor_id,'type'=>'HSC'])->first();
            $ssc->file_path = $file;
            $ssc->type = $type;
            $ssc->save();
        }else
        {
            $tutor_creadiantial = new Certificate();
            $tutor_creadiantial->tutor_id = $tutor_id;
            $tutor_creadiantial->file_path = $file;
            $tutor_creadiantial->type = $type;
            $tutor_creadiantial->save();
        }

    }

    public function HONS_crediantial($file,$type)
    {
        $tutor_id = Auth::guard('tutor')->user()->id;
        $check_tutor = Certificate::where(['tutor_id'=>$tutor_id,'type'=>'honours'])->first();
        $check_tutor = Certificate::where(['tutor_id'=>$tutor_id,'type'=>'SSC'])->first();
        $tutor_crop_check = CropImage::where('tutor_id',$tutor_id)->latest()->first();
        $tutor_crop_check->status = 1 ;
        if ($check_tutor != null)
        {
            $ssc = Certificate::where(['tutor_id'=>$tutor_id,'type'=>'honours'])->first();
            $ssc->file_path = $file;
            $ssc->type = $type;
            $ssc->save();
        }else
        {
            $tutor_creadiantial = new Certificate();
            $tutor_creadiantial->tutor_id = $tutor_id;
            $tutor_creadiantial->file_path = $file;
            $tutor_creadiantial->type = $type;
            $tutor_creadiantial->save();
        }

    }
    public function Mast_crediantial($file,$type)
    {
        $tutor_id = Auth::guard('tutor')->user()->id;
        $check_tutor = Certificate::where(['tutor_id'=>$tutor_id,'type'=>'masters'])->first();
        $tutor_crop_check = CropImage::where('tutor_id',$tutor_id)->latest()->first();
        $tutor_crop_check->status = 1 ;
        if ($check_tutor != null)
        {
            $ssc = Certificate::where(['tutor_id'=>$tutor_id,'type'=>'masters'])->first();
            $ssc->file_path = $file;
            $ssc->type = $type;
            $ssc->save();
        }else
        {
            $tutor_creadiantial = new Certificate();
            $tutor_creadiantial->tutor_id = $tutor_id;
            $tutor_creadiantial->file_path = $file;
            $tutor_creadiantial->type = $type;
            $tutor_creadiantial->save();
        }

    }

//    function certificateUpload($image)
//{
//    $directory = "public/certificate/test_move.png";
//    $imageUrl = $directory;
//    File::move($image,$directory);
//    return $imageUrl;
//}

}
