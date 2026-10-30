<?php

use App\Http\Controllers\Backend\Setting\SettingController;
use App\Http\Controllers\CareerPlanController;
use Illuminate\Support\Facades\Route ;


Route::middleware(['auth'])->group(function () {

Route::get('/admin/career', [CareerPlanController::class, 'index'])->name('admin.career.index')->middleware('auth');
Route::get('/admin/career/create', [CareerPlanController::class, 'create'])->name('admin.career.create')->middleware('auth');
Route::get('/admin/career/{careerPlan}/applications', [CareerPlanController::class, 'applications'])->name('admin.career.applications')->middleware('auth');
Route::post('/admin/career/{careerPlan}/applications/{application}/status', [CareerPlanController::class, 'updateApplicationStatus'])->name('admin.career.applications.status')->middleware('auth');
Route::get('/admin/career/{careerPlan}/applications/{application}/notes', [CareerPlanController::class, 'applicationNotes'])->name('admin.career.applications.notes')->middleware('auth');
Route::post('/admin/career/{careerPlan}/applications/{application}/notes', [CareerPlanController::class, 'storeApplicationNote'])->name('admin.career.applications.notes.store')->middleware('auth');
Route::get('/admin/career/{careerPlan}/applications/sms/editor', [CareerPlanController::class, 'applicationSmsEditor'])->name('admin.career.applications.sms.editor')->middleware('auth');
Route::post('/admin/career/{careerPlan}/applications/sms/editor', [CareerPlanController::class, 'selectApplicationSmsRecipients'])->name('admin.career.applications.sms.editor.select')->middleware('auth');
Route::post('/admin/career/{careerPlan}/applications/sms/send', [CareerPlanController::class, 'sendApplicationSms'])->name('admin.career.applications.sms.send')->middleware('auth');
Route::get('/admin/career/{careerPlan}', [CareerPlanController::class, 'show'])->name('admin.career.show')->middleware('auth');
Route::post('/admin/career/{careerPlan}/status', [CareerPlanController::class, 'updateStatus'])->name('admin.career.status')->middleware('auth');
Route::post('/admin/career', [CareerPlanController::class, 'store'])->name('admin.career.store')->middleware('auth');

});

Route::get('/career/share/{careerPlan}', [CareerPlanController::class, 'share'])
    ->name('career.share')
    ->middleware('signed');
