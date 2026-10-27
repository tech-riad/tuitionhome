<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\JobApplication;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{

    public function index()
    {
        $query = Invoice::query();

        if (auth()->user()->role_id != 1) {
            $query->where('owned_by', auth()->id());
        }

        $invoices = $query->orderBy('issued_at', 'desc')
                        ->paginate(10);

        return view('backend.taken_offer.invoices', compact('invoices'));
    }



    public function duplicate(Request $request, $id)
    {
        $request->validate([
            'new_payment_date' => 'required|date',
            'new_amount' => 'required|numeric|min:0',
        ]);

        $invoice = Invoice::findOrFail($id);

        $newInvoice = $invoice->replicate();

        // Generate new unique invoice number
        do {
            $invoiceNumber = 'INV-' . strtoupper(Str::random(13));
        } while (Invoice::where('invoice_number', $invoiceNumber)->exists());

        $newInvoice->invoice_number = $invoiceNumber;

        // New values from modal
        $newInvoice->amount = $request->new_amount;
        $newInvoice->due_invoice = 1;
        $newInvoice->payment_date = $request->new_payment_date;

        // dd($newInvoice->job_id, $newInvoice->payment_date);
        $application = JobApplication::find($invoice->job_id);
                if (!$application) {
                    return response()->json([
                        'status' => false,
                        'error'  => 'Application not found.'
                    ]);
                }

        $application->payment_status = 'due';
        $application->due_amount = $request->new_amount;
        $application->due_payment_date = $request->new_payment_date;
        $application->save();

        // Updated values
        $invoice->amount = $invoice->amount - $request->new_amount;
        $newInvoice->issued_at = now();
        $newInvoice->issued_by = Auth::id();
        $newInvoice->updated_at = now();

        $newInvoice->save();
        $invoice->save();
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

        return view('backend.tutor.tutor_invoice_list', compact('invoices', 'tutor', 'counts', 'status'));
    }

}
