<?php

namespace App\Http\Controllers\Backend\CategoryTutorRequest;

use App\Http\Controllers\Controller;
use App\Models\HiringRequest;
use App\Models\HiringRequestNote;
use App\Models\Parents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryTutorRequestController extends Controller
{
    public function index()
    {

        $catRequest = HiringRequest::whereNotNull('category_id')->orderBy('id','desc')->paginate(10);

        return view('backend.category_request.index',compact('catRequest'));
    }

    public function catRequestReject(Request $request ,$id)
    {
        $catRequest = HiringRequest::where('id',$id)->first();
        $catRequest->status = 'rejected';
        $catRequest->added_by = Auth::user()->id;
        $catRequest->update();

        return redirect()->back()->with('success','Reject Successfully');
    }

    public function tutorRequest()
    {
        $tutorRequest = HiringRequest::whereNotNull('tutor_id')->orderBy('id','desc')->paginate(10);

        // dd($tutorRequest);
        return view('backend.category_request.tutor_request',compact('tutorRequest'));
    }

    public function catRequestNoteAdd(Request $request, $id)
    {
        $validated = $request->validate([
            'note' => 'required|string|max:1000',
            'note_type' => 'nullable|string',
        ]);

        $note = new HiringRequestNote();
        $note->lead_id = $id;
        $note->note_type = 'parent_note';
        $note->added_by = auth()->id();
        $note->parent_id = $request->input('parent_id');
        $note->note = $validated['note'];
        $note->save();

        return response()->json(['success' => true, 'message' => 'Note added successfully']);
    }
    public function catRequestNoteAddAdmin(Request $request, $id)
    {
        $validated = $request->validate([
            'note' => 'required|string|max:1000',
            'note_type' => 'nullable|string',
        ]);

        $note = new HiringRequestNote();
        $note->lead_id = $id;
        $note->note_type = 'admin_note';
        $note->added_by = auth()->id();
        $note->parent_id = $request->input('parent_id');
        $note->note = $validated['note'];
        $note->save();

        return response()->json(['success' => true, 'message' => 'Note added successfully']);
    }
    public function catRequestFilter(Request $request)
    {
        $searchCriteria = $request->input('cat_filter');
        $paginationLimit = $request->input('pagination_limit', 50);

        if (!$searchCriteria) {
            $searchCriteria = "1";
        }


        $searchCriteria = str_replace('==', '=', $searchCriteria);

        $query = "SELECT id FROM hiring_requests WHERE $searchCriteria";

        try {
            $catIds = DB::select($query);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $catIds = array_column($catIds, 'id');
        $catRequest = HiringRequest::whereIn('id', $catIds)
                    ->whereNotNull('category_id')
                    ->orderBy('id','desc')
                    ->paginate(30);

        return view('backend.category_request.index',compact('catRequest'));



    }
    public function tutorRequestFilter(Request $request)
    {
        // dd($request->all());
        $searchCriteria = $request->input('tutor_filter');
        $paginationLimit = $request->input('pagination_limit', 50);

        if (!$searchCriteria) {
            $searchCriteria = "1";
        }


        $searchCriteria = str_replace('==', '=', $searchCriteria);

        $query = "SELECT id FROM hiring_requests WHERE $searchCriteria";

        try {
            $catIds = DB::select($query);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $catIds = array_column($catIds, 'id');



        $tutorRequest = HiringRequest::whereIn('id', $catIds)
                        ->whereNotNull('tutor_id')
                        ->orderBy('id','desc')
                        ->paginate(30);
        return view('backend.category_request.tutor_request',compact('tutorRequest'));



    }

    public function tutorRequestSearch(Request $request)
    {
        $parent = Parents::where('phone',$request->search)->first();

        $tutorRequest = HiringRequest::where('parent_id', $parent->id)
                        ->whereNotNull('tutor_id')
                        ->orderBy('id','desc')
                        ->paginate(30);
        return view('backend.category_request.tutor_request',compact('tutorRequest'));


    }
    public function catRequestSearch(Request $request)
    {
        $parent = Parents::where('phone',$request->search)->first();
        $catRequest = HiringRequest::where('parent_id', $parent->id)
                    ->whereNotNull('category_id')
                    ->orderBy('id','desc')
                    ->paginate(30);

        return view('backend.category_request.index',compact('catRequest'));


    }


}
