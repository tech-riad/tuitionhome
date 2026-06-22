<?php

namespace App\Http\Controllers\Backend\Parent;

use App\Http\Controllers\Controller;
use App\Models\ParentDeactivateNote;
use App\Models\ParentNote;
use App\Models\ParentPersonalInfo;
use App\Models\Parents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ParentActionController extends Controller
{
    public function verifyParent($id)
    {
        $parent = Parents::where('id',$id)->first();

        $parent->is_verified = 1;
        $parent->verify_by = Auth::user()->id;
        $parent->verify_date = now();
        $parent->update();

        return redirect()->route('parent.index')->withMessage( 'Verified Successfully!');



    }
    public function makeSuperParent($id)
    {
        $parent = Parents::where('id',$id)->first();

        $parent->is_super = 1;
        $parent->super_by = Auth::user()->id;
        $parent->super_date = now();
        $parent->update();

        return redirect()->route('parent.index')->withMessage( 'Make Parent Super Successfully!');



    }
    public function makeUnplesantParent($id)
    {
        $parent = Parents::where('id',$id)->first();

        $parent->is_unplesant = 1;
        $parent->unplesant_by = Auth::user()->id;
        $parent->unplesant_date = now();
        $parent->update();

        return redirect()->route('parent.index')->withMessage( 'Make Parent Unplesant Successfully!');



    }
    public function deactiveParent(Request $request, $id)
    {
        try {
            // Find the parent by ID
            $parent = Parents::where('id',$id)->first();



            if ($request->status == 0) {
                $parent->is_active = 0;
                $parent->is_sms = 0;
                $parent->deactive_date = now();
                $parent->deactive_by = Auth::user()->id;
                $parent->update();

            } else {
                $parent->is_active = 1;
                $parent->is_sms = 1;
                $parent->update();

            }



            // Save the reason for the status change
            $deactivateNote = new ParentDeactivateNote();
            $deactivateNote->parent_id = $parent->id;
            $deactivateNote->note = $request->changed_note;
            $deactivateNote->action = $request->status;
            $deactivateNote->action_by = Auth::user()->name;
            $deactivateNote->save();

            // Return a JSON response indicating success
            return response()->json([
                'success' => true,
                'message' => 'Parent status updated successfully.'
            ]);
        } catch (\Exception $e) {
            // If there's any error, catch it and return a failure response
            return response()->json([
                'success' => false,
                'message' => 'Error updating parent status: ' . $e->getMessage()
            ], 500);
        }
    }
    public function createNote(Request $request, $id)
    {
        try {
            // Validate the incoming data
            $request->validate([
                'note_title' => 'required|max:50',
                'note_details' => 'required|max:255',
            ]);

            // Create the note
            $note = new ParentNote();
            $note->parents_id = $id;
            $note->note_title = $request->note_title;
            $note->body = $request->note_details;
            $note->created_by = Auth::user()->id;
            $note->save();

            return response()->json([
                'success' => true,
                'message' => 'Note created successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating note: ' . $e->getMessage()
            ], 500);
        }
    }
    public function fetchNoteByParentId($id)
    {
        try {
            $notes = ParentNote::where('parents_id', $id)->get();

            if ($notes->isNotEmpty()) {
                $formattedNotes = [];

                foreach ($notes as $note) {
                    $formattedNotes[] = [
                        'created_by' => $note->noteBy->name,
                        'created_by_id' => $note->created_by,
                        'created_at' => \Carbon\Carbon::parse($note->created_at)->format('d M Y, H:i'),
                        'title' => $note->note_title,
                        'details' => $note->body,
                    ];
                }

                return response()->json([
                    'success' => true,
                    'notes' => $formattedNotes
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'No notes found for this parent.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error fetching notes: ' . $e->getMessage()], 500);
        }
    }

    public function newParentCreate(Request $request)
    {
        try {
            // Validation
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|regex:/^\d{11}$/|unique:parents',
                'email' => 'nullable|email|unique:parents,email',
                'gender' => 'required|string',
            ]);

            $parent = new Parents();
            $parent->name = $validatedData['name'] ?? 'Anonymous Parent';
            $parent->phone = $validatedData['phone'];
            $parent->email = $validatedData['email'];
            // $parent->gender = $validatedData['gender'];
            $parent->password = bcrypt('12345678');
            $parent->phone_verified_at = now();
            $parent->save();
            $parent->get_parent_unique_id();

            $parentInfo = new ParentPersonalInfo();
            $parentInfo->parents_id = $parent->id;
            $parentInfo->gender = $validatedData['gender'];
            $parentInfo->save();
            return response()->json([
                'success' => true,
                'message' => 'Parent created successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function inactiveParent()
    {
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
        ->where('is_active',0)->orderBy('id', 'desc')->paginate(25);
        return view('backend.parents.inactive', compact('active_parent_count','deactive_parent_count','parents','all_parent_count','male_parent_count','female_parent_count'));


    }




}
