<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Counting;
use App\Models\JobApplication;
use App\Models\JobOffer;
use App\Models\PackageAmount;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{

    public function index(Request $request)
    {
        $validated = $request->validate([
            'status' => ['nullable', Rule::in(['all', 'pending', 'paid', 'overdue', 'cancelled'])],
        ]);

        $user = $request->user();
        $baseQuery = Invoice::query();

        if ((int) $user->role_id !== 1) {
            $baseQuery->where('owned_by', $user->id);
        }

        $status = $validated['status'] ?? 'all';
        $counts = [
            'all' => (clone $baseQuery)->count(),
            'pending' => (clone $baseQuery)
                ->whereRaw('LOWER(status) = ?', ['pending'])
                ->where(function ($query) {
                    $query->whereNull('payment_date')
                        ->orWhereDate('payment_date', '>=', now()->toDateString());
                })
                ->count(),
            'paid' => (clone $baseQuery)
                ->whereRaw('LOWER(status) = ?', ['paid'])
                ->count(),
            'overdue' => (clone $baseQuery)
                ->whereRaw('LOWER(status) = ?', ['pending'])
                ->whereNotNull('payment_date')
                ->whereDate('payment_date', '<', now()->toDateString())
                ->count(),
            'cancelled' => (clone $baseQuery)
                ->whereIn(DB::raw('LOWER(status)'), ['cancel', 'cancelled'])
                ->count(),
        ];

        $query = clone $baseQuery;
        switch ($status) {
            case 'pending':
                $query->whereRaw('LOWER(status) = ?', ['pending'])
                    ->where(function ($query) {
                        $query->whereNull('payment_date')
                            ->orWhereDate('payment_date', '>=', now()->toDateString());
                    });
                break;
            case 'paid':
                $query->whereRaw('LOWER(status) = ?', ['paid']);
                break;
            case 'overdue':
                $query->whereRaw('LOWER(status) = ?', ['pending'])
                    ->whereNotNull('payment_date')
                    ->whereDate('payment_date', '<', now()->toDateString());
                break;
            case 'cancelled':
                $query->whereIn(DB::raw('LOWER(status)'), ['cancel', 'cancelled']);
                break;
        }

        $invoices = $query->with(['render', 'owner'])
            ->orderByDesc('issued_at')
            ->paginate(10)
            ->withQueryString();
        return view('backend.taken_offer.invoices', [
            'invoices' => $invoices,
            'counts' => $counts,
            'status' => $status,
            'tutor' => null,
        ]);
    }

    public function duplicate(Request $request, $id)
    {
        $validated = $request->validate([
            'new_payment_date' => 'required|date',
            'new_amount' => 'required|numeric|min:0',
        ]);

        $invoice = Invoice::findOrFail($id);
        $application = $invoice->job_id
            ? JobApplication::findOrFail($invoice->job_id)
            : null;

        if ($application && (float) $validated['new_amount'] > (float) $invoice->amount) {
            return back()
                ->withErrors(['new_amount' => 'Due amount cannot exceed the original invoice amount.'])
                ->withInput();
        }

        DB::transaction(function () use ($invoice, $application, $validated) {
            $newInvoice = $invoice->replicate();

            do {
                $invoiceNumber = 'JOB-' . Str::upper(Str::random(6));
            } while (Invoice::where('invoice_number', $invoiceNumber)->exists());

            $newInvoice->invoice_number = $invoiceNumber;
            $newInvoice->amount = $validated['new_amount'];
            $newInvoice->status = 'pending';
            $newInvoice->paid_at = null;
            $newInvoice->trx_id = null;
            $newInvoice->merchanttrx_id = null;
            $newInvoice->payment_method = null;
            $newInvoice->due_invoice = $application ? 1 : $invoice->due_invoice;
            $newInvoice->payment_date = $validated['new_payment_date'];
            $newInvoice->issued_at = now();
            $newInvoice->issued_by = Auth::id();

            if ($application) {
                $application->payment_status = 'due';
                $application->due_amount = $validated['new_amount'];
                $application->due_payment_date = $validated['new_payment_date'];
                $application->save();

                $invoice->amount = (float) $invoice->amount - (float) $validated['new_amount'];
                $invoice->save();
            }

            $newInvoice->save();
        });

        return redirect()
            ->route('admin.taken_offer.invoices')
            ->with('success', 'Invoice duplicated successfully.');
    }




    // Tutor Invoice List

    public function tutorInvoiceList(Request $request, $tutorId)
    {
        $request->validate([
            'status' => 'nullable|in:all,pending,paid,overdue,cancelled',
        ]);

        $tutor = Tutor::findOrFail($tutorId);
        $baseQuery = Invoice::where('tutor_id', $tutorId);
        $status = $request->input('status', 'all');

        $counts = [
            'all' => (clone $baseQuery)->count(),
            'pending' => (clone $baseQuery)
                ->whereRaw('LOWER(status) = ?', ['pending'])
                ->where(function ($query) {
                    $query->whereNull('payment_date')
                        ->orWhereDate('payment_date', '>=', now()->toDateString());
                })
                ->count(),
            'paid' => (clone $baseQuery)
                ->whereRaw('LOWER(status) = ?', ['paid'])
                ->count(),
            'overdue' => (clone $baseQuery)
                ->whereRaw('LOWER(status) = ?', ['pending'])
                ->whereNotNull('payment_date')
                ->whereDate('payment_date', '<', now()->toDateString())
                ->count(),
            'cancelled' => (clone $baseQuery)
                ->whereIn(\Illuminate\Support\Facades\DB::raw('LOWER(status)'), ['cancel', 'cancelled'])
                ->count(),
        ];

        $query = clone $baseQuery;

        switch ($status) {
            case 'pending':
                $query->whereRaw('LOWER(status) = ?', ['pending'])
                    ->where(function ($query) {
                        $query->whereNull('payment_date')
                            ->orWhereDate('payment_date', '>=', now()->toDateString());
                    });
                break;
            case 'paid':
                $query->whereRaw('LOWER(status) = ?', ['paid']);
                break;
            case 'overdue':
                $query->whereRaw('LOWER(status) = ?', ['pending'])
                    ->whereNotNull('payment_date')
                    ->whereDate('payment_date', '<', now()->toDateString());
                break;
            case 'cancelled':
                $query->whereIn(\Illuminate\Support\Facades\DB::raw('LOWER(status)'), ['cancel', 'cancelled']);
                break;
        }

        $invoices = $query->orderBy('issued_at', 'desc')
            ->paginate(10)
            ->withQueryString();
        $invoiceTypes = PackageAmount::query()
            ->whereNotNull('type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');

        return view('backend.tutor.tutor_invoice_list', compact('invoices', 'tutor', 'counts', 'status', 'invoiceTypes'));
    }

    public function storeForTutor(Request $request, $tutorId)
    {
        $invoiceTypes = PackageAmount::query()
            ->whereNotNull('type')
            ->distinct()
            ->pluck('type')
            ->all();
        $allowedTypes = array_merge($invoiceTypes, ['random']);

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01', 'max:9999999999.99'],
            'payment_date' => ['required', 'date'],
            'invoice_type' => ['required', Rule::in($allowedTypes)],
        ]);

        $tutor = Tutor::findOrFail($tutorId);
        $type = $validated['invoice_type'] === 'random'
            ? 'Random'
            : $validated['invoice_type'];

        $prefixes = [
            'premium' => 'PR',
            'boost' => 'BS',
            'sms' => 'SMS',
            'profile_verify' => 'VR',
            'random' => 'RAN',
        ];
        $prefix = $prefixes[strtolower($type)] ?? 'INV';

        do {
            $invoiceNumber = $prefix . '-' . Str::upper(Str::random(6));
        } while (Invoice::where('invoice_number', $invoiceNumber)->exists());

        Invoice::create([
            'tutor_id' => $tutor->id,
            'invoice_number' => $invoiceNumber,
            'amount' => $validated['amount'],
            'currency' => 'BDT',
            'status' => 'pending',
            'issued_at' => now(),
            'tutor_email' => $tutor->email,
            'tutor_name' => $tutor->name,
            'tutor_phone' => $tutor->phone,
            'unique_id' => $tutor->unique_id,
            'payment_date' => $validated['payment_date'],
            'issued_by' => Auth::id(),
            'owned_by' => Auth::id(),
            'invoice_type' => $type,
        ]);

        return redirect()
            ->route('admin.tutor.invoice.list', ['tutorId' => $tutor->id])
            ->with('success', 'Invoice created successfully.');
    }

    public function updateTutorInvoiceStatus(Request $request, $tutorId, $invoiceId)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'paid', 'cancelled'])],
            'filter' => ['nullable', Rule::in(['all', 'pending', 'paid', 'overdue', 'cancelled'])],
            'listing' => ['nullable', Rule::in(['global', 'tutor'])],
        ]);

        $canManageInvoices = in_array((int) $request->user()->role_id, [1, 6], true);
        if (!$canManageInvoices && $validated['status'] !== 'cancelled') {
            abort(403, 'You may only cancel pending invoices.');
        }

        $invoice = Invoice::where('tutor_id', $tutorId)->findOrFail($invoiceId);
        $currentStatus = strtolower($invoice->status ?? '');
        if ($currentStatus === 'cancel') {
            $currentStatus = 'cancelled';
        }

        $newStatus = $validated['status'];
        if ($currentStatus === 'paid' && $newStatus !== 'paid') {
            return back()
                ->withErrors(['status' => 'Paid invoices cannot be changed.'])
                ->withInput();
        }

        if ($currentStatus === 'cancelled' && $newStatus === 'paid') {
            return back()
                ->withErrors(['status' => 'Reopen the invoice as pending before marking it paid.'])
                ->withInput();
        }

        if ($newStatus === 'cancelled' && $currentStatus !== 'pending' && $currentStatus !== 'cancelled') {
            return back()
                ->withErrors(['status' => 'Only pending invoices can be cancelled.'])
                ->withInput();
        }

        DB::transaction(function () use ($invoice, $newStatus, $currentStatus) {
            if ($newStatus === 'cancelled' && $currentStatus === 'pending' && $invoice->job_id) {
                $stage = JobApplication::where('id', $invoice->job_id)->firstOrFail();
                $stage->current_stage = 'closed';
                $stage->closed_about = 'After invoice cancellation, the job is closed.';
                $stage->closed_date = now();
                $stage->save();

                $stageUpdate = JobOffer::where('id', $stage->job_offer_id)->firstOrFail();
                $stageUpdate->is_active = 0;
                $stageUpdate->live_off_date = now();
                $stageUpdate->save();

                $counting = Counting::where('tutor_id', $stage->tutor_id)->firstOrFail();
                $counting->cancel_job++;
                $counting->save();
            }

            $invoice->status = $newStatus;
            $invoice->paid_at = $newStatus === 'paid' ? ($invoice->paid_at ?? now()) : null;
            $invoice->save();
        });

        $redirect = ($validated['listing'] ?? 'tutor') === 'global'
            ? redirect()->route('admin.taken_offer.invoices', [
                'status' => $validated['filter'] ?? 'all',
            ])
            : redirect()->route('admin.tutor.invoice.list', [
                'tutorId' => $tutorId,
                'status' => $validated['filter'] ?? 'all',
            ]);

        return $redirect->with('success', 'Invoice status updated successfully.');
    }

}
