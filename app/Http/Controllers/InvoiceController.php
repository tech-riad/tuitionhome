<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::
        // where('owned_by', auth()->id())->
        orderBy('issued_at', 'desc')->paginate(2);
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

}
