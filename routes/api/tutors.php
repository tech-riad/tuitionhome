<?php

use App\Http\Controllers\Frontend\Api\Application\JobApplicationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\Api\CountryCityLocationController;
use App\Http\Controllers\Frontend\Api\CategoryCourseSubjectController;
use App\Http\Controllers\Frontend\Api\Tutor\TutorLoginRegisterController;
use App\Http\Controllers\Frontend\Api\Tutor\TutorController;
use App\Http\Controllers\Frontend\Tutor\TutorController as TutorTutorController;


Route::get('/tutor/get-profile-picture/{id}',[TutorController::class,'getProfilePicture']);
Route::post('/tutor/register',[TutorLoginRegisterController::class,'registerStore']);
Route::post('/tutor/login',[TutorLoginRegisterController::class,'login']);
Route::post('/tutor/phone-change',[TutorLoginRegisterController::class,'phoneChange']);
Route::post('/tutor/phone-verified',[TutorLoginRegisterController::class,'verifyOtpAndSave']);
Route::post('/tutor/register/resend/otp',[TutorLoginRegisterController::class,'resendRegisterOtp']);
// Route::post('/tutor/phone-verified',[TutorLoginRegisterController::class,'VerifyPhone']);
Route::post('/tutor/resend/otp',[TutorLoginRegisterController::class,'resend']);
Route::get('/get-all-tutors',[TutorLoginRegisterController::class,'allUser']);
Route::get('/get-counting',[TutorController::class,'allCounting']);


Route::post('/tutor/forgot-password',[TutorController::class,'checkPhone']);
Route::post('/tutor/update-password',[TutorController::class,'updatePassword']);
Route::post('/tutor/phone-verify',[TutorController::class,'verifyOtpAndSavePassword']);


Route::post('/tutor/forgot-password-email',[TutorController::class,'checkEmail']);
Route::post('/tutor/update-password-email',[TutorController::class,'updatePasswordEmail']);
Route::any('/tutor/email-verify',[TutorController::class,'verifyOtp']);
Route::get('/reset-password', [TutorController::class, 'verifyResetLink'])->name('password.reset');



Route::get('/tutor/get-video-tutorial',[TutorController::class,'getTutorial']);

Route::get('/tutor/get-tutoring-platform-status/{unique_id}',[TutorController::class,'platformStatus']);



//Route::prefix('api-tutor.')->group(function (){
    Route::group( ['middleware' => ['auth:t-api','scopes:tutors'] ],function(){
        Route::get('/tutor/tutor-profile-completed',[TutorController::class,'profileCompletion']);

        Route::any('tutor/lat-long-save',[TutorController::class,'latLongSave'])->name('lat.long.save');
        Route::any('tutor/lat-long-get',[TutorController::class,'latLongGate'])->name('lat.long.get');


        // apply tutor
        Route::post('/joboffer/apply',[JobApplicationController::class,'apply']);
        // Get Job History
        Route::get('/tutor/get-tutoring-history',[TutorController::class,'tutoringHistory']);
        Route::get('/tutor/get-applied-job',[TutorController::class,'appliedJob']);
        Route::get('/tutor/get-appointed-job',[TutorController::class,'appointedJob']);
        Route::get('/tutor/get-shortlisted-job',[TutorController::class,'shortlistedJob']);
        Route::get('/tutor/get-confirmed-job',[TutorController::class,'confirmJob']);
        Route::get('/tutor/get-payment-complete-job',[TutorController::class,'paymentCompleteJob']);
        Route::get('/tutor/get-payment-due-job',[TutorController::class,'dueJob']);
        Route::get('/tutor/get-canceled-job',[TutorController::class,'canceledJob']);
        Route::get('/tutor/get-current-status-job',[TutorController::class,'currentStatusJob']);
        Route::get('/tutor/get-refund-job',[TutorController::class,'refundJob']);





        Route::get('/tutor/categories-courses/{id}',[TutorController::class,'getTutor']);

        // tutor route
        Route::post('/tutor/info-save',[TutorController::class,'store']);
        Route::post('/tutor/profile-image-upload',[TutorController::class,'profileImageUpload']);
        Route::post('/tutor/crediantial_store',[TutorController::class,'credentialStore']);
        Route::get('/tutor/crediantials',[TutorController::class,'credentialGet']);
        Route::get('/tutor/get-tutor/{id}',[TutorController::class,'showTutor']);
        Route::get('/tutor/get-tutor-image/{id}',[TutorController::class,'getImage']);
        Route::post('/tutor/store-tutoring-info',[TutorController::class,'tutorInfoSave']);
        Route::post('/tutor/store-education-info',[TutorController::class,'educationInfoSave']);
        Route::post('/tutor/store-personal-info',[TutorController::class,'personalInfoSave']);
        Route::post('/tutor/update-name',[TutorController::class,'updateName']);
        Route::post('/tutor/update-phone',[TutorController::class,'updatePhone']);
        Route::post('/tutor/verify-otp-for-update-phone',[TutorController::class,'verifyPhoneOtpAndUpdate']);
        Route::post('/tutor/update-email',[TutorController::class,'updateEmail']);
        Route::post('/tutor/resend-otp-verification',[TutorController::class,'resendOtpVeryficationCode']);
        Route::post('/tutor/email-otp-verifiy',[TutorController::class,'verifyEmailOtp']);
        Route::post('/tutor/change-password',[TutorController::class,'changePassword']);
        Route::post('/tutor/active-deactive-account',[TutorController::class,'activeDeactiveAccount']);
        Route::post('/tutor/logout',[TutorController::class,'logout']);
        Route::post('/tutor/type-institute',[TutorController::class,'tutorTypeUniversity']);

        // Password reset


        Route::post('/tutor/verify-email',[TutorController::class,'emailVerify']);
        Route::get('/tutor/job-counting',[JobApplicationController::class,'counting']);
        // Route::get('/tutor/job-view-count/{id}', [JobApplicationController::class, 'viewCounting']);

        Route::post('/tutor/update-tutor-status',[TutorController::class,'updateStatus'])->name('update-tutor-status');
        // Premium Membershipp Request
        Route::get('/tutor/get-premimum-membership-request-status',[TutorController::class,'getmembershipStatus']);
        Route::post('/tutor/send-premimum-membership-request-status',[TutorController::class,'sendMembershipRequest']);
        Route::post('/tutor/prefered-location-job',[TutorController::class,'preferedLocationJob']);
        // Route::post('/tutor/prefered-location-job-counting',[TutorController::class,'preferedLocationJob']);

        Route::post('/tutor/send-verify-request-status',[TutorController::class,'sendVerifyRequest']);
        Route::post('/tutor/send-affiliate-request',[TutorController::class,'sendAffRequest']);
        Route::get('/tutor/affiliate-request-status',[TutorController::class,'getAffRequestStatus']);


        Route::get('/tutor/tutor-popup-images',[TutorController::class,'tutorPopupImages']);





    });