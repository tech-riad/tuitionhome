<?php

namespace App\Exports;

use App\Models\DuePayments;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DueExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        return DuePayments::with(['ownerBy', 'render'])
        ->select(
            'id',
            'trx_id',
            'paid_date',
            'tutor_id',
            'job_id',
            'user_type',
            'name',
            'service_category',
            'amount',
            'payment_amount',
            'refund_coin',
            'payment_status',
            'render_by',
            'ownership_by',
            'verified_by',
            'application_id',
            'is_verified',
            'verify_date',
            'in_out',
            'sending_method',
            'refund_complete_note',
            'created_at'
        )
        ->orderBy('id', 'desc')
        ->get()
        ->map(function ($payment) {
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
            'ID',
            'Transaction ID',
            'Paid Date',
            'Tutor ID',
            'Job ID',
            'User Type',
            'Name',
            'Service Category',
            'Amount',
            'Payment Amount',
            'Refund Coin',
            'Payment Status',
            'Render By',
            'Ownership By',
            'Verified By',
            'Application ID',
            'Is Verified',
            'Verify Date',
            'In/Out',
            'Sending Method',
            'Refund Complete Note',
            'Created At',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
