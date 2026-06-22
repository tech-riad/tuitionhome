<?php

namespace App\Exports;

use App\Models\ApplicationPayment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ApplicationPaymentExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return ApplicationPayment::with(['owner', 'render'])
            ->select(
                'id', 'tutor_id', 'job_offer_id', 'application_id', 'due_payment_date',
                'due_amount', 'received_amount', 'received_number', 'payment_method', 'trx_id', 'payment_phone',
                'is_verified', 'verified_by', 'refund_coin', 'render_by', 'ownership_by', 'verify_date', 'in_out', 'service_category',
                'created_at'
            )
            ->orderBy('id','desc')
            ->get()
            ->map(function ($payment) {
                return [
                    'id' => $payment->id,
                    'tutor_id' => $payment->tutor_id,
                    'job_offer_id' => $payment->job_offer_id,
                    'application_id' => $payment->application_id,
                    'due_payment_date' => $payment->due_payment_date,
                    'due_amount' => $payment->due_amount,
                    'received_amount' => $payment->received_amount,
                    'received_number' => $payment->received_number,
                    'payment_method' => $payment->payment_method,
                    'trx_id' => $payment->trx_id,
                    'payment_phone' => $payment->payment_phone,
                    'is_verified' => $payment->is_verified,
                    'verified_by' => $payment->verified_by,
                    'refund_coin' => $payment->refund_coin,
                    'render_by' => $payment->render->name ?? 'N/A',
                    'ownership_by' => $payment->owner->name ?? 'N/A',
                    'verify_date' => $payment->verify_date,
                    'in_out' => $payment->in_out,
                    'service_category' => $payment->service_category,
                    'created_at' => $payment->created_at,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID', 'Tutor ID', 'Job Offer ID', 'Application ID', 'Due Payment Date',
            'Due Amount', 'Received Amount', 'Received Number', 'Payment Method', 'Transaction ID', 'Payment Phone',
            'Is Verified', 'Verified By', 'Refund Coin', 'Render By', 'Ownership By', 'Verify Date', 'In/Out', 'Service Category',
            'Created At'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
