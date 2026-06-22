<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AdnSmsService
{
    private $apiKey;
    private $apiSecret;
    private $apiEndpoint;

    public function __construct()
    {

        $this->apiKey       = 'KEY-aruei4alh5bc3bwdgl9wn9b57x2165sm';
        $this->apiSecret    = 'fY5m2tt0Xrj$0pPW';

        $this->apiEndpoint  = 'https://portal.adnsms.com/api/v1/secure/send-sms';
    }

    public function sendOtp($phoneNumber, $otp)
    {
        try {
            $response = Http::withHeaders([
                'API-Key' => $this->apiKey,
                'API-Secret' => $this->apiSecret,
            ])->post($this->apiEndpoint, [
                'api_key' => $this->apiKey,
                'api_secret' => $this->apiSecret,
                'request_type' => 'OTP',
                'message_type' => 'TEXT',
                'mobile' => $phoneNumber,
                'message_body' =>  $otp,
            ]);


            return $response->json();
        } catch (\Exception $e) {

        }
    }
}