<?php

namespace App\Http\Controllers\Frontend\Api\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Counting;
use App\Models\Invoice;
use App\Models\JobApplication;
use App\Models\PackageAmount;
use App\Models\Payment;
use App\Models\PremiumMembership;
use App\Models\SmsBalance;
use App\Models\SmsRecharge;
use App\Models\Tutor;
use App\Models\VerificationRequest;
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

        $payment = null;
        $merchantTransactionId = null;
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

            $paymentData = DB::transaction(function () use (
                $request,
                $invoiceId,
                $merchantTransactionId
            ) {
                $invoice = Invoice::where('id', $request->invoice_id)
                    ->lockForUpdate()
                    ->first();

                if (!$invoice) {
                    return [
                        'response' => response()->json([
                            'success' => false,
                            'message' => 'Invoice not found.',
                        ], 404),
                    ];
                }

                if ($invoice->status === 'paid') {
                    return [
                        'response' => response()->json([
                            'success' => false,
                            'message' => 'This invoice has already been paid.',
                            'retry_allowed' => false,
                        ], 409),
                    ];
                }

                if ($invoice->job_id !== null) {
                    $invoices = Invoice::where('job_id', $invoice->job_id)
                        ->orderBy('id', 'asc')
                        ->get();

                    $unpaidPreviousInvoice = $invoices
                        ->where('id', '<', $invoice->id)
                        ->first(function ($item) {
                            return $item->status !== 'paid';
                        });

                    if ($unpaidPreviousInvoice) {
                        return [
                            'response' => response()->json([
                                'success' => false,
                                'message' => 'Please pay the previous invoice first.',
                                'previous_invoice_id' => $unpaidPreviousInvoice->invoice_number,
                            ], 400),
                        ];
                    }
                }

                $activePayment = Payment::where('invoice_check', $invoice->id)
                    ->whereIn('status', ['pending', 'processing'])
                    ->latest('id')
                    ->first();

                $activePayment->delete();

                if ($activePayment) {
                    $responseData = $activePayment->response_data ?? [];
                    $redirectUrl = $responseData['RedirectURL']
                        ?? $responseData['redirect_url']
                        ?? null;

                    if ($redirectUrl) {
                        return [
                            'response' => response()->json([
                                'success' => true,
                                'message' => 'Payment initialized successfully.',
                                'payment_id' => $activePayment->id,
                                'invoice_id' => $invoice->id,
                                'merchant_transaction_id' => $activePayment->transaction_id,
                                'transaction_id' => $activePayment->eps_transaction_id
                                    ?? ($responseData['TransactionId'] ?? null),
                                'redirect_url' => $redirectUrl,
                            ]),
                        ];
                    }

                    return [
                        'response' => response()->json([
                            'success' => false,
                            'message' => 'The previous payment attempt has no payment link and its status is unknown. Please contact support before trying again.',
                            'payment_status' => $activePayment->status,
                            'retry_allowed' => false,
                            'payment_id' => $activePayment->id,
                            'merchant_transaction_id' => $activePayment->transaction_id,
                        ], 409),
                    ];
                }

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

                return [
                    'invoice' => $invoice,
                    'payment' => $payment,
                ];
            });

            if (isset($paymentData['response'])) {
                return $paymentData['response'];
            }

            $invoice = $paymentData['invoice'];
            $payment = $paymentData['payment'];

            // Do not keep a database transaction open while waiting for EPS.
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

            return response()->json([
                'success' => true,

                'message' =>
                    'Payment initialized successfully.',

                'payment_id' =>
                    $payment->id,

                'invoice_id' =>
                    $invoice->id,

                'merchant_transaction_id' =>
                    $merchantTransactionId,

                'transaction_id' =>
                    $epsResponse['transaction_id'],

                'redirect_url' =>
                    $epsResponse['redirect_url'],
            ], 200);

        } catch (Exception $e) {
            $isTimeout = $e->getCode() === 504
                || stripos($e->getMessage(), 'timed out') !== false
                || stripos($e->getMessage(), 'timeout') !== false;
            $isServerError = $e->getCode() >= 500;
            $outcomeUnknown = $isTimeout || $isServerError;

            if ($payment) {
                $payment->update([
                    'status' => $outcomeUnknown ? 'pending' : 'failed',
                    'response_data' => [
                        'initialize_error' => $e->getMessage(),
                        'outcome_unknown' => $outcomeUnknown,
                    ],
                ]);
            }

            Log::error('EPS Payment Create Error', [
                'message' => $e->getMessage(),
                'payment_id' => $payment ? $payment->id : null,
                'merchant_transaction_id' => $merchantTransactionId,
            ]);

            return response()->json([
                'success' => false,
                'message' => $outcomeUnknown
                    ? 'Payment gateway did not confirm the result. Payment status is unknown; do not retry until this payment is checked.'
                    : 'Unable to start payment right now. Please try again later.',
                'payment_status' => $payment ? $payment->status : null,
                'retry_allowed' => !$outcomeUnknown,
                'payment_id' => $payment ? $payment->id : null,
                'merchant_transaction_id' => $merchantTransactionId,
            ], $isTimeout ? 504 : 502);
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

            // Log::info('EPS Callback', [
            //     'type' => $callbackType,
            //     'data' => $request->all(),
            // ]);

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
                $invoice = Invoice::where(
                    'id',
                    $payment->invoice_check
                )->first();

                if (!$invoice) {
                    throw new Exception('Invoice not found.');
                }

                /*
                 * Prevent duplicate callback processing while allowing an invoice
                 * left pending by an earlier partial callback to be repaired.
                 */
                if ($payment->status !== 'success') {
                    DB::beginTransaction();
                    $payment->update([
                        'status' => 'success',
                        'paid_at' => now(),
                        'response_data' => $verification,
                        'eps_transaction_id' =>
                            $payment->eps_transaction_id
                            ?? ($verification['EPSTransactionId'] ?? null),
                    ]);

                    if ($invoice->job_id != null) {

                        $application = JobApplication::where(
                            'id',
                            $invoice->job_id
                        )->first();

                        // if()

                        if ($application && $application->payment_status == null && $invoice->amount == $application->charge) {
                            $application->update([
                                'paid_date' => now(),
                                'payment_status' => 'paid',
                                'received_amount' => $invoice->amount,
                                'payment_method' =>($verification['FinancialEntity'] ?? null)
                            ]);
                        }elseif ($application && $application->payment_status == 'due' && $invoice->amount == $application->due_amount && $application->received_amount !== null) {
                            $application->update([
                                'due_amount' => 0,
                                'due_complete' => 1,
                                'paid_date' => now(),
                                'payment_status' => 'paid',
                                'received_amount' =>$application->received_amount + $invoice->amount,
                                'payment_method' =>($verification['FinancialEntity'] ?? null)
                            ]);
                        }elseif ($application && $application->payment_status == 'due' && $invoice->amount !== $application->due_amount && $application->received_amount == null) {
                            $application->update([
                                'paid_date' => now(),
                                'received_amount' =>$invoice->amount,
                                'payment_method' =>($verification['FinancialEntity'] ?? null)
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

                    $package = $invoice->package_id
                        ? PackageAmount::find($invoice->package_id)
                        : null;

                    if ($invoice->package_id && !$package) {
                        throw new Exception('Invoice package not found.');
                    }

                    if ($package && $package->type == 'premium') {

                        $membership = PremiumMembership::find($invoice->membership_id);

                        if (!$membership) {
                            throw new Exception('Premium membership not found.');
                        }

                        $membership->update([
                            'request_status' => 'accepted',
                            'payment_status' => 'paid',
                        ]);

                        $tutor = Tutor::find($invoice->tutor_id);

                        if (!$tutor) {
                            throw new Exception('Tutor not found.');
                        }





                        if ($package->package_name == 'regular') {

                            $tutor->update([
                                'premium_date' => now(),
                                'premium_expire' => now()->addMonths($package->duration),

                                'is_premium' => 1,
                                'is_premium_pro' => 0,
                                'is_premium_advance' => 0,
                            ]);

                        } elseif ($invoice->package_name == 'pro') {

                            $tutor->update([
                                'premium_date' => now(),
                                'premium_expire' => now()->addMonths($package->duration),

                                'is_premium' => 0,
                                'is_premium_pro' => 1,
                                'is_premium_advance' => 0,
                            ]);

                        } elseif ($invoice->package_name == 'advance') {

                            $tutor->update([
                                'premium_date' => now(),
                                'premium_expire' => now()->addMonths($package->duration),

                                'is_premium' => 0,
                                'is_premium_pro' => 0,
                                'is_premium_advance' => 1,
                            ]);

                        } else {
                            throw new Exception('Invalid membership package: ' . $invoice->package_name);
                        }

                    }


                    if ($package && $package->type == 'profile_verify') {
                        $verifyRequest = VerificationRequest::find($invoice->verification_id);

                        $tutor = Tutor::find($invoice->tutor_id);

                        if (!$verifyRequest) {
                            throw new Exception('Verification request not found.');
                        }

                        $verifyRequest->update([
                            'payment_status' => 'paid',
                        ]);
                        $tutor->update([
                            'is_verified' => 1,
                            'verify_date' => now(),
                        ]);

                    }
                    if ($package && $package->type == 'boost') {

                        $tutor = Tutor::where('id',$invoice->tutor_id)->first();

                        $tutor->is_boost    = 1;
                        $tutor->boost_date  = today();
                        $tutor->boost_package  = $package->duration;
                        $tutor->boost_expire = now()->addMonths($package->duration);
                        $tutor->update();




                    }

                    if ($package && $package->type == 'sms') {
                        $tutorSmsRecharge = new SmsRecharge();
                        $tutorSmsRecharge->tutor_id = $invoice->tutor_id;
                        $tutorSmsRecharge->payment_method = 'bkash';
                        $tutorSmsRecharge->amount = $package['amount'];
                        $tutorSmsRecharge->invoice_no  = ($verification['EPSTransactionId'] ?? null);
                        $tutorSmsRecharge->recharge_title = 'Sms Recharge';
                        $smsQuantity = 0;
                        try {
                            $costPerSMS = 0.99;
                            $smsQuantity = ($invoice->amount - $invoice->amount * 1.5 / 100) / $costPerSMS;
                            $roundedSmsQuantity = round($smsQuantity);
                            if ($smsQuantity - $roundedSmsQuantity < 0.5) {
                                $smsQuantity = floor($smsQuantity);
                            } else {
                                $smsQuantity = ceil($smsQuantity);
                            }
                        } catch (Exception $e) {
                            // Log::error('Error calculating SMS quantity: ' . $e->getMessage());
                        }

                        $tutorSmsRecharge->sms_quantity = $smsQuantity;
                        $tutorSmsRecharge->costing = 0;
                        $tutorSmsRecharge->save();

                        $smsBalance = SmsBalance::where('tutor_id',$invoice->tutor_id)->first();
                        $smsBalance->available_sms = $smsBalance->available_sms + $smsQuantity;
                        $smsBalance->update();
                    }

                    $invoice->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                        'trx_id' =>($verification['EPSTransactionId'] ?? null),
                        'merchanttrx_id' =>($verification['MerchantTransactionId'] ?? null),
                        'payment_method' =>($verification['FinancialEntity'] ?? null),
                    ]);

                    DB::commit();
                } elseif ($invoice->status !== 'paid') {
                    $invoice->update([
                        'status' => 'paid',
                        'paid_at' => $payment->paid_at ?? now(),
                        'trx_id' => ($verification['EPSTransactionId'] ?? null),
                        'merchanttrx_id' => ($verification['MerchantTransactionId'] ?? null),
                        'payment_method' => ($verification['FinancialEntity'] ?? null),
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
            $status = 'failed';

            if ($callbackType === 'cancel') {
                $status = 'failed';
            }

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
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

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

        $frontendUrl = rtrim(
            (string) (
                 'https://tuitionhome.xyz'
            ),
            '/'
        );


        $query = [
            'status' => $status,
            'message' => $message,
        ];

        if ($payment) {
            $query['invoice_id'] = $payment->invoice_id;
            $query['payment_id'] = $payment->id;
        }

        return redirect()->away(
            $frontendUrl .
            '/payment/result?' .
            http_build_query($query)
        );
    }
}
