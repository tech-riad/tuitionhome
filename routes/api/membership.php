<?php

use App\Http\Controllers\Frontend\Api\Tutor\MembershipController;
use Illuminate\Support\Facades\Route ;

Route::group( ['middleware' => ['auth:t-api','scopes:tutors'] ],function(){

    Route::get('/tutor/get-membership',[MembershipController::class,'getMembership'])->name('tutor.get.membership');

});

Route::post('/tutor/premium/grant-token',[MembershipController::class,'grantToken'])->name('grantToken');
Route::post('/tutor/premium/create-payment',[MembershipController::class,'createPayment'])->name('createPayment');
Route::post('/tutor/premium/execute-payment',[MembershipController::class,'executePayment'])->name('executePayment');


