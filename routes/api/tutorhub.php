<?php

use App\Http\Controllers\Frontend\Api\JobOffer\JobofferController;
use App\Http\Controllers\Frontend\Api\Tutor\TutorHubController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/tutor-hub',[TutorHubController::class, 'tutorHub']);
Route::get('/tutor-hub/tutor-counting',[TutorHubController::class, 'tutorCounting']);
Route::get('/tutor-hub/home-tutor',[TutorHubController::class, 'homeTutor']);
Route::get('/tutor-hub/all-tutor-get',[TutorHubController::class, 'getAllTutor']);
Route::get('/tutor-hub/premium-tutor-get',[TutorHubController::class, 'getPremiumTutor']);
Route::get('/tutor-hub/verified-tutor-get',[TutorHubController::class, 'getVerifiedTutor']);
Route::get('/tutor-hub/new-tutor-get',[TutorHubController::class, 'getNewTutor']);
Route::get('/tutor-hub/exclusive-tutor',[TutorHubController::class, 'getFeaturedTutor']);
Route::get('/tutor-hub/single-tutor/{id}',[TutorHubController::class, 'getSingleTutor']);
Route::get('/tutor-hub/single-tutor/suggested-tutor/{id}',[TutorHubController::class, 'suggestedTutor']);
Route::get('/tutor-hub/all-tutor-filter',[TutorHubController::class, 'filter']);
Route::get('/tutor-hub/exclusive-tutor-filter',[TutorHubController::class, 'exclusiveTutorFilter']);
Route::get('/tutor-hub/premium-tutor-filter',[TutorHubController::class, 'premiumTutorFilter']);
Route::get('/tutor-hub/verified-tutor-filter',[TutorHubController::class, 'verifiedTutorFilter']);
Route::get('/tutor-hub/newly-added-tutor-filter',[TutorHubController::class, 'newTutorFilter']);






Route::get('/tutor-hub/tutor/city-wise-counting',[TutorHubController::class, 'getTutorCounting']);
