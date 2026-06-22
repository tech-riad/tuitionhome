<?php

use App\Http\Controllers\Frontend\Api\JobOffer\JobofferController;
use Illuminate\Http\Request;
use App\Http\Controllers\Frontend\Api\Parent\ParentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\Api\Parent\PersonalInformationController;
use App\Http\Controllers\ReviewsController;

Route::post('/parent/register',[ParentController::class,'register']);
Route::post('/parent/login',[ParentController::class,'login']);

Route::post('/parent/verified-phone',[ParentController::class, 'VerifyPhone']);
Route::post('/parent/resend/otp',[ParentController::class, 'resend']);
Route::get('/get-all-parents',[ParentController::class, 'allUser']);
Route::post('/parent/change-parent-phone',[ParentController::class, 'phoneChange']);

Route::post('/parent/forgot-password',[ParentController::class,'checkPhone']);
Route::post('/parent/update-password',[ParentController::class,'updatePassword']);
Route::post('/parent/phone-verify',[ParentController::class,'verifyOtpAndSavePassword']);



Route::post('/parent/forgot-password-email',[ParentController::class,'checkEmail']);
Route::post('/parent/update-password-email',[ParentController::class,'updatePassword']);
Route::post('/parent/phone-verify-email',[ParentController::class,'verifyOtp']);

Route::post('/parent/forgot-password-by-email',[ParentController::class,'checkResetEmail']);
Route::post('/parent/update-password-by-email',[ParentController::class,'updateResetPasswordEmail']);
Route::any('/parent/by-otp-email-verify',[ParentController::class,'verifyResetOtp']);
Route::any('/reset-password-by-email', [ParentController::class, 'verifyResetLinkEmail']);


Route::group( ['middleware' => ['auth:p-api','scopes:parents'] ],function(){
    // authenticated staff routes here
    Route::post('/parent/update-name',[ParentController::class, 'updateName']);
    Route::post('/parent/update-phone',[ParentController::class, 'updatePhone']);
    Route::post('/parent/verify-otp-for-update-phone',[ParentController::class,'verifyPhoneOtpAndUpdate']);
    Route::post('/parent/resend-otp-verification',[ParentController::class,'resendOtpVeryficationCode']);
    
    Route::any('parent/lat-long-save',[ParentController::class,'latLongSave'])->name('lat.long.save');
    Route::any('parent/lat-long-get',[ParentController::class,'latLongGate'])->name('lat.long.get');


    // Route::post('/parent/verified-phone',[ParentController::class, 'VerifyPhone']);
    Route::post('/parent/update-email',[ParentController::class, 'updateEmail']);
    Route::post('/parent/verified-email',[ParentController::class, 'emailVerified']);
    Route::post('/parent/change-password',[ParentController::class, 'change_password']);

    // Route::post('/parent/verified-phone',[ParentController::class, 'VerifyPhone']);
    // Route::post('/parent/update-email',[ParentController::class, 'updateEmail']);
    // Route::post('/parent/verified-email',[ParentController::class, 'emailVerified']);
    // Route::post('/parent/change-password',[ParentController::class, 'change_password']);

    Route::get('/parent/get-user',[PersonalInformationController::class, 'allInfoShow']);


//    contact information route
    Route::post('/parent/contact-info',[PersonalInformationController::class, 'ContactInfoUpdate']);
    Route::post('/parent/personal-info',[PersonalInformationController::class, 'personalInfoUpdate']);
    Route::post('/parent/kids-info',[PersonalInformationController::class, 'kidsInfoUpdate']);

//    parents create job route
    Route::post('/parent/store-job',[ParentController::class, 'jobStore']);

    //    parents create FNF referance job route
    Route::post('/parent/fnf-referance',[ParentController::class, 'fnfStore']);


//    parents logout route
    Route::post('/parent/logout',[ParentController::class, 'logout']);



    Route::any('/parent/live-on-job',[ParentController::class, 'liveOnJob']);
    Route::any('/parent/live-off-job',[ParentController::class, 'liveOffJob']);

    Route::get('/parent/request-job-status/{id}',[ParentController::class, 'requestJobStatus']);
    Route::get('/parent/posted-job-status/{id}',[ParentController::class, 'requestPostedJobStatus']);


    Route::get('/parent/job-status/{id}',[ParentController::class, 'parentJobStatus']);
    Route::get('/parent/reffer-fnf-job-status/{id}',[ParentController::class, 'parentFnfJobStatus']);

    Route::get('/parent/confirm-latter/{id}',[ParentController::class, 'parentConfirmLatter']);
    Route::post('/parent/confirm-latter-status/{id}',[ParentController::class, 'parentConfirmLatterStatus']);

    Route::post('/parent/request/send',[ParentController::class, 'sendRequest']);
    Route::any('/parent/tutor-and-category/request',[ParentController::class, 'tutorCategoryRequest']);

    Route::any('/parent/tutor-and-category/request',[ParentController::class, 'tutorCategoryRequest']);
    Route::any('/parent/tutor-and-category/search',[ParentController::class, 'tutorCategorySearch']);
    Route::any('/parent/tutor-and-category/request-filter',[ParentController::class, 'tutorCategoryRequestfilter']);


    Route::post('/parent/profile-image-upload',[ParentController::class,'profileImageUpload']);

    Route::get('/parent/popup-image-data',[ParentController::class,'popupImageData']);

    Route::post('/parent/sms-alert',[ParentController::class,'smsAlert'])->name('smsAlert');

    Route::post('/parent/active-deactive-account',[ParentController::class,'activeDeactiveAccount']);

    Route::get('/parent/get-video-tutorial',[ParentController::class,'getTutorial']);

    // Reviews
    Route::post('/parent/send-tutor-reviews',[ReviewsController::class,'sendReviews']);
    Route::post('/parent/send-category-reviews',[ReviewsController::class,'sendCategoryReviews']);

    // Job External info
    Route::get('/parent/job-offer-details-info/{id}',[JobofferController::class,'jobExtraInfo']);

});