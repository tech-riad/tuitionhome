<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdvanceSearchSms;
use App\Models\Invoice;
use App\Models\PackageAmount;
use App\Models\SmsBalance;
use App\Models\TutorConsultationRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TutorConsultationRequestController extends Controller
{
    public function index(Request $request)
    {
        return $this->consultationIndex($request, 'tutor');
    }

    public function parentIndex(Request $request)
    {
        return $this->consultationIndex($request, 'parent');
    }

    private function consultationIndex(Request $request, $consultationType)
    {
        $validated = $request->validate([
            'status' => ['nullable', Rule::in(TutorConsultationRequest::STATUSES)],
            'scheduled_date' => ['nullable', 'date_format:Y-m-d'],
            'tutor_phone' => ['nullable', 'string', 'max:30'],
        ]);

        $consultationRequests = TutorConsultationRequest::with([
            'tutor:id,name,email,phone,is_sms',
            'parent:id,name,email,phone,unique_id',
            'notes.user:id,name',
            'invoice',
        ])
            ->whereNotNull($consultationType === 'parent' ? 'parent_id' : 'tutor_id')
            ->when(!empty($validated['status']), function ($query) use ($validated) {
                $query->where('status', $validated['status']);
            })
            ->when(!empty($validated['scheduled_date']), function ($query) use ($validated) {
                $query->whereDate('scheduled_at', $validated['scheduled_date']);
            })
            ->when(!empty($validated['tutor_phone']), function ($query) use ($validated) {
                $query->whereHas($consultationType, function ($ownerQuery) use ($validated) {
                    $ownerQuery->where('phone', 'like', '%' . $validated['tutor_phone'] . '%');
                });
            })
            ->when($consultationType === 'parent', function ($query) {
                $query->whereNull('tutor_id');
            }, function ($query) {
                $query->whereNull('parent_id');
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('backend.consultation_requests.index', [
            'consultationRequests' => $consultationRequests,
            'consultationType' => $consultationType,
            'statuses' => TutorConsultationRequest::STATUSES,
            'selectedStatus' => $validated['status'] ?? '',
            'selectedScheduledDate' => $validated['scheduled_date'] ?? '',
            'selectedTutorPhone' => $validated['tutor_phone'] ?? '',
            'packageAmounts' => PackageAmount::query()
                ->where('type', 'consultation')
                ->orderBy('package_name')
                ->get(),
        ]);
    }

    public function createInvoice(Request $request, TutorConsultationRequest $consultationRequest)
    {
        $validated = $request->validate([
            'package_amount_id' => ['required', 'integer', Rule::exists('package_amounts', 'id')->where('type', 'consultation')],
        ]);

        if ($consultationRequest->invoice_id) {
            return response()->json([
                'status' => false,
                'message' => 'An invoice has already been created for this consultation request.',
            ], 409);
        }

        $packageAmount = PackageAmount::findOrFail($validated['package_amount_id']);
        $tutor = $consultationRequest->tutor;
        $parent = $consultationRequest->parent;
        $owner = $tutor ?: $parent;
        abort_unless($owner, 422, 'The account for this request is unavailable.');

        $invoice = DB::transaction(function () use ($request, $consultationRequest, $packageAmount, $tutor, $parent, $owner) {
            do {
                $invoiceNumber = 'TC-' . Str::upper(Str::random(6));
            } while (Invoice::where('invoice_number', $invoiceNumber)->exists());

            $invoice = Invoice::create([
                'tutor_id' => $tutor ? $tutor->id : null,
                'parent_id' => $parent ? $parent->id : null,
                'invoice_number' => $invoiceNumber,
                'amount' => $packageAmount->amount,
                'currency' => $packageAmount->currency ?: 'BDT',
                'status' => 'pending',
                'issued_at' => now(),
                'tutor_email' => $owner->email,
                'tutor_name' => $owner->name,
                'tutor_phone' => $owner->phone,
                'unique_id' => $owner->unique_id,
                'payment_date' => now()->addDays(7)->toDateString(),
                'issued_by' => $request->user()->id,
                'owned_by' => $request->user()->id,
                'invoice_type' => 'consultation',
                'package_name' => $packageAmount->package_name,
                'package_duration' => $packageAmount->duration,
                'package_id' => $packageAmount->id,
            ]);

            $consultationRequest->update([
                'invoice_id' => $invoice->id,
                'payment_status' => 'unpaid',
            ]);

            return $invoice;
        });

        return response()->json([
            'status' => true,
            'message' => 'Invoice created successfully.',
            'invoice' => [
                'id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'amount' => $invoice->amount,
                'currency' => $invoice->currency,
                'status' => $invoice->status,
                'payment_date' => $invoice->payment_date,
            ],
            'payment_status' => $consultationRequest->fresh()->payment_status,
        ], 201);
    }

    public function updatePaymentStatus(Request $request, TutorConsultationRequest $consultationRequest)
    {
        $validated = $request->validate([
            'payment_status' => ['required', Rule::in(['paid', 'unpaid'])],
        ]);

        $invoice = $consultationRequest->invoice;
        if (!$invoice) {
            return response()->json([
                'status' => false,
                'message' => 'Create an invoice before updating payment status.',
            ], 422);
        }

        if (in_array(strtolower($invoice->status), ['cancel', 'cancelled'], true)) {
            return response()->json([
                'status' => false,
                'message' => 'Cancelled invoices cannot have their payment status changed.',
            ], 422);
        }

        if (strtolower($invoice->status) === 'paid' && $validated['payment_status'] !== 'paid') {
            return response()->json([
                'status' => false,
                'message' => 'Paid invoices cannot be changed to unpaid.',
            ], 422);
        }

        DB::transaction(function () use ($invoice, $consultationRequest, $validated) {
            $isPaid = $validated['payment_status'] === 'paid';
            $invoice->update([
                'status' => $isPaid ? 'paid' : 'pending',
                'paid_at' => $isPaid ? ($invoice->paid_at ?? now()) : null,
            ]);
            $consultationRequest->update([
                'payment_status' => $validated['payment_status'],
            ]);
        });

        return response()->json([
            'status' => true,
            'message' => 'Payment status updated.',
            'payment_status' => $consultationRequest->fresh()->payment_status,
            'invoice' => [
                'invoice_number' => $invoice->invoice_number,
                'currency' => $invoice->currency,
                'amount' => $invoice->amount,
                'status' => $invoice->fresh()->status,
            ],
        ]);
    }

    public function cancelInvoice(TutorConsultationRequest $consultationRequest)
    {
        $invoice = $consultationRequest->invoice;
        if (!$invoice) {
            return response()->json([
                'status' => false,
                'message' => 'There is no invoice to cancel.',
            ], 422);
        }

        $result = DB::transaction(function () use ($consultationRequest) {
            $invoice = Invoice::whereKey($consultationRequest->invoice_id)->lockForUpdate()->firstOrFail();
            $invoiceStatus = strtolower($invoice->status);
            if ($invoiceStatus !== 'pending') {
                if ($invoiceStatus === 'paid') {
                    return ['error' => 'Paid invoices cannot be cancelled.'];
                }
                if (in_array($invoiceStatus, ['cancel', 'cancelled'], true)) {
                    return ['error' => 'This invoice is already cancelled.'];
                }
                return ['error' => 'Only pending invoices can be cancelled.'];
            }

            $invoice->update(['status' => 'cancelled', 'paid_at' => null]);
            $consultationRequest->update(['payment_status' => 'unpaid']);

            return ['invoice' => $invoice->fresh()];
        });

        if (isset($result['error'])) {
            return response()->json([
                'status' => false,
                'message' => $result['error'],
            ], 422);
        }

        $invoice = $result['invoice'];
        return response()->json([
            'status' => true,
            'message' => 'Invoice cancelled.',
            'invoice' => [
                'invoice_number' => $invoice->invoice_number,
                'currency' => $invoice->currency,
                'amount' => $invoice->amount,
                'status' => $invoice->fresh()->status,
            ],
        ]);
    }

    public function smsEditor(Request $request)
    {
        $validated = $this->validateSelectedRequestIds($request);
        $consultationRequests = $this->getSmsEligibleRequests($validated['consultation_request_ids']);

        return view('backend.consultation_requests.sms-editor', compact('consultationRequests'));
    }

    public function selectSmsRecipients(Request $request)
    {
        $validated = $this->validateSelectedRequestIds($request);
        $this->getSmsEligibleRequests($validated['consultation_request_ids']);

        return redirect()->route('admin.consultation-requests.sms.editor', [
            'consultation_request_ids' => $validated['consultation_request_ids'],
            'status' => $request->input('status'),
        ]);
    }

    public function sendBulkSms(Request $request)
    {
        $validated = array_merge(
            $this->validateSelectedRequestIds($request),
            $request->validate([
                'message' => ['required', 'string', 'max:300'],
            ])
        );
        $consultationRequests = $this->getSmsEligibleRequests($validated['consultation_request_ids']);
        $recipients = $consultationRequests->unique('tutor_id')->values();

        DB::transaction(function () use ($recipients, $validated, $request) {
            foreach ($recipients as $consultationRequest) {
                $sms = new AdvanceSearchSms();
                $sms->send_by = $request->user()->id;
                $sms->body = $validated['message'];
                $sms->phone = $this->normalizeBangladeshPhone($consultationRequest->tutor->phone);
                $sms->is_send = 0;
                $sms->save();

                $balance = SmsBalance::firstOrNew(['tutor_id' => $consultationRequest->tutor_id]);
                $balance->unpaid_sms = (int) $balance->unpaid_sms + 1;
                $balance->save();
            }
        });

        return redirect()
            ->route('admin.consultation-requests.index', ['status' => $request->input('status')])
            ->with('success', 'SMS queued for ' . $recipients->count() . ' selected tutor(s).');
    }

    private function validateSelectedRequestIds(Request $request)
    {
        return $request->validate([
            'consultation_request_ids' => ['required', 'array', 'min:1', 'max:20'],
            'consultation_request_ids.*' => [
                'required',
                'integer',
                'distinct',
                'exists:tutor_consultation_requests,id',
            ],
        ]);
    }

    private function getSmsEligibleRequests(array $requestIds)
    {
        $consultationRequests = TutorConsultationRequest::with('tutor:id,name,phone,is_sms')
            ->whereIn('id', $requestIds)
            ->get();

        if ($consultationRequests->count() !== count($requestIds)) {
            abort(422, 'One or more selected consultation requests do not exist.');
        }

        foreach ($consultationRequests as $consultationRequest) {
            if (!$consultationRequest->tutor || (int) $consultationRequest->tutor->is_sms !== 1) {
                abort(422, 'SMS is disabled for one or more selected tutors.');
            }

            if ($this->normalizeBangladeshPhone($consultationRequest->tutor->phone) === null) {
                abort(422, 'A selected tutor does not have a valid Bangladesh mobile number.');
            }
        }

        return $consultationRequests;
    }

    private function normalizeBangladeshPhone($phone)
    {
        $phone = preg_replace('/\D+/', '', (string) $phone);

        if (preg_match('/^8801[3-9]\d{8}$/', $phone)) {
            return substr($phone, 2);
        }

        if (preg_match('/^01[3-9]\d{8}$/', $phone)) {
            return $phone;
        }

        if (preg_match('/^1[3-9]\d{8}$/', $phone)) {
            return '0' . $phone;
        }

        return null;
    }

    public function updateStatus(Request $request, TutorConsultationRequest $consultationRequest)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(TutorConsultationRequest::STATUSES)],
            'scheduled_at' => [
                Rule::requiredIf($request->input('status') === 'scheduled'),
                'nullable',
                'date',
            ],
        ]);

        $consultationRequest->update([
            'status' => $validated['status'],
            'scheduled_at' => $validated['status'] === 'scheduled'
                ? $validated['scheduled_at']
                : null,
        ]);

        return redirect()
            ->route('admin.consultation-requests.index', ['status' => $request->query('status')])
            ->with('success', 'Consultation request updated.');
    }

    public function updateDetails(Request $request, TutorConsultationRequest $consultationRequest)
    {
        $validated = $request->validate([
            'message' => ['nullable', 'string', 'max:5000'],
            'status' => ['required', Rule::in(TutorConsultationRequest::STATUSES)],
            'scheduled_at' => [
                Rule::requiredIf($request->input('status') === 'scheduled'),
                'nullable',
                'date',
            ],
        ]);

        $consultationRequest->update([
            'message' => trim($validated['message'] ?? ''),
            'status' => $validated['status'],
            'scheduled_at' => $validated['status'] === 'scheduled'
                ? $validated['scheduled_at']
                : null,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Consultation request updated.',
                'request' => [
                    'id' => $consultationRequest->id,
                    'message' => $consultationRequest->message,
                    'status' => $consultationRequest->status,
                    'scheduled_at' => optional($consultationRequest->scheduled_at)->format('M d, Y g:i A'),
                ],
            ]);
        }

        return redirect()
            ->route('admin.consultation-requests.index', [
                'status' => $request->query('status'),
                'page' => $request->query('page'),
            ])
            ->with('success', 'Consultation request updated.');
    }

    public function updateMessage(Request $request, TutorConsultationRequest $consultationRequest)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $consultationRequest->update([
            'message' => trim($validated['message']),
        ]);

        return redirect()
            ->route('admin.consultation-requests.index', [
                'status' => $request->query('status'),
                'page' => $request->query('page'),
            ])
            ->with('success', 'Consultation message updated.');
    }

    public function storeNote(Request $request, TutorConsultationRequest $consultationRequest)
    {
        $validated = $request->validate([
            'note' => ['required', 'string', 'max:5000'],
        ]);

        $note = $consultationRequest->notes()->create([
            'user_id' => $request->user()->id,
            'note' => trim($validated['note']),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Note added.',
                'note' => [
                    'note' => $note->note,
                    'author' => $request->user()->name,
                    'created_at' => $note->created_at->format('M d, Y g:i A'),
                ],
                'notes_count' => $consultationRequest->notes()->count(),
            ], 201);
        }

        return redirect()
            ->route('admin.consultation-requests.index', [
                'status' => $request->query('status'),
                'page' => $request->query('page'),
            ])
            ->with('success', 'Note added to the consultation request.');
    }
}
