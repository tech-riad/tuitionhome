<?php

use App\Http\Controllers\Frontend\Api\BookmarkController;
use Illuminate\Support\Facades\Route;




Route::any('/get-bookmark-objects',[BookmarkController::class, 'getObjects'])->middleware('auth:p-api,t-api');
Route::post('/add-to-bookmark',[BookmarkController::class, 'addBookmark'])->middleware('auth:p-api,t-api');
Route::post('/remove-from-bookmark',[BookmarkController::class, 'removeBookmark'])->middleware('auth:p-api,t-api');
