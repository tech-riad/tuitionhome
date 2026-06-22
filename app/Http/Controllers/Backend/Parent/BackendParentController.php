<?php

namespace App\Http\Controllers\Backend\Parent;

use App\Http\Controllers\Controller;
use App\Imports\ParentImport;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Course;
use App\Models\Institute;
use App\Models\Location;
use App\Models\ParentAlertNote;
use Illuminate\Http\Request;
use App\Models\Parents;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\ParentLog;
use App\Models\ParentNote;
use App\Models\ParentPersonalInfo;
use App\ParentsModule\ParentsPersonalInfoUpdate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BackendParentController extends Controller
{

    public function smsStatus(Request $request)
    {
        $parent            = Parents::find($request->id);
        $parent->is_sms    = $parent->is_sms === 1 ? 0 : 1;
        $parent->save();
        return response()->json(['status'=>'success','message'=> 'Send Sms Status Change']);
    }
    public function passwordUpdates(Request $request, $id)
    {
        $parent = Parents::find($id);

        if (!$parent) {
            return response()->json(['status' => 'error', 'message' => 'Parent not found.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $parent->password = Hash::make($request->new_password);
        $parent->save();

        return response()->json(['status' => 'success', 'message' => 'Password updated successfully.']);
    }
    public function kidInfo(Request $request, $id)
    {
        try {

            $parentInfo = ParentPersonalInfo::where('parents_id', $id)->first();

            if (!$parentInfo) {
                return response()->json(['status' => 'error', 'message' => 'Parent not found'], 404);
            }

            $parentInfo->update($request->all());

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            // \Log::error($e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 500);
        }
    }
    public function contactInfo(Request $request, $id)
    {
        try {
            $request->validate([
                'gender' => 'required|in:male,female',
                'date_of_birth' => 'required|date',
                'profession' => 'required|string',
                'about_us' => 'required|string',
            ]);

            $parentInfo = ParentPersonalInfo::where('parents_id', $id)->first();

            if (!$parentInfo) {
                return response()->json(['status' => 'error', 'message' => 'Parent not found'], 404);
            }

            $parentInfo->update($request->all());

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 500);
        }
    }

    public function personalDeatils(Request $request, $id)
    {
        try {

            $parent = ParentPersonalInfo::where('parents_id', $id)->first();

            if (!$parent) {
                return response()->json(['status' => 'error', 'message' => 'Parent not found'], 404);
            }

            $parent->update($request->all());

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            // \Log::error($e->getMessage());  // Log the error for debugging
            return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 500);
        }
    }



    public function updateEmail(Request $request, $id)
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:parents,email,' . $id],
        ]);

        try {
            $parent = Parents::findOrFail($id);
            $parent->email = $request->email;
            $parent->save();

            return response()->json(['success' => true, 'message' => 'Email updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Failed to update email'], 500);
        }
    }

    public function updatePhone(Request $request, $id)
    {
        $request->validate([
            'phone' => ['required', 'regex:/^[0-9]{11}$/', 'unique:parents,phone,'.$id],

        ]);

        try {
            $parent = Parents::findOrFail($id);
            $parent->phone = $request->phone;
            $parent->save();

            return response()->json(['success' => true, 'message' => 'Phone number updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Failed to update phone number'], 500);
        }
    }


    public function updateName(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $parent = Parents::findOrFail($id);
            $parent->name = $request->name;
            $parent->save();

            return response()->json(['success' => true, 'message' => 'Name updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Failed to update name'], 500);
        }
    }

    public function accountStatus($id)
    {
        $parent = parents::with([
            'parents_personalInfo',
            'parentsNote',
        ])->where('id',$id)->first();
        return view('backend.parents.edit.accountstatus',compact('parent'));
    }
    public function passwordUpdate($id)
    {
        $parent = parents::with([
            'parents_personalInfo',
            'parentsNote',
        ])->where('id',$id)->first();
        return view('backend.parents.edit.passwordchange',compact('parent'));
    }
    public function otherInfo($id)
    {
        $countries = Country::all();
        $cities = City::all();
        $locations = Location::all();
        $categories = Category::all();
        $institutes = Institute::all();
        $courses = Course::all();
        $parent = parents::with([
            'parents_personalInfo',
            'parentsNote',
        ])->where('id',$id)->first();
        return view('backend.parents.edit.otherinfo',compact('courses','institutes','categories','locations','cities','countries','parent'));
    }
    public function editParent($id)
    {
        $parent = parents::with([
            'parents_personalInfo',
            'parentsNote',
        ])->where('id',$id)->first();
        return view('backend.parents.edit.signupinfo',compact('parent'));
    }
    public function viewParent($id)
    {
        $parent = parents::with([
            'parents_personalInfo',
            'parentsNote',
        ])->where('id',$id)->first();
        return view('backend.parents.about_parent',compact('parent'));
    }



    public function getNote(Request $request){


        // return 'tamim';
        $id = $request->id;
        $notes = ParentNote::where('parents_id', $id)->orderBy('id', 'desc')->get();



        return response()->json([
            'status'=>true,
            'message'=>'note added Successfully!',
            'data' =>$notes]);
    }

    // public function show($parent){


    //     $parent = parents::with([
    //         'parents_personalInfo',
    //         'parentsNote',
    //     ])->where('id',$parent)->first();

    //     // dd($parent->toArray());


    // }


    public function parentNote(Request $request){


        $note = new ParentNote();
        $note->body = $request->note;
        $note->parents_id = $request->parent_id;
        $note->created_by = Auth::user()->name;
        $note->save();

        return response()->json([
            'status'=>true,
            'message'=>'note added Successfully!',
            'data' =>$note]);

    }

    public function smsOnOff(Request $request){




        return response()->json(['message'=>'tamim']);




    }

    public function search(Request $request)
    {


        $input = $request['search'] ?? 50;


        $active_parent_count = Parents::where('is_active', 1)->count();
        $deactive_parent_count = Parents::where('is_active', 0)->count();
        $all_parent_count = DB::table('parents')->count();
        $male_parent_count = ParentPersonalInfo::where('gender', 'male')->count();
        $female_parent_count = ParentPersonalInfo::where('gender', 'female')->count();

          $parents= Parents::with([
            'parents_personalInfo',
        ])->where('id', $input)
        ->orwhere('unique_id', $input)
        ->orwhere('phone',  $input)
        ->orwhere('additional_phone',  $input)
        ->orderBy('id', 'desc')->paginate(50);


        return view('backend.parents.index', compact('deactive_parent_count','active_parent_count','parents','all_parent_count','male_parent_count','female_parent_count','input'));


    }


    public function create(){

        return view('backend.parents.create');

    }

    public function index(Request $request){

        $input = $request->input('pagination_limit') ?? 50;
        $all_parent_count = DB::table('parents')->count();
        $male_parent_count = ParentPersonalInfo::where('gender', 'male')->count();
        $female_parent_count = ParentPersonalInfo::where('gender', 'female')->count();
        $active_parent_count = Parents::where('is_active', 1)->count();
        $deactive_parent_count = Parents::where('is_active', 0)->count();

        $parents= Parents::with([
            'parents_personalInfo',
            'parentsNote',
            'activeDeactiveParentNote',
        ])
        ->where('is_active',1)->orderBy('id', 'desc')->paginate($input);
        return view('backend.parents.index', compact('input','active_parent_count','deactive_parent_count','parents','all_parent_count','male_parent_count','female_parent_count'));

    }
    public function edit($parent){
        $parent= Parents::where('id', $parent)->firstOrFail();

        return response()->json([
            'status'=>200,
            'parent'=>$parent,
        ]);
    }

    public function Store(Request $request)
    {
        $validator = Validator()->make($request->all(),[
            'name' => 'required',
            'phone'=> 'required|regex:/(01)[0-9]{9}/|unique:parents',
            'password' => 'required|min:6',
            'confirm_password' =>'same:password'
        ]);

        if ($validator->fails())
        {
            return response()->json(['status'=>false,'error'=>$validator->errors()]);
        }
//        $data = $request->all();
        $parent = new Parents();
        $parent->name = $request->name;
        $parent->phone = $request->phone;
        $parent->email = $request->email;
        $parent->password = Hash::make($request->password);
        $parent->otp = rand(1234,9999);
        $parent->get_parent_unique_id();
        $parent->save();
        $parent_log =  new ParentLog();
        $parent_log->parents_id = $parent->id;
        $parent_log->name = $request->name;
        $parent_log->phone = $request->phone;
        $parent_log->save();


        // return response()->json([
        //     'status'=>true,
        //     'message'=>'Registration Successfully!',
        //     'data' =>$parent]);
        return redirect()->route('parent.index')->withMessage( 'Registration Successfully!');
    }


    public function update(Request $request){
        // dd($request->all());

        $parentdata=$request->all();
        $id = $parentdata['parent_id'];
        $parent= Parents::where('id', $id)->firstOrFail();
        $parent->additional_phone = $request->additional_phone;

        $parent->update($parentdata);
        return redirect()->route('parent.index')->withMessage('Parent Data Updated Successfully');

    }


    public function destroy($parent){

        // dd($parent);
        $parent = Parents::find($parent);
        $parent->delete();
       return Redirect()->route('parent.index');

    }


    public function VerifyPhone(Request $request)
    {
        $validator = Validator()->make($request->all(),[
            'phone_otp' => 'required|numeric',
            // 'id' => 'required'
        ]);
        if ($validator->fails())
        {
            return response()->json(['status'=>false,'error'=>$validator->errors()]);
        }
        $check_Otp = Parents::find($request->id);
        if ($check_Otp->phone_verified_at == null)
        {
            if ($check_Otp->otp == $request->phone_otp)
            {
                $check_Otp->phone_verified_at =now();
                $check_Otp->save();
                return response()->json(['status'=>true,'message'=>'Phone verified successfully!']);
            }else
            {
                return response()->json(['status'=>false,'error'=>'your otp is invalid!']);
            }
        }else
        {
            return response()->json(['status'=>false,'error'=>'your Phone Number Already Verified! ']);
        }

    }


    public function sendSms(Request $request){


        dd($request->toArray());

    }

    public function smsEditor(Request $request){

        $ids = $request['all_id'];
        $myArray = explode(',', $ids);
        $phonenumbers = DB::table('parents')->whereIn('id', $myArray)->pluck('phone')->toArray();
        $numbers = implode(',', $phonenumbers);

        return view('backend.parents.smsEditor', compact('phonenumbers' , 'numbers'));
    }

    public function singleSms($parent){
        $parent = explode(',', $parent);
        $phonenumbers = DB::table('parents')->whereIn('id', $parent)->pluck('phone')->toArray();
        $numbers = implode(',', $phonenumbers);
        return view('backend.parents.smsEditor', compact('phonenumbers' , 'numbers'));
    }


    public function makeAlert(Request $request, $parent)
    {
        $parent= Parents::where('id',$parent)->first();
        $parent->is_alerted = 1;
        $parent->alerted_date = now();
        $parent->alerted_by = auth()->user()->id;

        $parent->save();

        $parentNote = new ParentAlertNote();

        $parentNote->parent_id = $parent->id;
        $parentNote->changed_note = $request->changed_note;
        $parentNote->changed_by = Auth::user()->id;
        $parentNote->status = 1;

        $parentNote->save();

        return redirect()->route('parent.index')->withMessage('Success! parent marked as alerted parent successfully');

    }

    public function undoAlert(Request $request, $parent)
    {
        $parent= Parents::where('id',$parent)->firstOrFail();
        $parent->is_alerted = 0;
        $parent->alerted_date =null;
        $parent->alerted_by = null;

        $parent->save();

        $parentNote = new ParentAlertNote();

        $parentNote->parent_id = $parent->id;
        $parentNote->changed_note = $request->changed_note;
        $parentNote->undo_by = Auth::user()->id;
        $parentNote->status = 0;

        $parentNote->save();
        return redirect()->route('parent.index')->withMessage('Success! parent marked as regular parent successfully');

    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new ParentImport, $request->file('file'));

        return redirect()->back()->with('success', 'File imported successfully!');
    }
    public function filterParent(Request $request)
    {
        // dd($request->all());
        $all_parent_count = DB::table('parents')->count();
        $male_parent_count = ParentPersonalInfo::where('gender', 'male')->count();
        $female_parent_count = ParentPersonalInfo::where('gender', 'female')->count();
        $active_parent_count = Parents::where('is_active', 1)->count();
        $deactive_parent_count = Parents::where('is_active', 0)->count();



        $input = $request->input('pagination_limit') ?? 50;

        $countryId              = $request->country_id;
        $cityId                 = $request->city_id;
        $locationId             = $request->location_id;
        $dateFrom               = $request->datef;
        $dateTo                 = $request->datet;
        $gender                 = $request->gender;
        $profession             = $request->profession;
        $kids                   = $request->kids;

        $parentsQuery= Parents::with([
            'parents_personalInfo',
            'parentsNote',
            'activeDeactiveParentNote',
        ]);


        if ($request->input('parent_type') == 'is_verified') {
            $parentsQuery->where('is_verified', 1);
        }
        if ($request->input('parent_type') == 'is_active') {
            $parentsQuery->where('is_active', 1);
        }
        if ($request->input('parent_type') == 'is_inactive') {
            $parentsQuery->where('is_active', 0);
        }
        if ($request->input('parent_type') == 'is_unplesant') {
            $parentsQuery->where('is_unplesant', 1);
        }
        if ($request->input('parent_type') == 'is_super') {
            $parentsQuery->where('is_super', 1);
        }
        if ($countryId !== null) {
            $parentsQuery->whereHas('parents_personalInfo', function ($subQuery) use ($countryId) {
                $subQuery->where('country_id', $countryId);
            });
        }
        if ($cityId !== null) {
            $parentsQuery->whereHas('parents_personalInfo', function ($subQuery) use ($cityId) {
                $subQuery->where('city_id', $cityId);
            });
        }
        if ($locationId !== null) {
            $parentsQuery->whereHas('parents_personalInfo', function ($subQuery) use ($locationId) {
                $subQuery->where('location_id', $locationId);
            });
        }
        if ($gender !== null) {
            $parentsQuery->whereHas('parents_personalInfo', function ($subQuery) use ($gender) {
                $subQuery->where('gender', $gender);
            });
        }
        if ($profession !== null) {
            $parentsQuery->whereHas('parents_personalInfo', function ($subQuery) use ($profession) {
                $subQuery->where('profession', $profession);
            });
        }
        if ($kids !== null) {
            $parentsQuery->whereHas('parents_personalInfo', function ($subQuery) use ($kids) {
                $subQuery->where('children_number', $kids);
            });
        }
        if ($dateFrom !== null) {
            if ($dateTo === null) {
                $dateTo = now()->toDateString();
            }

            $parentsQuery->whereBetween('created_at', [$dateFrom, $dateTo]);
        }



        $parents = $parentsQuery->orderBy('id', 'desc')
                               ->paginate($input);



        return view('backend.parents.index', compact('input','active_parent_count','deactive_parent_count','parents','all_parent_count','male_parent_count','female_parent_count'));

    }

    public function additionalNote(Request $request)
    {
        $request->validate([
            'parent_id' => 'required|exists:parents,id',
            'parent_manage_note' => 'nullable|string|max:1000',
        ]);

        $parent = Parents::find($request->parent_id);
        $parent->parent_manage_note = $request->parent_manage_note;
        $parent->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Note updated successfully.'
        ]);
    }




}