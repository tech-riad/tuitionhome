<?php

use App\Http\Controllers\Frontend\Api\CareerController;
use Illuminate\Support\Facades\Route;

Route::get('/careers', [CareerController::class, 'index'])
    ->name('api.careers.index');

Route::get('/careers/{careerPlan}', [CareerController::class, 'show'])
    ->whereNumber('careerPlan')
    ->name('api.careers.show');

Route::middleware(['auth:t-api', 'scopes:tutors'])->group(function () {
    Route::post('/careers/{careerPlan}/apply', [CareerController::class, 'apply'])
        ->whereNumber('careerPlan')
        ->name('api.careers.apply');
});