<?php

use App\Http\Controllers\Frontend\Api\Tutor\BoostController;
use App\Http\Controllers\Frontend\Api\Tutor\MembershipController;
use Illuminate\Support\Facades\Route ;

Route::group( ['middleware' => ['auth:t-api','scopes:tutors'] ],function(){

    Route::get('/tutor/get-boost-status',[BoostController::class,'getBoostStatus'])->name('tutor.get.boostStatus');

});

Route::post('/tutor/boost/grant-token',[BoostController::class,'grantToken'])->name('grantToken');
Route::post('/tutor/boost/create-payment',[BoostController::class,'createPayment'])->name('createPayment');
Route::post('/tutor/boost/execute-payment',[BoostController::class,'executePayment'])->name('executePayment');