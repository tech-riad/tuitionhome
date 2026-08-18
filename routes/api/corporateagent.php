<?php

use App\Http\Controllers\Frontend\Api\CorporateAgent\CorporateAgentAuthController;
use App\Http\Controllers\Frontend\Api\CorporateAgent\CorporateAgentCOntroller;
use Illuminate\Support\Facades\Route;

Route::post('/corporate-agent/register', [CorporateAgentAuthController::class, 'register']);
Route::post('/corporate-agent/login', [CorporateAgentAuthController::class, 'login']);
Route::post('/corporate-agent/phone-verified', [CorporateAgentAuthController::class, 'verifyPhone']);
Route::post('/corporate-agent/resend-otp', [CorporateAgentAuthController::class, 'resendOtp']);


Route::post('/corporate-agent/forgot-password',[CorporateAgentAuthController::class,'checkPhone']);
Route::post('/corporate-agent/update-password',[CorporateAgentAuthController::class,'updatePassword']);
Route::post('/corporate-agent/phone-verify',[CorporateAgentAuthController::class,'verifyOtpAndSavePassword']);

Route::group(['middleware' => ['auth:ca-api', 'scopes:corporate_agents']], function () {
    Route::post('/corporate-agent/basic-info', [CorporateAgentAuthController::class, 'basicInfo']);
    Route::post('/corporate-agent/logout', [CorporateAgentAuthController::class, 'logout']);

    Route::get('/get-corporate-agent',[CorporateAgentCOntroller::class,'getCorporateAgent']);

    Route::post('/corporate-agent/update-personal-info', [CorporateAgentCOntroller::class, 'updatePersonalInfo']);
    Route::post('/corporate-agent/update-contact-info', [CorporateAgentCOntroller::class, 'updateContactInfo']);
});
