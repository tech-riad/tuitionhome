<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\Api\CategoryCourseSubjectController;
use App\Http\Controllers\Frontend\Api\Tutor\TutorController ;


//    Category,Class,Course get route
Route::get('/get-category',[CategoryCourseSubjectController::class, 'getCategory']);
Route::get('/get-course/{id}',[CategoryCourseSubjectController::class, 'getCourse']);
Route::get('/get-subject/{id}',[CategoryCourseSubjectController::class, 'getSubject']);

Route::get('/get-all-courses',[CategoryCourseSubjectController::class, 'getCourses']);
//    get institute route
Route::get('/get-institute',[CategoryCourseSubjectController::class, 'getInstitute']);


Route::get('/get-ssc-institute',[TutorController::class, 'getSscInstitute']);
Route::get('/get-hsc-institute',[TutorController::class, 'getHscInstitute']);
Route::get('/get-university-institute',[TutorController::class, 'getUniversityInstitute']);
