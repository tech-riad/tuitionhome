<?php

namespace App\Http\Controllers\Frontend\Api\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use App\Models\TutorConsultationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
        $tutorId = Auth::guard('tutor')->id();
        $consultationRequests = TutorConsultationRequest::with('notes.user:id,name')
            ->where('tutor_id', $tutorId)
            ->latest()
            ->paginate(15);

        return view('dashboard.tutor.pages.consultation-requests', [
            'consultationRequests' => $consultationRequests,
            'canSubmitRequest' => !$this->hasActiveConsultationRequest($tutorId),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->consultationRequestRules());
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'The consultation request could not be submitted.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $consultationRequest = $this->createConsultationRequest(
                $validator->validated(),
                Auth::guard('t-api')->id()
            );
        } catch (ValidationException $exception) {
            $errors = $exception->errors();
            $message = collect($errors)->flatten()->first();
            return response()->json([
                'status' => false,
                'message' => $message ?: 'An active consultation request already exists.',
                'errors' => $errors,
            ], 409);
        }

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
            'message' => 'nullable|string|max:5000',
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
        return DB::transaction(function () use ($validated, $tutorId) {
            Tutor::whereKey($tutorId)->lockForUpdate()->firstOrFail();

            if ($this->hasActiveConsultationRequest($tutorId)) {
                throw ValidationException::withMessages([
                    'message' => 'You can submit a new consultation request after all previous requests are canceled.',
                ]);
            }

            return TutorConsultationRequest::create(array_merge($validated, [
                'tutor_id' => $tutorId,
            ]));
        });
    }

    private function hasActiveConsultationRequest($tutorId)
    {
        return TutorConsultationRequest::where('tutor_id', $tutorId)
            ->whereRaw("LOWER(TRIM(COALESCE(status, ''))) NOT IN (?, ?, ?)", [
                'canceled',
                'cancelled',
                'cancel',
            ])
            ->exists();
    }

}
