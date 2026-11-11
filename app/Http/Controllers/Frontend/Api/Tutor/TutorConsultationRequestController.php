<?php

namespace App\Http\Controllers\Frontend\Api\Tutor;

use App\Http\Controllers\Controller;
use App\Models\TutorConsultationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutorConsultationRequestController extends Controller
{
    public function index()
    {
        $consultationRequests = TutorConsultationRequest::where('tutor_id', Auth::user()->id)
            ->latest()
            ->paginate(15);
        $consultationRequests->getCollection()->transform(function ($consultationRequest) {
            return $this->apiData($consultationRequest);
        });

        return response()->json([
            'status' => true,
            'data' => $consultationRequests,
        ]);
    }

    public function webIndex()
    {
        $consultationRequests = TutorConsultationRequest::with('notes.user:id,name')
            ->where('tutor_id', Auth::guard('tutor')->id())
            ->latest()
            ->paginate(15);

        return view('dashboard.tutor.pages.consultation-requests', compact('consultationRequests'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->consultationRequestRules());

        $consultationRequest = $this->createConsultationRequest(
            $validated,
            Auth::guard('t-api')->id()
        );

        return response()->json([
            'status' => true,
            'message' => 'Consultation request submitted successfully.',
            'data' => $this->apiData($consultationRequest),
        ], 201);
    }

    public function webStore(Request $request)
    {
        $validated = $request->validate($this->consultationRequestRules());

        $this->createConsultationRequest($validated, Auth::guard('tutor')->id());

        return redirect()
            ->route('tutor.consultation-requests.index')
            ->with('success', 'Your consultation request has been submitted.');
    }

    private function consultationRequestRules()
    {
        return [
            'message' => 'required|string|max:5000',
        ];
    }

    private function apiData(TutorConsultationRequest $consultationRequest)
    {
        return [
            'id' => $consultationRequest->id,
            'tutor_id' => $consultationRequest->tutor_id,
            'message' => $consultationRequest->message,
            'status' => $consultationRequest->status,
            'scheduled_at' => $consultationRequest->scheduled_at,
        ];
    }

    private function createConsultationRequest(array $validated, $tutorId)
    {
        return TutorConsultationRequest::create(array_merge($validated, [
            'tutor_id' => $tutorId,
        ]));
    }

}
