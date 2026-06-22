<?php

namespace App\Jobs;

use App\Models\JobSms;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tutorId;
    protected $tutorNumber;
    protected $smsBody;
    protected $jobId;
    protected $titleId;

    public function __construct($tutorId, $tutorNumber, $smsBody, $jobId, $titleId)
    {
        $this->tutorId = $tutorId;
        $this->tutorNumber = $tutorNumber;
        $this->smsBody = $smsBody;
        $this->jobId = $jobId;
        $this->titleId = $titleId;
    }

    public function handle()
    {
        try {
            $message = $this->smsBody;
            $url = 'https://easybulksmsbd.com/sms/api?action=send-sms&api_key=VHVpdGlvbkhvbWU6MTIzNDU2Nzg5&to=88' . $this->tutorNumber . '&from=SenderID&sms=' . $message;
            $response = Http::get($url);

            if ($response->failed()) {
                // Log error or throw an exception
                \Log::error('Failed to send SMS to ' . $this->tutorNumber . '. HTTP Error: ' . $response->status());
            }

            $sms = new JobSms();
            $sms->job_id = $this->jobId;
            $sms->sender_name = Auth::user()->name;
            $sms->sender_id = Auth::user()->id;
            $sms->sms_title = $this->titleId;
            $sms->sms_body = $this->smsBody;
            $sms->tutor_id = $this->tutorId;
            $sms->tutor_phone = $this->tutorNumber;
            $sms->sms_method = "pushup";
            $sms->save();

        } catch (\Exception $e) {
            // Log error or throw an exception
            \Log::error('Error: ' . $e->getMessage());
        }
    }
}