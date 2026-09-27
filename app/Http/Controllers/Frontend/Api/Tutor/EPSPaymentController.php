<?php

namespace App\Http\Controllers\Frontend\Api\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Counting;
use App\Models\Invoice;
use App\Models\JobApplication;
use App\Models\Payment;
use App\Services\EPSPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

class EPSPaymentController extends Controller
{
    protected $eps;

    public function __construct(EPSPaymentService $eps)
    {
        $this->eps = $eps;
    }

    /**
     * Create EPS Payment
     *
     * React -> Laravel -> EPS
     */
    public function createPayment(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|string|max:255',


        ]);

        DB::beginTransaction();

        try {

            /*
             * Unique order ID
             */
            $invoiceId = 'INV-' . date('YmdHis') . '-' . strtoupper(Str::random(6));

            /*
             * EPS requires minimum 10 digit unique merchantTransactionId
             */
            $merchantTransactionId =
                date('YmdHis') . rand(1000, 9999);

            /*
             * Create local payment first
             */
            $invoice = Invoice::where('id', $request->invoice_id)->first();
            $payment = Payment::create([
                'user_id' => auth()->check()
                    ? auth()->id()
                    : null,

                'invoice_id' => $invoiceId,
                'invoice_check' => $invoice->id,

                'transaction_id' => $merchantTransactionId,

                'amount' => $invoice->amount,

                'currency' => 'BDT',

                'payment_method' => 'EPS',

                'status' => 'pending',

                'request_data' => $request->all(),
            ]);

            /*
             * EPS Initialize
             */
            $epsResponse = $this->eps->initializePayment([

                'customerOrderId' => $invoiceId,

                'merchantTransactionId' =>
                    $merchantTransactionId,

                'totalAmount' =>
                    number_format(
                        (float) $invoice->amount,
                        2,
                        '.',
                        ''
                    ),

                'ipAddress' =>
                    $request->ip(),

                /*
                 * IMPORTANT:
                 * These must be publicly accessible URLs.
                 */
                'successUrl' =>
                    route('eps.payment.success'),

                'failUrl' =>
                    route('eps.payment.fail'),

                'cancelUrl' =>
                    route('eps.payment.cancel'),

                'customerName' =>
                    $request->customer_name ?? 'TuitionHome Customer',

                'customerEmail' =>
                    $request->customer_email ?? '',

                'customerAddress' =>
                    $request->customer_address ?? '',

                'customerAddress2' =>
                    $request->customer_address2 ?? '',

                'customerCity' =>
                    $request->customer_city ?? '',

                'customerState' =>
                    $request->customer_state ?? '',

                'customerPostcode' =>
                    $request->customer_postcode ?? '',

                'customerCountry' =>
                    $request->customer_country ?? '',

                'customerPhone' =>
                    $request->customer_phone ?? '',

                'shipmentName' =>
                    $request->customer_name ?? '',

                'shipmentAddress' =>
                    $request->customer_address ?? '',

                'shipmentAddress2' =>
                    $request->customer_address2 ?? '',

                'shipmentCity' =>
                    $request->customer_city ?? '',

                'shipmentState' =>
                    $request->customer_state ?? '',

                'shipmentPostcode' =>
                    $request->customer_postcode ?? '',

                'shipmentCountry' =>
                    $request->customer_country ?? '',

                'valueA' =>
                    $invoiceId,

                'valueB' =>
                    '',

                'valueC' =>
                    '',

                'valueD' =>
                    '',

                'shippingMethod' =>
                    'NO',

                'noOfItem' =>
                    '1',

                'productName' =>
                    $request->product_name ?? 'TuitionHome Payment',

                'productProfile' =>
                    'general',

                'productCategory' =>
                    'General',
            ]);
            // dd($epsResponse);

            /*
             * Save EPS response
             */
            $payment->update([
                'eps_transaction_id' =>
                    $epsResponse['transaction_id'],

                'status' => 'processing',

                'response_data' =>
                    $epsResponse['response'],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,

                'message' =>
                    'Payment initialized successfully.',

                'payment_id' =>
                    $payment->id,

                'invoice_id' =>
                    $payment->invoice_id,

                'merchant_transaction_id' =>
                    $merchantTransactionId,

                'transaction_id' =>
                    $epsResponse['transaction_id'],

                'redirect_url' =>
                    $epsResponse['redirect_url'],
            ], 200);

        } catch (Exception $e) {

            DB::rollBack();

            Log::error('EPS Payment Create Error', [
                'message' => $e->getMessage(),
                'request' => $request->except([
                    'password',
                    'card',
                    'cvv',
                ]),
            ]);

            return response()->json([
                'success' => false,
                'message' =>
                    $e->getMessage(),
            ], 500);
        }
    }


    /**
     * EPS Success Callback
     */
    public function success(Request $request)
    {
        return $this->processCallback($request, 'success');
    }


    /**
     * EPS Failed Callback
     */
    public function fail(Request $request)
    {
        return $this->processCallback($request, 'failed');
    }


    /**
     * EPS Cancel Callback
     */
    public function cancel(Request $request)
    {
        return $this->processCallback($request, 'cancelled');
    }


    /**
     * Process EPS callback
     */
    protected function processCallback(
        Request $request,
        $callbackType
    ) {
        try {

            Log::info('EPS Callback', [
                'type' => $callbackType,
                'data' => $request->all(),
            ]);

            /*
             * EPS documentation says callback data
             * comes through query string.
             *
             * merchantTransactionId is expected.
             */
            $merchantTransactionId =
                $request->query('merchantTransactionId')
                ?? $request->query('MerchantTransactionId')
                ?? $request->query('merchantTransactionID');

            if (!$merchantTransactionId) {

                return $this->redirectToFrontend(
                    'failed',
                    null,
                    'Merchant transaction ID missing.'
                );
            }

            /*
             * Find local payment
             */
            $payment = Payment::where(
                'transaction_id',
                $merchantTransactionId
            )->first();

            if (!$payment) {

                return $this->redirectToFrontend(
                    'failed',
                    null,
                    'Payment record not found.'
                );
            }

            /*
             * ALWAYS verify with EPS.
             *
             * Do not trust callback status alone.
             */
            $verification =
                $this->eps->verifyTransaction(
                    $merchantTransactionId
                );

            Log::info('EPS Verification', [
                'merchant_transaction_id' =>
                    $merchantTransactionId,

                'response' =>
                    $verification,
            ]);

            $epsStatus =
                strtolower(
                    $verification['Status'] ?? ''
                );

            /*
             * Verify amount as well
             */
            $epsAmount =
                isset($verification['TotalAmount'])
                    ? (float) $verification['TotalAmount']
                    : null;

            $localAmount =
                (float) $payment->amount;

            /*
             * SUCCESS
             */
            if (
                $epsStatus === 'success' &&
                $epsAmount !== null &&
                abs($epsAmount - $localAmount) < 0.01
            ) {

                /*
                * Prevent duplicate callback processing
                */
                if ($payment->status !== 'success') {

                    $payment->update([
                        'status' => 'success',
                        'paid_at' => now(),
                        'response_data' => $verification,
                        'eps_transaction_id' =>
                            $payment->eps_transaction_id
                            ?? ($verification['TransactionId'] ?? null),
                    ]);

                    $invoice_id = $payment->invoice_check;

                    $invoice = Invoice::where('id', $invoice_id)->first();

                    if (!$invoice) {
                        throw new Exception('Invoice not found.');
                    }

                    if ($invoice->job_id != null) {

                        $application = JobApplication::where(
                            'id',
                            $invoice->job_id
                        )->first();

                        if ($application) {
                            $application->update([
                                'paid_date' => now(),
                                'payment_status' => 'paid',
                                'received_amount' => $invoice->amount,
                            ]);
                        }

                        $counting = Counting::where(
                            'tutor_id',
                            $invoice->tutor_id
                        )->first();

                        if ($counting) {
                            $counting->payment_job =
                                ($counting->payment_job ?? 0) + 1;

                            $counting->save();
                        }
                    }

                    $invoice->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                    ]);
                }

                return $this->redirectToFrontend(
                    'success',
                    $payment,
                    'Payment successful.'
                );
            }


            /*
             * Failed / Cancelled
             */
            $status =
                $callbackType === 'cancel'
                    ? 'cancelled'
                    : 'failed';

            $payment->update([
                'status' => $status,

                'response_data' =>
                    $verification,
            ]);

            return $this->redirectToFrontend(
                $status,
                $payment,
                $verification['ErrorMessage']
                    ?? 'Payment was not successful.'
            );

        } catch (Exception $e) {

            Log::error('EPS Callback Error', [
                'message' => $e->getMessage(),

                'request' =>
                    $request->all(),
            ]);

            return $this->redirectToFrontend(
                'failed',
                null,
                'Unable to verify payment.'
            );
        }
    }


    /**
     * Redirect customer to React
     */
    protected function redirectToFrontend(
        $status,
        $payment = null,
        $message = null
    ) {

        $frontendUrl =
            config('app.frontend_url');

        $params = [
            'status' => $status,

            'message' => $message,

            'invoice_id' =>
                $payment
                    ? $payment->invoice_id
                    : null,

            'payment_id' =>
                $payment
                    ? $payment->id
                    : null,
        ];

        return redirect()->away(
            $frontendUrl .
            '/payment/result?' .
            http_build_query($params)
        );
    }
}
