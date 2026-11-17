<?php

namespace App\Http\Controllers\Frontend\Api\Tutor;

use App\Http\Controllers\Controller;
use App\Models\ConsultationRequestCheckout;
use App\Models\Invoice;
use App\Models\Parents;
use App\Models\PackageAmount;
use App\Models\Tutor;
use App\Models\TutorConsultationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class TutorConsultationRequestController extends Controller
{
    public function parentIndex()
    {
        $parentId = Auth::guard('p-api')->id();
        $requests = TutorConsultationRequest::with(['notes.user:id,name', 'invoice'])
            ->where('parent_id', $parentId)
            ->latest()
            ->paginate(15);
        $requests->getCollection()->transform(function ($consultationRequest) {
            return $this->apiData($consultationRequest);
        });

        return response()->json([
            'status' => true,
            'data' => $requests,
        ]);
    }

    public function parentStore(Request $request)
    {
        $validator = Validator::make($request->all(), $this->consultationRequestRules());
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'The consultation request could not be submitted.',
                'errors' => $validator->errors(),
            ], 422);
        }

        return $this->startConsultationCheckout(
            $validator->validated(),
            Auth::guard('p-api')->id(),
            'parent'
        );
    }

    public function index()
    {
        $consultationRequests = TutorConsultationRequest::with(['notes.user:id,name', 'invoice'])
            ->where('tutor_id', Auth::guard('t-api')->id())
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
            'canSubmitRequest' => !$this->hasActiveConsultationRequest('tutor_id', $tutorId),
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

        return $this->startConsultationCheckout(
            $validator->validated(),
            Auth::guard('t-api')->id(),
            'tutor'
        );
    }

    public function webStore(Request $request)
    {
        $validated = $request->validate($this->consultationRequestRules(false));

        $this->createConsultationRequest($validated, Auth::guard('tutor')->id());

        return redirect()
            ->route('tutor.consultation-requests.index')
            ->with('success', 'Your consultation request has been submitted.');
    }

    private function consultationRequestRules($includePackage = true)
    {
        $rules = [
            'message' => 'nullable|string|max:5000',
            'mode' => 'required|in:offline,online',
            'preferred_date' => 'required|date_format:Y-m-d',
        ];

        if ($includePackage) {
            $rules['package_id'] = [
                'required',
                'integer',
                \Illuminate\Validation\Rule::exists('package_amounts', 'id')->where('type', 'consultation'),
            ];
        }

        return $rules;
    }

    private function apiData(TutorConsultationRequest $consultationRequest)
    {
        return [
            'id' => $consultationRequest->id,
            'tutor_id' => $consultationRequest->tutor_id,
            'parent_id' => $consultationRequest->parent_id,
            'message' => $consultationRequest->message,
            'mode' => $consultationRequest->mode,
            'preferred_date' => $consultationRequest->preferred_date,
            'status' => $consultationRequest->status,
            'scheduled_at' => $consultationRequest->scheduled_at,
            'payment_status' => $consultationRequest->payment_status,
            'invoice' => $consultationRequest->invoice ? [
                'id' => $consultationRequest->invoice->id,
                'invoice_number' => $consultationRequest->invoice->invoice_number,
                'amount' => $consultationRequest->invoice->amount,
                'currency' => $consultationRequest->invoice->currency,
                'status' => $consultationRequest->invoice->status,
                'payment_date' => $consultationRequest->invoice->payment_date,
            ] : null,
            'notes' => $consultationRequest->relationLoaded('notes')
                ? $consultationRequest->notes->map(function ($note) {
                    return [
                        'note' => $note->note,
                        'author' => optional($note->user)->name,
                        'created_at' => $note->created_at,
                    ];
                })->values()
                : [],
        ];
    }

    private function createConsultationRequest(array $validated, $tutorId)
    {
        return DB::transaction(function () use ($validated, $tutorId) {
            Tutor::whereKey($tutorId)->lockForUpdate()->firstOrFail();

            if ($this->hasActiveConsultationRequest('tutor_id', $tutorId)) {
                throw ValidationException::withMessages([
                    'message' => 'You can submit a new consultation request after all previous requests are canceled.',
                ]);
            }

            return TutorConsultationRequest::create(array_merge($validated, [
                'tutor_id' => $tutorId,
            ]));
        });
    }

    private function startConsultationCheckout(array $validated, $ownerId, $ownerType)
    {
        try {
            $result = DB::transaction(function () use ($validated, $ownerId, $ownerType) {
                $ownerColumn = $ownerType === 'parent' ? 'parent_id' : 'tutor_id';
                $owner = $ownerType === 'parent'
                    ? Parents::whereKey($ownerId)->lockForUpdate()->firstOrFail()
                    : Tutor::whereKey($ownerId)->lockForUpdate()->firstOrFail();

                if ($this->hasActiveConsultationRequest($ownerColumn, $ownerId)) {
                    throw ValidationException::withMessages([
                        'message' => 'You can submit a new consultation request after all previous requests are canceled.',
                    ]);
                }

                $existingCheckout = ConsultationRequestCheckout::where($ownerColumn, $ownerId)
                    ->whereHas('invoice', function ($query) {
                        $query->where('status', 'pending');
                    })
                    ->with('invoice')
                    ->latest()
                    ->first();

                if ($existingCheckout) {
                    return ['invoice' => $existingCheckout->invoice, 'created' => false];
                }

                $package = PackageAmount::where('id', $validated['package_id'])
                    ->where('type', 'consultation')
                    ->firstOrFail();

                do {
                    $invoiceNumber = 'TC-' . Str::upper(Str::random(6));
                } while (Invoice::where('invoice_number', $invoiceNumber)->exists());

                $invoice = Invoice::create([
                    'tutor_id' => $ownerType === 'tutor' ? $owner->id : null,
                    'parent_id' => $ownerType === 'parent' ? $owner->id : null,
                    'invoice_number' => $invoiceNumber,
                    'amount' => $package->amount,
                    'currency' => $package->currency ?: 'BDT',
                    'status' => 'pending',
                    'issued_at' => now(),
                    'tutor_email' => $owner->email,
                    'tutor_name' => $owner->name,
                    'tutor_phone' => $owner->phone,
                    'unique_id' => $owner->unique_id,
                    'payment_date' => now()->addDays(7)->toDateString(),
                    'invoice_type' => 'consultation',
                    'package_name' => $package->package_name,
                    'package_duration' => $package->duration,
                    'package_id' => $package->id,
                ]);

                ConsultationRequestCheckout::create([
                    'invoice_id' => $invoice->id,
                    'tutor_id' => $ownerType === 'tutor' ? $owner->id : null,
                    'parent_id' => $ownerType === 'parent' ? $owner->id : null,
                    'message' => $validated['message'] ?? null,
                    'mode' => $validated['mode'],
                    'preferred_date' => $validated['preferred_date'],
                ]);

                return ['invoice' => $invoice, 'created' => true];
            });
        } catch (ValidationException $exception) {
            $errors = $exception->errors();
            return response()->json([
                'status' => false,
                'message' => collect($errors)->flatten()->first() ?: 'An active consultation request already exists.',
                'errors' => $errors,
            ], 409);
        }

        return response()->json([
            'status' => true,
            'message' => $result['created']
                ? 'Consultation invoice created. Complete payment to submit your request.'
                : 'An unpaid consultation invoice already exists. Complete payment to submit your request.',
            'request_status' => 'awaiting_payment',
            'invoice_id' => $result['invoice']->id,
            'invoice' => [
                'id' => $result['invoice']->id,
                'invoice_number' => $result['invoice']->invoice_number,
                'amount' => $result['invoice']->amount,
                'currency' => $result['invoice']->currency,
                'status' => $result['invoice']->status,
                'payment_date' => $result['invoice']->payment_date,
            ],
        ], $result['created'] ? 201 : 200);
    }

    private function hasActiveConsultationRequest($ownerColumn, $ownerId)
    {
        if (!in_array($ownerColumn, ['tutor_id', 'parent_id'], true)) {
            throw new \InvalidArgumentException('Unsupported consultation request owner.');
        }

        return TutorConsultationRequest::where($ownerColumn, $ownerId)
            ->whereRaw("LOWER(TRIM(COALESCE(status, ''))) NOT IN (?, ?, ?)", [
                'canceled',
                'cancelled',
                'cancel',
            ])
            ->exists();
    }

}
