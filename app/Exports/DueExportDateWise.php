<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DueExportDateWise implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($payment) {
                return [
                    'id' => $payment->id,
                'trx_id' => $payment->trx_id,
                'paid_date' => $payment->paid_date,
                'tutor_id' => $payment->tutor_id,
                'job_id' => $payment->job_id,
                'user_type' => $payment->user_type,
                'name' => $payment->name,
                'service_category' => $payment->service_category,
                'amount' => $payment->amount,
                'payment_amount' => $payment->payment_amount,
                'refund_coin' => $payment->refund_coin,
                'payment_status' => $payment->payment_status,
                'render_by' => $payment->render->name ?? 'N/A',
                'ownership_by' => $payment->owner->name ?? 'N/A',
                'verified_by' => $payment->verified_by,
                'application_id' => $payment->application_id,
                'is_verified' => $payment->is_verified,
                'verify_date' => $payment->verify_date,
                'in_out' => $payment->in_out,
                'sending_method' => $payment->sending_method,
                'refund_complete_note' => $payment->refund_complete_note,
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
