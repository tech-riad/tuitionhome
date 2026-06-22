<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Exception;

class SendBulkSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phoneNumbers;
    protected $smsBody;

    public function __construct($phoneNumbers, $smsBody)
    {
        $this->phoneNumbers = $phoneNumbers;
        $this->smsBody = $smsBody;
    }

    public function handle()
    {
        $apiKey = 'VHVpdGlvbkhvbWU6MTIzNDU2Nzg5';
        $apiUrl = 'https://easybulksmsbd.com/sms/api?action=send-sms&api_key=' . $apiKey . '&from=SenderID';

        foreach ($this->phoneNumbers as $phoneNumber) {
            $formattedPhoneNumber = '88' . $phoneNumber;

            $url = $apiUrl . '&to=' . $formattedPhoneNumber . '&sms=' . urlencode($this->smsBody);

            try {
                $response = Http::get($url);

                if ($response->failed()) {
                    throw new Exception('HTTP Error: ' . $response->status());
                }
            } catch (\Exception $curlException) {
                throw new Exception('cURL Error: ' . $curlException->getMessage());
            }
        }
    }
}