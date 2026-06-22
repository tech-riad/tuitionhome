<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Sms extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_id', 'send_by', 'user_id', 'body', 'phone', 'sent',
    ];

    public function user(){
        return $this->belongsTo(User::class,'send_by');
    }
    // public static function otpApiRequest($numbers_string,$text){
    //     $cURLConnection = curl_init();
    //     $text=\urlencode($text);
    //     $url='https://easybulksmsbd.com/sms/api?action=send-sms&otp=1&api_key=dHVpdGlvbnRlcm1pbmFsb3RwOjEyMzQ1Njc4&to='.$numbers_string.'&from=SenderID&sms='.$text;
    //     curl_setopt($cURLConnection, CURLOPT_URL, $url);
    //     curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
    //     $res = curl_exec($cURLConnection);
    //     curl_close($cURLConnection);
    //     return $res;
    // }

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