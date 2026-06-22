<?php

use App\Http\Controllers\CourseBlogPostController;
use App\Http\Controllers\Frontend\Api\CategoryCourseSubjectController;
use App\Http\Controllers\Frontend\Api\Config\ConfigController;
use App\Models\CourseBlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::get('/get-category-course',[CategoryCourseSubjectController::class, 'getCatCourse']);

Route::get('/random-tutor-get-suggested-course/{courseId}',[CourseBlogPostController::class, 'suggestedTutor']);
Route::get('/course-blog-details/{id}',[CourseBlogPostController::class, 'courseBlogDetails']);
Route::get('/other-related-courses',[CourseBlogPostController::class, 'relatedCourses']);
Route::get('/filter-course-wise-tutor',[CourseBlogPostController::class, 'filterCourseTutor']);
Route::get('/get-course-wise-tutor/{courseId}',[CourseBlogPostController::class, 'getCourseTutor']);
// Route::get('/update-course-blogs/{id}',[CourseBlogPostController::class,'updateCourseBlog'])->name('blog.course.update')->middleware('auth');

