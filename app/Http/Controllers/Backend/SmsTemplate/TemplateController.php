<?php

namespace App\Http\Controllers\Backend\SmsTemplate;

use App\Http\Controllers\Controller;
use App\Models\VSmsTemplate;
use App\Models\VSmsTemplateLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class TemplateController extends Controller
{
    public function index(){


        $templates = VSmsTemplate::orderBy('id', 'desc')->paginate(15);


        return view('backend.sms_template.index',compact('templates'));


    }

    public function edit(Request $request){

        $id = $request->id;
        $sms= VSmsTemplate::where('id', $id)->firstOrFail();

        return response()->json([
            'status'=>true,
            'sms'=>$sms,
        ]);


    }


    public function update(Request $request){


        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['status'=>false,'error'=>$validator->errors()]);
        }


        $tamplate = VSmsTemplate::where('id', $request->id)->firstOrFail();
        $tamplate->title = $request->title;
        $tamplate->body = $request->body;
        $tamplate->updated_by = Auth::user()->name;
        $tamplate->update();


        $tamplate_log = VSmsTemplateLog::where('id', $request->id)->firstOrFail();
        $tamplate_log->title = $request->title;
        $tamplate_log->body = $request->body;
        $tamplate_log->updated_by = Auth::user()->name;
        $tamplate_log->update();


        return response()->json([
            'status'=>true,
            'message'=>'Data Updated Successfully'

        ]);

        // dd($request->toArray());



    }

    public function show($template){

        $template = VSmsTemplate::where('id', $template)->first();

        return view('backend.sms_template.show' ,compact('template'));


    }

    public function delete($template){

        $template= VSmsTemplate::where('id', $template)->firstOrFail();
        $template->delete();
        return redirect()->back();
    }


    public function store(Request $request){


        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'body' => 'required|max:560',
        ]);

        if ($validator->fails())
        {
            return response()->json(['status'=>false,'error'=>$validator->errors()]);
        }


        $tamplate = new VSmsTemplate();
        $tamplate->title = $request->title;
        $tamplate->body = $request->body;
        $tamplate->save();

        $tamplate_log = new VSmsTemplateLog();
        $tamplate_log->title = $request->title;
        $tamplate_log->body = $request->body;
        $tamplate_log->save();


        return response()->json([
            'status'=>true,
            'message'=>'Data Added Successfully'
        ]);
        // dd($request->toArray());



        // return view('backend.sms_template.index');


    }
}
