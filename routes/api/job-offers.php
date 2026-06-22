<?php

use App\Http\Controllers\Frontend\Api\JobOffer\JobofferController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/all-job-offers',[JobofferController::class, 'getJobOffer']);
Route::get('/get_job_details/{id}',[JobofferController::class, 'jobDetails']);
Route::post('/job-search',[JobofferController::class, 'jobSearch']);
Route::post('/job-filter',[JobofferController::class, 'jobFilter']);
Route::post('/job-filter-by-salary',[JobofferController::class, 'jobFilterSalary']);