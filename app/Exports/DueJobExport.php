<?php

namespace App\Exports;

use App\Models\JobApplication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DueJobExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return JobApplication::select(
                'id', 'tutor_id', 'job_offer_id', 'confirm_date', 'charge','tuition_salary','tutoring_start_date','received_amount',
                'due_payment_date','due_amount','confirm_about', 'current_stage','created_at'
            )
            ->where('payment_status', 'due')
            ->orwhere('payment_status' , 'Partial_paid')
            ->orderBy('id','desc')
            ->get()
            ->map(function ($confirmJob) {
                return [
                    'id' => $confirmJob->id,
                    'tutor_id' => $confirmJob->tutor->unique_id,
                    'tutor_name' => $confirmJob->tutor->name,
                    'tutor_phone' => $confirmJob->tutor->phone,
                    'job_offer_id' => $confirmJob->job_offer_id,
                    'confirm_date' => $confirmJob->confirm_date,
                    'tuition_salary' => $confirmJob->tuition_salary,
                    'charge' => $confirmJob->charge,
                    'tutoring_start_date' => $confirmJob->tutoring_start_date,
                    'received_amount' => $confirmJob->received_amount,
                    'due_amount' => $confirmJob->due_amount,
                    'due_payment_date' => $confirmJob->due_payment_date,
                    'confirm_about' => $confirmJob->confirm_about,
                    'current_stage' => $confirmJob->current_stage,
                    'created_at' => $confirmJob->created_at,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID', 'Tutor ID','TUTOR NAME','TUTOR PHONE','Job Offer ID', 'CONFIRM DATE','TUITION SALARY',
             'CHARGE','TUITION START DATE','RECEIVED AMOUNT','DUE AMOUNT','DUE PAYMENT DATE','CONFIRM ABOUT','CURRENT STAGE','CREATED AT'

        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
