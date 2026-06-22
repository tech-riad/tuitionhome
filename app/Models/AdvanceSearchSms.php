<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class AdvanceSearchSms extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class,'send_by');
    }

    public static function smsApiRequest($numbers, $text)
    {
        try {
            $text = urlencode($text);

            $url = 'https://easybulksmsbd.com/sms/api?action=send-sms&api_key=VHVpdGlvbkhvbWU6MTIzNDU2Nzg5&to=' . $numbers . '&from=SenderID&sms=' . $text;

            $response = Http::get($url);

            if ($response->successful()) {
                return $response->body();
            } else {

                $errorMessage = 'SMS API request failed. HTTP Error: ' . $response->status();

                return $errorMessage;
            }
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}