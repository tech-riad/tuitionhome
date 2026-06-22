<?php

use App\Http\Controllers\Frontend\Api\Tutor\MembershipController;
use App\Http\Controllers\Frontend\Api\Tutor\VerificationController;
use Illuminate\Support\Facades\Route ;

Route::group( ['middleware' => ['auth:t-api','scopes:tutors'] ],function(){

    Route::get('/tutor/get-verification-status',[VerificationController::class,'getVerify'])->name('tutor.get.verify');

});

Route::post('/tutor/verify/grant-token',[VerificationController::class,'grantToken'])->name('grantToken');
Route::post('/tutor/verify/create-payment',[VerificationController::class,'createPayment'])->name('createPayment');
Route::post('/tutor/verify/execute-payment',[VerificationController::class,'executePayment'])->name('executePayment');


