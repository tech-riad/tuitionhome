<?php

use App\Http\Controllers\Frontend\Api\CorporatePartner\CorporatePartnerAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/corporate-partner/register',[CorporatePartnerAuthController::class,'register']);
Route::post('/corporate-partner/login',[CorporatePartnerAuthController::class,'login']);


Route::post('/corporate-partner/verify-phone',[CorporatePartnerAuthController::class, 'VerifyPhone']);
Route::post('/corporate-partner/resend/otp',[CorporatePartnerAuthController::class, 'resend']);
Route::post('/corporate-partner/change-phone',[CorporatePartnerAuthController::class, 'phoneChange']);

Route::group( ['middleware' => ['auth:c-api','scopes:corporate_partners'] ],function(){

});
