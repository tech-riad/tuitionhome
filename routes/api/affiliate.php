<?php

use App\Http\Controllers\Frontend\Api\Affiliate\AffiliateLoginRegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/affiliate/register',[AffiliateLoginRegistrationController::class,'register']);
Route::post('/affiliate/login',[AffiliateLoginRegistrationController::class,'login']);



Route::post('/affiliate/verify-phone',[AffiliateLoginRegistrationController::class, 'VerifyPhone']);
Route::post('/affiliate/resend/otp',[AffiliateLoginRegistrationController::class, 'resend']);
Route::post('/affiliate/change-phone',[AffiliateLoginRegistrationController::class, 'phoneChange']);






Route::group( ['middleware' => ['auth:a-api','scopes:affiliate'] ],function(){

});
