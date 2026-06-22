<?php

namespace App\Http\Controllers\Backend\PendingApproval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institute;
use App\Models\Tutor;
use App\Models\TutorEducation;
use App\Models\TutorTypeUniversity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ItemNotFoundException;

class InstituteApproveController extends Controller
{
    //

    public function index (){

        $instituties = Institute::orderBy('id','desc')->take(10)->get();
        $Tutor_universities = TutorTypeUniversity::orderBy('id','desc')->paginate(100);
        foreach($Tutor_universities as $Tutor_university){

            if($Tutor_university->is_approved == 0)
        {
            $Tutor_university->is_approved = "pending" ;
        }
        else{
            $Tutor_university->is_approved = "Approved" ;

        }
        }

        return view('backend.pending_approval.institute_approve.index', compact('instituties','Tutor_universities'));

    }

    public function approve($institute)
    {

        $pending_institute_data = TutorTypeUniversity::where('id', $institute)->firstOrFail();




            $degree_name         = $pending_institute_data->degree_name;
            $title               = $pending_institute_data->university;
            $institutes          = Institute::all();
            $foundMatch          = $institutes->contains('title', $title);

            if ($foundMatch) {
                return response()->json(['status' => false, 'message' => 'Institute already exists!']);

            } else {
                $institute            = new Institute();
                $institute->title     = $title;
                $institute->approved  = '1';
                $institute->action_by  = Auth::user()->id;
                if($degree_name == "ssc"){
                    $institute->type = 'school';
                }
                elseif($degree_name == "hsc"){
                    $institute->type = 'college';
                }
                elseif($degree_name == "honours"){
                    $institute->type = 'university';
                }
                else{
                    $institute->type = 'university';
                }
                $institute->save();
            }


            $pending_institute_data->is_approved = "1";
            $pending_institute_data->update();


            $tutor_institute_data = Institute::where('title', $title)->first();
            if ($tutor_institute_data) {
                $tutor_institute_id = $tutor_institute_data->id;
                $tutor_institute_title = $tutor_institute_data->title;
                $tutor_institute_type = $tutor_institute_data->type;


            } else {
                return null;
            }


            if($tutor_institute_data ){
                return redirect()->back()->withMessage('Institute already exists');
             }else{

                $institute->save();
                 $pending_institute_data->save();

                 $institute_id = Institute::orderBy('id', 'desc')->pluck('id')->first();
                //  dd($institute_id);


                 $tutor_id = $pending_institute_data->tutor_id;
                 $degree_name = $pending_institute_data->degree_name;
                 $tutor_education = TutorEducation::where('tutor_id',$tutor_id)
                 ->where('degree_name',$degree_name)
                 ->first();



                  dd($tutor_education->institute_id);

                  $tutor_education->institute_id = $institute_id;

                  $tutor_education->update();


                 return redirect()->back()->withMessage('Success! Institute has been successfully approved');

             }





    }
    public function edit($institute)
    {
        $institute_data= TutorTypeUniversity::where('id', $institute)->firstOrFail();

        return response()->json([
            'status'=>200,
            'institute'=>$institute_data,
        ]);
    }
    public function update(Request $request){
        $institute_data=$request->all();
        //  dd($institute_data);
        $id = $institute_data['id'];
        $institute= TutorTypeUniversity::where('id', $id)->firstOrFail();
        $institute->update($institute_data);
        return redirect()->route('admin.approve.institute')->withMessage('institute Data Updated Successfully');

    }

    public function search(Request $request){

        $search = $request->input;

        $instituties = Institute::where('title', 'LIKE', '%'.$search.'%')
            ->take(10)->get();

        return response()->json([
                'instituties'=>$instituties,
            ]);
    }

    public function includeUnderOldInstitute(Request $request){

        try{
        $tutor_id = $request->tutor_id;
        $institute_id = $request->institute_id;
        $institute_data= Institute::where('id', $institute_id)->firstOrFail();
        $pending_institute_data= TutorTypeUniversity::where('tutor_id', $tutor_id)->firstOrFail();

        // return $pending_institute_data;

        $tutor_education = TutorEducation::where([
            'tutor_id' => $tutor_id,
            'degree_name' =>$pending_institute_data->degree_name,
         ])->firstOrFail();


         if($tutor_education){

            $tutor_education->tutor_id = $tutor_id;
            $tutor_education->institute_id = $institute_id;
            $tutor_education->degree_name = $pending_institute_data->degree_name;
            $tutor_education->save();
         }
         else{

            $tutor_education = new TutorEducation();
            $tutor_education->tutor_id = $tutor_id;
            $tutor_education->institute_id = $institute_id;
            $tutor_education->degree_name = $pending_institute_data->degree_name;
            $tutor_education->save();
         }


         $pending_institute_data->delete();


             return response()->json([
            'status' =>"institute include successfully",
         ]);


        }
        catch(\Exception $exception){

            $pending_institute_data->delete();

            return response()->json([
            'status' =>"institute Already included",
        ]);

        }
    }

    public function delete($institute){

        // dd($parent);
        $panding_institute = TutorTypeUniversity::find($institute);
        $panding_institute->delete();
       return Redirect()->back();
    }

}
