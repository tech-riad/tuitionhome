<?php

namespace Tests\Unit;

use App\Services\EPSPaymentService;
use Exception;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class EPSPaymentServiceTest extends TestCase
{
    public function test_initialize_timeout_does_not_expose_gateway_html()
    {
        config([
            'services.eps.base_url' => 'https://eps.example.test',
            'services.eps.hash_key' => 'test-hash-key',
            'services.eps.username' => 'test-user',
            'services.eps.password' => 'test-password',
            'services.eps.store_id' => 'test-store',
            'services.eps.merchant_id' => 'test-merchant',
            'services.eps.device_type' => '1',
        ]);

        Http::fake([
            '*GetToken' => Http::response(['token' => 'test-token']),
            '*InitializeEPS' => Http::response(
                '<html><h1>504 Gateway Time-out</h1></html>',
                504
            ),
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionCode(504);
        $this->expectExceptionMessage('EPS Initialize HTTP Error: HTTP 504');

        app(EPSPaymentService::class)->initializePayment([
            'merchantTransactionId' => '2026110721341234',
            'customerOrderId' => 'INV-TEST',
            'totalAmount' => '100.00',
            'ipAddress' => '127.0.0.1',
            'successUrl' => 'https://example.test/success',
            'failUrl' => 'https://example.test/fail',
            'cancelUrl' => 'https://example.test/cancel',
            'customerName' => 'Test Customer',
            'customerEmail' => 'test@example.test',
            'customerAddress' => '',
            'customerCity' => '',
            'customerState' => '',
            'customerPostcode' => '',
            'customerCountry' => '',
            'productName' => 'Test Payment',
        ]);
    }
}
