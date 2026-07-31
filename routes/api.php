<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

include('api/parents.php');
include('api/tutors.php');
include ("api/country-city-location.php");
include ("api/category-course-subject-institute.php");
include ("api/job-offers.php");
include ("api/config.php");
include ("api/tutorhub.php");
include ("api/tutorsms.php");
include ("api/blogpost.php");
include ("api/payment.php");
include ("api/affiliate.php");
include ("api/corporatepartner.php");
include ("api/corporateagent.php");
include ("api/membership.php");
include ("api/verify.php");
include ("api/boost.php");
include ("api/bookmark.php");
