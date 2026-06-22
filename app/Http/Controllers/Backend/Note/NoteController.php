<?php

namespace App\Http\Controllers\Backend\Note;

use App\Http\Controllers\Controller;
use App\Models\AppliedNoteLog;
use App\Models\AppliedTutorNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    // tutor applied page note
    public function applliedNote(Request $request)
    {

        $noteCheck = AppliedTutorNote::where('job_application_id', $request->id)->get();

        if ($noteCheck->isNotEmpty()) {
            // Record exists, update it
            $note = $noteCheck->first();
            $note->description = $request->description;
            $note->user_id = Auth::id();
            $note->save();
        } else {
            // Record doesn't exist, create a new one
            $note = new AppliedTutorNote();
            $note->job_application_id = $request->id;
            $note->description = $request->description;
            $note->user_id = Auth::id();
            $note->save();
        }

        $note_log = new AppliedNoteLog();
        $note_log->user_id =  Auth::id();
        $note_log->job_application_id = $request->id;
        $note_log->description = $request->description;
        $note_log->save();

        return response()->json(['status' => 'success', 'message' => $note->description]);
    }

    public function getApplliedNote(Request $request)
    {

        $note_get = AppliedTutorNote::where('job_application_id',$request->id)->select('description')->first();
        if ($note_get) {
            return response()->json(['status' => 'success', 'message' => $note_get->description]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Note not found for the given job application ID']);
        }

    }


    public function getApplliedNoteLog(Request $request)
    {
    $get_note_logs = AppliedNoteLog::where('user_id', Auth::id())->where('job_application_id', $request->id)->get();
    $html = '';
    if (!$get_note_logs->isEmpty()) {
        $html .= '<table class="table">
                    <thead>
                        <tr>
                            <th>#SL.</th>
                            <th>Application Id</th>
                            <th>Edit By</th>
                            <th>Message</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($get_note_logs as $key => $log) {
            $html .= '<tr>
                        <td>' . ($key + 1) . '</td>
                        <td>' . $log->job_application_id . '</td>
                        <td>' . $log->user->name . '</td>
                        <td>' . $log->description . '</td>
                        <td>' . $log->created_at . '</td>
                    </tr>';
        }
        $html .= '</tbody></table>';
    } else {
        return response()->json(['status' => 'error', 'message' => 'Not Available']);
    }

    return response()->json(['status' => 'success', 'data' => $html]);
}


}
