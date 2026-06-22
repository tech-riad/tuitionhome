<?php

use App\Http\Controllers\Frontend\Api\JobOffer\JobofferController;
use App\Http\Controllers\Frontend\Api\Tutor\TutorSmsController;
// use App\Http\Controllers\frontend\api\tutor\TutorSmsController;
use App\Models\SmsBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group( ['middleware' => ['auth:t-api','scopes:tutors'] ],function(){

Route::get('/tutor/sms',[TutorSmsController::class,'index'])->name('tutorSmsBalance');
Route::post('/tutor/sms-recharge',[TutorSmsController::class,'smsRecharge'])->name('smsRecharge');
Route::post('/tutor/sms-log',[TutorSmsController::class,'smsLog'])->name('smsLog');
Route::post('/tutor/sms-log-filter',[TutorSmsController::class,'smsLogFilter'])->name('smsLogFilter');
Route::get('/tutor/sms-trx-history',[TutorSmsController::class,'transctionHistory'])->name('transctionHistory');
Route::post('/tutor/sms-alert',[TutorSmsController::class,'smsAlert'])->name('smsAlert');


});
Route::post('/tutor/grant/token',[TutorSmsController::class,'grantToken'])->name('grantToken');
Route::post('/tutor/create-payment',[TutorSmsController::class,'createPayment'])->name('createPayment');
Route::post('/tutor/execute-payment',[TutorSmsController::class,'executePayment'])->name('executePayment');
