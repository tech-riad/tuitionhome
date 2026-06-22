<?php

namespace App\TutorModule;

use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;

class TutorCertificate
{
    public function ssc_c($request)
    {
        $path = 'files/';
        $file = $request->file('sscCertificate');
        $new_image_name = 'UIMG'.date('Ymd').uniqid().'.jpg';
        $upload = $file->move(public_path($path), $new_image_name);
        if(!$upload){
            return response()->json(['status'=>0, 'msg'=>'Something went wrong, try again later']);

        }else {

            $tutor_id = Auth::guard('tutor')->user()->id;
            $tutor_ssc_c = Certificate::where(['tutor_id' => $tutor_id, 'type' => 'ssc_c'])->first();
            if ($tutor_ssc_c)
            {
                if ($tutor_ssc_c->file_path != null) {
                    unlink($path . $tutor_ssc_c->file_path);
                }
                $tutor_ssc_c->file_path = $new_image_name;
                $tutor_ssc_c->save();

            }else
            {
                $tutor_ssc_c = new Certificate();
                $tutor_ssc_c->tutor_id =$tutor_id;
                $tutor_ssc_c->file_path =$new_image_name;
                $tutor_ssc_c->type = 'ssc_c';
                $tutor_ssc_c->save();

            }

        }

    }
    public function ssc_m($request)
    {
        $path = 'files/';
        $file = $request->file('sscMarksheet');
        $new_image_name = 'UIMG'.date('Ymd').uniqid().'.jpg';
        $upload = $file->move(public_path($path), $new_image_name);
        if(!$upload){
            return response()->json(['status'=>0, 'msg'=>'Something went wrong, try again later']);

        }else {

            $tutor_id = Auth::guard('tutor')->user()->id;
            $tutor_ssc_m = Certificate::where(['tutor_id' => $tutor_id, 'type' => 'ssc_m'])->first();
            if ($tutor_ssc_m)
            {
                if ($tutor_ssc_m->file_path != null) {
                    unlink($path . $tutor_ssc_m->file_path);
                }
                $tutor_ssc_m->file_path = $new_image_name;
                $tutor_ssc_m->save();

            }else
            {
                $tutor_ssc_m = new Certificate();
                $tutor_ssc_m->tutor_id =$tutor_id;
                $tutor_ssc_m->file_path =$new_image_name;
                $tutor_ssc_m->type = 'ssc_m';
                $tutor_ssc_m->save();

            }

        }
    }
    public function hsc_c($request)
    {
        $path = 'files/';
        $file = $request->file('hscCertificate');
        $new_image_name = 'UIMG'.date('Ymd').uniqid().'.jpg';
        $upload = $file->move(public_path($path), $new_image_name);
        if(!$upload){
            return response()->json(['status'=>0, 'msg'=>'Something went wrong, try again later']);

        }else {

            $tutor_id = Auth::guard('tutor')->user()->id;
            $tutor_hsc_c= Certificate::where(['tutor_id' => $tutor_id, 'type' => 'hsc_c'])->first();
            if ($tutor_hsc_c)
            {
                if ($tutor_hsc_c->file_path != null) {
                    unlink($path . $tutor_hsc_c->file_path);
                }
                $tutor_hsc_c->file_path = $new_image_name;
                $tutor_hsc_c->save();

            }else
            {
                $tutor_hsc_c = new Certificate();
                $tutor_hsc_c->tutor_id =$tutor_id;
                $tutor_hsc_c->file_path =$new_image_name;
                $tutor_hsc_c->type = 'hsc_c';
                $tutor_hsc_c->save();

            }

        }
    }
    public function hsc_m($request)
    {
        $path = 'files/';
        $file = $request->file('hscMarksheet');
        $new_image_name = 'UIMG'.date('Ymd').uniqid().'.jpg';
        $upload = $file->move(public_path($path), $new_image_name);
        if(!$upload){
            return response()->json(['status'=>0, 'msg'=>'Something went wrong, try again later']);

        }else {

            $tutor_id = Auth::guard('tutor')->user()->id;
            $tutor_hsc_m= Certificate::where(['tutor_id' => $tutor_id, 'type' => 'hsc_m'])->first();
            if ($tutor_hsc_m)
            {
                if ($tutor_hsc_m->file_path != null) {
                    unlink($path . $tutor_hsc_m->file_path);
                }
                $tutor_hsc_m->file_path = $new_image_name;
                $tutor_hsc_m->save();

            }else
            {
                $tutor_hsc_m = new Certificate();
                $tutor_hsc_m->tutor_id =$tutor_id;
                $tutor_hsc_m->file_path =$new_image_name;
                $tutor_hsc_m->type = 'hsc_m';
                $tutor_hsc_m->save();

            }

        }
    }
    public function upload_cv($request)
    {
        $path = 'files/';
        $file = $request->file('upload_cv');
        $new_image_name = 'UIMG'.date('Ymd').uniqid().'.jpg';
        $upload = $file->move(public_path($path), $new_image_name);
        if(!$upload){
            return response()->json(['status'=>0, 'msg'=>'Something went wrong, try again later']);

        }else {

            $tutor_id = Auth::guard('tutor')->user()->id;
            $tutor_upload_cv= Certificate::where(['tutor_id' => $tutor_id, 'type' => 'cv'])->first();
            if ($tutor_upload_cv)
            {
                if ($tutor_upload_cv->file_path != null) {
                    unlink($path . $tutor_upload_cv->file_path);
                }
                $tutor_upload_cv->file_path = $new_image_name;
                $tutor_upload_cv->save();

            }else
            {
                $tutor_upload_cv = new Certificate();
                $tutor_upload_cv->tutor_id =$tutor_id;
                $tutor_upload_cv->file_path =$new_image_name;
                $tutor_upload_cv->type = 'cv';
                $tutor_upload_cv->save();

            }

        }
    }
    public function birth_nid($request)
    {
        $path = 'files/';
        $file = $request->file('birth_nid_certificate');
        $new_image_name = 'UIMG'.date('Ymd').uniqid().'.jpg';
        $upload = $file->move(public_path($path), $new_image_name);
        if(!$upload){
            return response()->json(['status'=>0, 'msg'=>'Something went wrong, try again later']);

        }else {

            $tutor_id = Auth::guard('tutor')->user()->id;
            $tutor_birth_nid_certificate= Certificate::where(['tutor_id' => $tutor_id, 'type' => 'birth_certificate'])->first();
            if ($tutor_birth_nid_certificate)
            {
                if ($tutor_birth_nid_certificate->file_path != null) {
                    unlink($path . $tutor_birth_nid_certificate->file_path);
                }
                $tutor_birth_nid_certificate->file_path = $new_image_name;
                $tutor_birth_nid_certificate->save();

            }else
            {
                $tutor_birth_nid_certificate = new Certificate();
                $tutor_birth_nid_certificate->tutor_id =$tutor_id;
                $tutor_birth_nid_certificate->file_path =$new_image_name;
                $tutor_birth_nid_certificate->type = 'birth_certificate';
                $tutor_birth_nid_certificate->save();

            }

        }
    }
    public function admission_certificate($request)
    {
        $path = 'files/';
        $file = $request->file('u_admission_certificate');
        $new_image_name = 'UIMG'.date('Ymd').uniqid().'.jpg';
        $upload = $file->move(public_path($path), $new_image_name);
        if(!$upload){
            return response()->json(['status'=>0, 'msg'=>'Something went wrong, try again later']);

        }else {

            $tutor_id = Auth::guard('tutor')->user()->id;
            $tutor_admission_certificate= Certificate::where(['tutor_id' => $tutor_id, 'type' => 'admission'])->first();
            if ($tutor_admission_certificate)
            {
                if ($tutor_admission_certificate->file_path != null) {
                    unlink($path . $tutor_admission_certificate->file_path);
                }
                $tutor_admission_certificate->file_path = $new_image_name;
                $tutor_admission_certificate->save();

            }else
            {
                $tutor_admission_certificate = new Certificate();
                $tutor_admission_certificate->tutor_id =$tutor_id;
                $tutor_admission_certificate->file_path =$new_image_name;
                $tutor_admission_certificate->type = 'admission';
                $tutor_admission_certificate->save();

            }

        }
    }
   public function other($request)
    {
        $path = 'files/';
        $file = $request->file('others');
        $new_image_name = 'UIMG'.date('Ymd').uniqid().'.jpg';
        $upload = $file->move(public_path($path), $new_image_name);
        if(!$upload){
            return response()->json(['status'=>0, 'msg'=>'Something went wrong, try again later']);

        }else {

            $tutor_id = Auth::guard('tutor')->user()->id;
            $tutor_other_certificate= Certificate::where(['tutor_id' => $tutor_id, 'type' => 'other'])->first();
            if ($tutor_other_certificate)
            {
                if ($tutor_other_certificate->file_path != null) {
                    unlink($path . $tutor_other_certificate->file_path);
                }
                $tutor_other_certificate->file_path = $new_image_name;
                $tutor_other_certificate->save();

            }else
            {
                $tutor_other_certificate = new Certificate();
                $tutor_other_certificate->tutor_id =$tutor_id;
                $tutor_other_certificate->file_path =$new_image_name;
                $tutor_other_certificate->type = 'other';
                $tutor_other_certificate->save();

            }

        }
    }


}
