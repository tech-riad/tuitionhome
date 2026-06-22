<?php

namespace App\Services;

class BkashTokenService
{


    public function getToken()
    {
        $appKey = config('bkash.app_key');
        $appSecret = config('bkash.app_secret');
        $baseUrl = config('bkash.base_url');
        $username = config('bkash.username');
        $password = config('bkash.password');

        $postToken = [
            'app_key' => $appKey,
            'app_secret' => $appSecret
        ];

        $url = curl_init("$baseUrl/v1.2.0-beta/tokenized/checkout/token/grant");
        $postToken = json_encode($postToken);
        $header = array(
            'Content-Type: application/json',
            'Accept: application/json',
            "password: $password",
            "username: $username"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $postToken);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultData = curl_exec($url);

        if ($resultData === false) {
            $error = curl_error($url);
            curl_close($url);
            return ['error' => $error];
        }

        curl_close($url);

        $response = json_decode($resultData, true);



        // \Log::info('bKash API response:', $response);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['error' => 'Invalid JSON response from bKash API'];
        }

        if (isset($response['id_token'])) {
            session()->put('bkash_token', $response['id_token']);
            return [
                'success' => true,
                'id_token' => $response['id_token'],
        ];
        } else {
            return ['error' => 'Missing id_token in the bKash API response'];
        }
    }
    public function getPaymentToken()
    {
        $appKey = config('applicationpayment.app_key');
        $appSecret = config('applicationpayment.app_secret');
        $baseUrl = config('applicationpayment.base_url');
        $username = config('applicationpayment.username');
        $password = config('applicationpayment.password');

        $postToken = [
            'app_key' => $appKey,
            'app_secret' => $appSecret
        ];

        $url = curl_init("$baseUrl/v1.2.0-beta/tokenized/checkout/token/grant");
        $postToken = json_encode($postToken);
        $header = array(
            'Content-Type: application/json',
            'Accept: application/json',
            "password: $password",
            "username: $username"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $postToken);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultData = curl_exec($url);

        if ($resultData === false) {
            $error = curl_error($url);
            curl_close($url);
            return ['error' => $error];
        }

        curl_close($url);

        $response = json_decode($resultData, true);



        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['error' => 'Invalid JSON response from bKash API'];
        }

        if (isset($response['id_token'])) {
            session()->put('bkash_token', $response['id_token']);
            return [
                'success' => true,
                'id_token' => $response['id_token'],
        ];
        } else {
            return ['error' => 'Missing id_token in the bKash API response'];
        }
    }

    public function getPremiumToken()
    {
        $appKey = config('applicationpayment.app_key');
        $appSecret = config('applicationpayment.app_secret');
        $baseUrl = config('applicationpayment.base_url');
        $username = config('applicationpayment.username');
        $password = config('applicationpayment.password');

        $postToken = [
            'app_key' => $appKey,
            'app_secret' => $appSecret
        ];

        $url = curl_init("$baseUrl/v1.2.0-beta/tokenized/checkout/token/grant");
        $postToken = json_encode($postToken);
        $header = array(
            'Content-Type: application/json',
            'Accept: application/json',
            "password: $password",
            "username: $username"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $postToken);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultData = curl_exec($url);

        if ($resultData === false) {
            $error = curl_error($url);
            curl_close($url);
            return ['error' => $error];
        }

        curl_close($url);

        $response = json_decode($resultData, true);




        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['error' => 'Invalid JSON response from bKash API'];
        }

        if (isset($response['id_token'])) {
            session()->put('bkash_token', $response['id_token']);
            return [
                'success' => true,
                'id_token' => $response['id_token'],
        ];
        } else {
            return ['error' => 'Missing id_token in the bKash API response'];
        }
    }
    public function getVerifyToken()
    {
        $appKey = config('verify.app_key');
        $appSecret = config('verify.app_secret');
        $baseUrl = config('verify.base_url');
        $username = config('verify.username');
        $password = config('verify.password');

        $postToken = [
            'app_key' => $appKey,
            'app_secret' => $appSecret
        ];

        $url = curl_init("$baseUrl/v1.2.0-beta/tokenized/checkout/token/grant");
        $postToken = json_encode($postToken);
        $header = array(
            'Content-Type: application/json',
            'Accept: application/json',
            "password: $password",
            "username: $username"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $postToken);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultData = curl_exec($url);

        if ($resultData === false) {
            $error = curl_error($url);
            curl_close($url);
            return ['error' => $error];
        }

        curl_close($url);

        $response = json_decode($resultData, true);




        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['error' => 'Invalid JSON response from bKash API'];
        }

        if (isset($response['id_token'])) {
            session()->put('bkash_token', $response['id_token']);
            return [
                'success' => true,
                'id_token' => $response['id_token'],
        ];
        } else {
            return ['error' => 'Missing id_token in the bKash API response'];
        }
    }
    public function getBoostToken()
    {
        $appKey = config('boost.app_key');
        $appSecret = config('boost.app_secret');
        $baseUrl = config('boost.base_url');
        $username = config('boost.username');
        $password = config('boost.password');

        $postToken = [
            'app_key' => $appKey,
            'app_secret' => $appSecret
        ];

        $url = curl_init("$baseUrl/v1.2.0-beta/tokenized/checkout/token/grant");
        $postToken = json_encode($postToken);
        $header = array(
            'Content-Type: application/json',
            'Accept: application/json',
            "password: $password",
            "username: $username"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $postToken);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultData = curl_exec($url);

        if ($resultData === false) {
            $error = curl_error($url);
            curl_close($url);
            return ['error' => $error];
        }

        curl_close($url);

        $response = json_decode($resultData, true);




        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['error' => 'Invalid JSON response from bKash API'];
        }

        if (isset($response['id_token'])) {
            session()->put('bkash_token', $response['id_token']);
            return [
                'success' => true,
                'id_token' => $response['id_token'],
        ];
        } else {
            return ['error' => 'Missing id_token in the bKash API response'];
        }
    }



    // public function createPayment($amount, $currency, $merchantReference,$merchantInvoiceNumber,$payerReference)
    // {

    //     $appKey = config('bkash.app_key');
    //     $appSecret = config('bkash.app_secret');
    //     $baseUrl = config('bkash.base_url');
    //     $username = config('bkash.username');
    //     $password = config('bkash.password');

    //     $accessToken = session('bkash_token');

    //     if (!$accessToken) {
    //         return ['error' => 'bKash access token not found.'];
    //     }

    //     $url = curl_init("$baseUrl/v1.2.0-beta/tokenized/checkout/create");
    //     $data = [
    //         'amount' => $this->$amount,
    //         'currency' => $this->$currency,
    //         'merchantInvoiceNumber' => $this->$merchantInvoiceNumber,
    //         'merchantReference' => $this->$merchantReference,
    //         'intent' => 'sale',
    //         'payerReference' => $this->$payerReference,
    //         'callbackURL' => url('/bkash/callBack'),
    //     ];

    //     $headers = [
    //         'Content-Type: application/json',
    //         'Accept: application/json',
    //         'Authorization: Bearer ' . $accessToken,
    //     ];

    //     $response = Http::withHeaders($headers)->post($url, $data);

    //     if ($response->successful()) {
    //         $responseData = $response->json();
    //         return ['success' => true, 'payment_id' => $responseData['payment_id']];
    //     } else {
    //         return ['error' => 'Failed to create payment: ' . $response->status()];
    //     }
    // }

}
