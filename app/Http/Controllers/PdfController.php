<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function generatePdf()
    {

        $data = [
            'test'=>'hello',
        ];
        $pdf = Pdf::loadView('backend.tutor.cvPdf', $data);
        
        return $pdf->download('invoice.pdf');
    }
}
