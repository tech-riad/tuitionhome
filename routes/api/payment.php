<?php

use App\Http\Controllers\Frontend\Api\Tutor\PaymentController;
use Illuminate\Support\Facades\Route ;

Route::group( ['middleware' => ['auth:t-api','scopes:tutors'] ],function(){

    Route::get('/tutor/payment-pending',[PaymentController::class,'paymentPending'])->name('tutor.payment.pending');
    Route::get('/tutor/payment-due',[PaymentController::class,'paymentDue'])->name('tutor.payment.due');
    Route::get('/tutor/balance',[PaymentController::class,'tutorBalance'])->name('tutor.balance');

    Route::post('/tutor/payment',[PaymentController::class,'payment'])->name('payment');
    Route::post('/tutor/refund-apply',[PaymentController::class,'refundApply'])->name('refundApply');

    Route::get('/tutor/invoice',[PaymentController::class,'tutorInvoice'])->name('tutorInvoice');
    Route::get('/tutor/refund-payment',[PaymentController::class,'refundStatus'])->name('refundStatus');

    Route::get('/tutor/payment-transction',[PaymentController::class,'paymentTrx'])->name('paymentTrx');
    Route::get('/tutor/membership-transction',[PaymentController::class,'membershipTrx'])->name('membershipTrx');
    Route::get('/tutor/refund-transction',[PaymentController::class,'refundTrx'])->name('refundTrx');


    Route::any('/tutor/tutor-account-save',[PaymentController::class,'tutorAccount'])->name('tutor.account');
    Route::get('/tutor/tutor-account-info',[PaymentController::class,'tutorAccountInfo'])->name('tutor.account.info');


});

Route::post('/tutor/payment/grant-token',[PaymentController::class,'grantToken'])->name('grantToken');
Route::post('/tutor/payment/create-payment',[PaymentController::class,'createPayment'])->name('createPayment');
Route::post('/tutor/payment/execute-payment',[PaymentController::class,'executePayment'])->name('executePayment');
