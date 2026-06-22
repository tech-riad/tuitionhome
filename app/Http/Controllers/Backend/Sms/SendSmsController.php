<?php

namespace App\Http\Controllers\Backend\Sms;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SendSmsController extends Controller
{
    public function applicantSend(Request $request)
    {
        $ids = $request['tutor_ids'];
        $job_id = $request->job_id;
        $ids = explode(',', $ids);
        $tutors= Tutor::whereIn('id',$ids)->get();
        $phonenumbers = [];
        foreach($tutors as $utor){
            $phonenumbers[] = $utor->phone;
        }
        $numbers = implode(',', $phonenumbers);
        return view('backend.tutor.smsEditor', compact('numbers','tutors','job_id'));
    }
}
