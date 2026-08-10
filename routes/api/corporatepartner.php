<?php

use App\Http\Controllers\Frontend\Api\CorporatePartner\CorporatePartnerAuthController;
use App\Http\Controllers\Frontend\Api\CorporatePartner\CorporatePartnerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/corporate-partner/register',[CorporatePartnerAuthController::class,'register']);
Route::post('/corporate-partner/login',[CorporatePartnerAuthController::class,'login']);


Route::post('/corporate-partner/verify-phone',[CorporatePartnerAuthController::class, 'VerifyPhone']);
// Route::post('/corporate-partner/resend/otp',[CorporatePartnerAuthController::class, 'resendRegisterOtp']);
Route::post('/corporate-partner/change-phone',[CorporatePartnerAuthController::class, 'phoneChange']);


Route::post('/corporate-partner/phone-verified',[CorporatePartnerAuthController::class,'verifyOtpAndSave']);
Route::post('/corporate-partner/register/resend/otp',[CorporatePartnerAuthController::class,'resendRegisterOtp']);

Route::post('/corporate-partner/forgot-password',[CorporatePartnerAuthController::class,'checkPhone']);
Route::post('/corporate-partner/update-password',[CorporatePartnerAuthController::class,'updatePassword']);
Route::post('/corporate-partner/phone-verify',[CorporatePartnerAuthController::class,'verifyOtpAndSavePassword']);

Route::group( ['middleware' => ['auth:c-api','scopes:corporate_partners'] ],function(){
    Route::post('/corporate-partner/logout',[CorporatePartnerAuthController::class,'logout']);
    Route::post('/corporate-partner/basic-info',[CorporatePartnerAuthController::class,'basicInfo']);


    Route::get('/get-corporate-partner',[CorporatePartnerController::class,'getCorporatePartner']);

    Route::post('/corporate-partner/update-personal-info', [CorporatePartnerController::class, 'updatePersonalInfo']);
    Route::post('/corporate-partner/update-contact-info', [CorporatePartnerController::class, 'updateContactInfo']);

});
