<?php
namespace App\Exports;

use App\Models\ApplicationPayment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PaymentExportDateWise implements FromCollection, WithHeadings, WithStyles
{
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
