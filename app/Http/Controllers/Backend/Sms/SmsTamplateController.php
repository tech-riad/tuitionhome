<?php

namespace App\Http\Controllers\Backend\Sms;

use App\Http\Controllers\Controller;
use App\Models\SendSms;
use App\Models\SendSmsLog;
use App\Models\SmsTamplate;
use App\Models\SmsTemplateLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// use PhpParser\Node\Stmt\Echo_;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Http;


class SmsTamplateController extends Controller
{
    public function filter(Request $request){

        $input= $request->searchInput;

        // dd($input);

        if($request->searchInput ==null){
            $input = "emp_id='1'";
        }

        $query = 'select id from send_sms where '.$input;
        $send_sms_id = DB::select($query);

        $s_id = [];
        $i=0;

         foreach($send_sms_id as $key =>$sms_id){

            $s_id[$key] = $sms_id->id;

        }


        $smsLogs = SendSms::whereIn('id', $s_id)->paginate(10);


        //  dd($request->toArray());

        // $smsLogs = SendSms::where('emp_id', $request->emp_id)
        // ->orWhere('sender_number', $request->sender_number)
        // ->orWhere('body', $request->sms_body)
        // ->orWhere('created_at', $request->created_at)
        // ->orderBy('id', 'desc')
        // ->get();



        return view('backend.sms.sms_log', compact('smsLogs'));






    }

    public function showSmsLog($log){


        $log = SendSms::where('id', $log)->first();

        //  dd($log->toarray());

        return view('backend.sms.show_sms_log' ,compact('log'));


    }

    public function smsLog(){

        $smsLogs = SendSms::with('employee')->orderBy('id', 'desc')->paginate(10);


        // dd($smsLogs);
        return view('backend.sms.sms_log', compact('smsLogs'));


    }



    public function smsSend(Request $request)
    {
        try {
            $request->validate([
                'sender_number' => 'required',
                'sms_body' => 'required|max:560',
            ]);

            $numbers = preg_split('/[\s,!]+/', $request->sender_number);
            $length = count($numbers);

            // dd(request()->all());

            foreach ($numbers as $phoneNumber) {
                $sms = new SendSms();
               $sms->emp_id = Auth::user()->id;
               $sms->body = $request->sms_body;
               $sms->sender_number = $phoneNumber;
               $sms->save();

            }



            // $sms_log = new SendSmsLog();
            // $sms_log->emp_id = Auth::user()->id;
            // $sms_log->body = $request->sms_body;
            // $sms_log->sender_number = $request->sender_number;
            // $sms_log->save();

            // return response()->json(['status' => 'success', 'message' => 'SMS sent successfully']);


            return redirect()->back()->withMessage('Success! SMS sent successfully');
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }

    }



    public function resendSms(Request $request)
    {

        $numbers  = $request->sender_number;
        $pattern  = '/[\s,!]+/';
        $number   = preg_split($pattern, $numbers);
        $length   = count($number);

        for ($i = 0; $i < $length; $i++) {
            $phone_number  = $number[$i];
            $message       = $request->sms_body;

            $cURLConnection  = curl_init();
            $url             = 'https://easybulksmsbd.com/sms/api?action=send-sms&api_key=VHVpdGlvbiBUZXJtaW5hbDoxMjM0NTY3&to='.'88'.$phone_number.'&from=SenderID&sms='.$message;
            curl_setopt($cURLConnection, CURLOPT_URL, $url);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
            $res = curl_exec($cURLConnection);
            // return $res;
            curl_close($cURLConnection);
        }

        $sms = SendSms::updateOrCreate(
            ['id' => $request->sms_id],
            [
                'body' => $request->sms_body,
                'emp_id' => $request->emp_id,
                'sender_number' => $length == 1 ? $number[0] : implode(',', $number),
                'title_id' => $request->title_id,
                'updated_by' => Auth::user()->id,
            ]
        );

        $smsLog = SendSmsLog::UpdateOrCreate(
            ['id' => $request->sms_id],
            [
                'body' => $request->sms_body,
                'emp_id' => $request->emp_id,
                'sender_number' => $length == 1 ? $number[0] : implode(',', $number),
                'title_id' => $request->title_id,
                'updated_by' => Auth::user()->id,
            ]
    );

        return redirect()->route('admin.sms.log')->withMessage('Success! Resend Successfull!');
    }


    public function temChange(Request $request){

        $template = SmsTamplate::where('id', $request->id)->first();


        return response()->json([
            'status'=>true,
            'template'=>$template,
        ]);





    }
    public function bulkSms() {
        $auth_id       = Auth::user()->id;
        $templates     = SmsTamplate::where('user_id', $auth_id)->get();
        $all_templates = SmsTamplate::orderBy('id', 'desc')->get();

        return view('backend.sms.bulk_sms', compact('templates','all_templates'));
    }
    public function smsLogDelete($sms){

        $sms= SendSms::where('id', $sms)->firstOrFail();
        $sms->delete();
        return redirect()->back();
    }
    public function delete($sms){

        $sms= SmsTamplate::where('id', $sms)->firstOrFail();
        $sms->delete();
        return redirect()->back();
    }

    public function update(Request $request){


        $validator = Validator::make($request->all(),[
            'user_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['status'=>false,'error'=>$validator->errors()]);
        }


        $tamplate = SmsTamplate::where('id', $request->id)->firstOrFail();
        $tamplate->user_id = $request->user_id;
        $tamplate->title = $request->title;
        $tamplate->description = $request->description;
        $tamplate->updated_by = Auth::user()->name;
        $tamplate->update();


        $tamplate_log = SmsTemplateLog::where('id', $request->id)->firstOrFail();
        $tamplate_log->user_id = $request->user_id;
        $tamplate_log->title = $request->title;
        $tamplate_log->description = $request->description;
        $tamplate_log->updated_by = Auth::user()->name;
        $tamplate_log->update();


        return response()->json([
            'status'=>true,
        ]);

        // dd($request->toArray());



    }
    public function edit(Request $request){

        $id = $request->id;

        $sms= SmsTamplate::where('id', $id)->firstOrFail();

        return response()->json([
            'status'=>true,
            'sms'=>$sms,
        ]);


    }
    //
    public  function index(){

        $employees = User::orderBy('id', 'desc')->get();

        $all_sms = SmsTamplate::orderBy('id', 'desc')->paginate(10);

        return view('backend.sms.index', compact('employees','all_sms'));

    }
    public  function searchSms(Request $request){

        $employees = User::orderBy('id', 'desc')->get();

        $all_sms = SmsTamplate::where('user_id', $request->user_id)
        ->orderBy('id', 'desc')
        ->paginate(10);
        return view('backend.sms.index', compact('employees','all_sms'));

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'user_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['status'=>false,'error'=>$validator->errors()]);
        }

        $tamplate = new SmsTamplate();
        $tamplate->user_id = $request->user_id;
        $tamplate->title = $request->title;
        $tamplate->description = $request->description;
        $tamplate->save();

        $tamplate_log = new SmsTemplateLog();
        $tamplate_log->user_id = $request->user_id;
        $tamplate_log->title = $request->title;
        $tamplate_log->description = $request->description;
        $tamplate_log->save();

        // dd($request->toArray());

    }


}
