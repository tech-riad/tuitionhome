<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::
        // where('owned_by', auth()->id())->
        orderBy('issued_at', 'desc')->paginate(2);
        return view('backend.taken_offer.invoices', compact('invoices'));
    }
}
