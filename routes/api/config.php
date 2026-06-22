<?php

use App\Http\Controllers\Frontend\Api\Config\ConfigController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::get('/get_departments',[ConfigController::class, 'allDepartment']);
Route::get('/get_all_config',[ConfigController::class, 'allConfigData']);
Route::post('/tutor-hire-request',[ConfigController::class, 'hireTutor']);
Route::post('/pwa-count', [ConfigController::class, 'pwaCount']);
Route::get('/get-pwa-count', [ConfigController::class, 'pwaCountGet']);
Route::get('/get-web-rivew', [ConfigController::class, 'webReviewGet']);

Route::post('/tutoring-history-counting', [ConfigController::class, 'jobCounting']);


Route::get('/get-popup', [ConfigController::class, 'popupImageGet']);