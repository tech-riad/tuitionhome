<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class EPSPaymentService
{
    protected $baseUrl;
    protected $hashKey;
    protected $username;
    protected $password;
    protected $storeId;
    protected $merchantId;
    protected $deviceTypeId;

    public function __construct()
    {
        $this->baseUrl      = rtrim(config('services.eps.base_url'), '/');
        $this->hashKey      = config('services.eps.hash_key');
        $this->username     = config('services.eps.username');
        $this->password     = config('services.eps.password');
        $this->storeId      = config('services.eps.store_id');
        $this->merchantId   = config('services.eps.merchant_id');
        $this->deviceTypeId = config('services.eps.device_type');

        if (empty($this->baseUrl)) {
            throw new Exception(
                'EPS base URL is not configured. Set EPS_BASE_URL in .env.'
            );
        }
    }

    /**
     * Generate EPS x-hash
     *
     * EPS documentation:
     * 1. Encode Hash Key using UTF8
     * 2. Create HMACSHA512 using encoded data
     * 3. Compute hash using HMAC and UserID / Other Key
     * 4. Return Base64
     */
    protected function generateHash($value)
    {
        $key = utf8_encode($this->hashKey);

        $hmac = hash_hmac(
            'sha512',
            $value,
            $key,
            true
        );

        return base64_encode($hmac);
    }

    /**
     * API 01
     * Get EPS Token
     */
    public function getToken()
    {
        $hash = $this->generateHash($this->username);

        $response = Http::withHeaders([
            'x-hash' => $hash,
            'Content-Type' => 'application/json',
        ])->post(
            $this->baseUrl . '/v1/Auth/GetToken',
            [
                'userName' => $this->username,
                'password' => $this->password,
            ]
        );

        if (!$response->successful()) {
            throw new Exception(
                'EPS GetToken HTTP Error: ' . $response->body()
            );
        }

        $data = $response->json();

        if (empty($data['token'])) {
            throw new Exception(
                'EPS Token Error: ' .
                ($data['errorMessage'] ?? 'Unable to get token')
            );
        }

        return $data;
    }

    /**
     * API 02
     * Initialize EPS Payment
     */
    public function initializePayment(array $paymentData)
    {
        $tokenResponse = $this->getToken();

        $token = $tokenResponse['token'];

        $merchantTransactionId = $paymentData['merchantTransactionId'];

        // Hash must be generated using merchantTransactionId
        $hash = $this->generateHash($merchantTransactionId);

        $body = [
            'merchantId' => $this->merchantId,
            'storeId' => $this->storeId,

            'CustomerOrderId' =>
                $paymentData['customerOrderId'],

            'merchantTransactionId' =>
                $merchantTransactionId,

            'transactionTypeId' =>
                $this->deviceTypeId,

            'financialEntityId' => 0,
            'transitionStatusId' => 0,

            'totalAmount' =>
                $paymentData['totalAmount'],

            'ipAddress' =>
                $paymentData['ipAddress'],

            'version' => '1',

            'successUrl' =>
                $paymentData['successUrl'],

            'failUrl' =>
                $paymentData['failUrl'],

            'cancelUrl' =>
                $paymentData['cancelUrl'],

            'customerName' =>
                $paymentData['customerName'],

            'customerEmail' =>
                $paymentData['customerEmail'],

            'CustomerAddress' =>
                $paymentData['customerAddress'],

            'CustomerAddress2' =>
                $paymentData['customerAddress2'] ?? '',

            'CustomerCity' =>
                $paymentData['customerCity'],

            'CustomerState' =>
                $paymentData['customerState'],

            'CustomerPostcode' =>
                $paymentData['customerPostcode'],

            'CustomerCountry' =>
                $paymentData['customerCountry'],

            'CustomerPhone' =>
                $paymentData['customerPhone'] ?? '',

            'ShipmentName' =>
                $paymentData['shipmentName'] ?? '',

            'ShipmentAddress' =>
                $paymentData['shipmentAddress'] ?? '',

            'ShipmentAddress2' =>
                $paymentData['shipmentAddress2'] ?? '',

            'ShipmentCity' =>
                $paymentData['shipmentCity'] ?? '',

            'ShipmentState' =>
                $paymentData['shipmentState'] ?? '',

            'ShipmentPostcode' =>
                $paymentData['shipmentPostcode'] ?? '',

            'ShipmentCountry' =>
                $paymentData['shipmentCountry'] ?? '',

            'ValueA' =>
                $paymentData['valueA'] ?? '',

            'ValueB' =>
                $paymentData['valueB'] ?? '',

            'ValueC' =>
                $paymentData['valueC'] ?? '',

            'ValueD' =>
                $paymentData['valueD'] ?? '',

            'ShippingMethod' =>
                $paymentData['shippingMethod'] ?? 'NO',

            'NoOfItem' =>
                $paymentData['noOfItem'] ?? '1',

            'ProductName' =>
                $paymentData['productName'],

            'ProductProfile' =>
                $paymentData['productProfile'] ?? 'general',

            'ProductCategory' =>
                $paymentData['productCategory'] ?? 'General',
        ];

        $response = Http::withHeaders([
            'x-hash' => $hash,
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->post(
            $this->baseUrl . '/v1/EPSEngine/InitializeEPS',
            $body
        );

        if (!$response->successful()) {
            throw new Exception(
                'EPS Initialize HTTP Error: ' . $response->body()
            );
        }

        $data = $response->json();

        if (empty($data['RedirectURL'])) {
            throw new Exception(
                'EPS Initialize Error: ' .
                ($data['ErrorMessage'] ?? 'Unable to initialize payment')
            );
        }

        return [
            'token' => $token,
            'transaction_id' => $data['TransactionId'] ?? null,
            'redirect_url' => $data['RedirectURL'],
            'response' => $data,
        ];
    }

    /**
     * API 03
     * Verify Transaction
     */
    public function verifyTransaction($merchantTransactionId)
    {
        $tokenResponse = $this->getToken();

        $token = $tokenResponse['token'];

        $hash = $this->generateHash($merchantTransactionId);

        $url = $this->baseUrl .
            '/v1/EPSEngine/CheckMerchantTransactionStatus';

        $response = Http::withHeaders([
            'x-hash' => $hash,
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->get($url, [
            'merchantTransactionId' => $merchantTransactionId,
        ]);

        if (!$response->successful()) {
            throw new Exception(
                'EPS Verification HTTP Error: ' . $response->body()
            );
        }

        return $response->json();
    }
}
