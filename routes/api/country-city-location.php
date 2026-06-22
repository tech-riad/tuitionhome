<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\Api\CountryCityLocationController;


//    country,lcoation,city get route
Route::get('/get-country',[CountryCityLocationController::class, 'getCountry']);
Route::get('/get-city/{id}',[CountryCityLocationController::class, 'getCity']);
Route::get('/get-location/{id}',[CountryCityLocationController::class, 'getlocation']);
