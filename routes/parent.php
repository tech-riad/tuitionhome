<?php

use App\Http\Controllers\Backend\Parent\BackendParentController;
use App\Http\Controllers\Backend\Parent\BackendParentJobController;
use App\Http\Controllers\Backend\Parent\ParentActionController;
use App\Http\Controllers\Backend\Payment\PaymentController;
use App\Http\Controllers\Backend\Tutor\InactiveTutorController;

use Illuminate\Support\Facades\Route ;

Route::middleware(['auth'])->group(function () {
Route::any('/admin/parent/filter',[ BackendParentController::class,'filterParent'])->name('admin.parent.filter');
Route::any('/admin/parent/view/{id}',[ BackendParentController::class,'viewParent'])->name('admin.view.parent')->middleware('permission:parent-view');
Route::any('/admin/parent/edit/{id}',[ BackendParentController::class,'editParent'])->name('admin.edit.parent')->middleware('permission:parent-edit');
Route::any('/admin/parent/other-info-edit/{id}',[ BackendParentController::class,'otherInfo'])->name('admin.edit.parent.other.info')->middleware('permission:parent-edit');
Route::any('/admin/parent/password-edit/{id}',[ BackendParentController::class,'passwordUpdate'])->name('admin.edit.parent.password')->middleware('permission:parent-pass-update');
Route::any('/admin/parent/account-status-edit/{id}',[ BackendParentController::class,'accountStatus'])->name('admin.edit.parent.account.status')->middleware('permission:parent-edit');
Route::any('/admin/parent/name-update/{id}',[ BackendParentController::class,'updateName'])->name('admin.edit.parent.name')->middleware('permission:parent-edit');
Route::any('/admin/parent/phone-update/{id}',[ BackendParentController::class,'updatePhone'])->name('admin.edit.parent.phone')->middleware('permission:parent-edit');
Route::any('/admin/parent/email-update/{id}',[ BackendParentController::class,'updateEmail'])->name('admin.edit.parent.email')->middleware('permission:parent-edit');

// Edit Parent
Route::post('/admin/parent/personal-details/{id}',[ BackendParentController::class,'personalDeatils'])->name('admin.edit.parent.details')->middleware('permission:parent-edit');
Route::post('/admin/parent/contact-info/{id}',[ BackendParentController::class,'contactInfo'])->name('admin.edit.parent.info')->middleware('permission:parent-edit');
Route::post('/admin/parent/kid-info/{id}',[ BackendParentController::class,'kidInfo'])->name('admin.edit.parent.kid.info')->middleware('permission:parent-edit');
Route::post('/admin/parent/pass-update/{id}',[ BackendParentController::class,'passwordUpdates'])->name('admin.edit.parent.pass.update')->middleware('permission:parent-edit');

// view Parent
Route::get('/admin/parent/posted-job/{id}',[ BackendParentJobController::class,'getPostedJob'])->name('admin.parent.posted.job')->middleware('permission:parent-view');
Route::get('/admin/parent/basic-log/{id}',[ BackendParentJobController::class,'basicLog'])->name('admin.parent.basic.log')->middleware('permission:parent-view');
Route::get('/admin/parent/advance-log/{id}',[ BackendParentJobController::class,'advanceLog'])->name('admin.parent.advance.log')->middleware('permission:parent-view');


// Parent job status
Route::get('/admin/parent-job-status/{id}',[ BackendParentJobController::class,'parentJobStatus'])->name('admin.parent.job.status')->middleware('permission:parent-view');

Route::get('/admin/parent/tutor-and-category/request/{id}',[BackendParentJobController::class, 'tutorCategoryRequest'])->name('admin.parent.category.request.status')->middleware('permission:parent-requests');
Route::post('/admin/parent/tutor-and-category/request/filter/{id}',[BackendParentJobController::class, 'tutorCategoryRequestFilter'])->name('admin.parent.category.request.filter')->middleware('permission:parent-requests');
Route::any('/admin/parent/cat-request/post/job/{lead_id}',[ BackendParentJobController::class,'parentCategoryLeadJobPost'])->name('admin.parent.category.lead.job.post')->middleware('permission:parent-requests');
Route::any('/admin/parent/tutor-request/post/job/{lead_id}',[ BackendParentJobController::class,'parentTutorLeadJobPost'])->name('admin.parent.tutor.lead.job.post')->middleware('permission:parent-requests');


// parent Alert

Route::post('/admin/parent/make-alert/{parent}',[BackendParentController::class,'makeAlert'])->name('parent.make.alert')->middleware('permission:parent-actions');
Route::post('/admin/parent/undo-alert/{parent}',[BackendParentController::class,'undoAlert'])->name('parent.undo.alert')->middleware('permission:parent-actions');


Route::post('/import/parent/data', [BackendParentController::class, 'import'])->name('import.parent.data')->middleware('permission:parent-data-import');
Route::post('/admin/parent/sms-on-off', [BackendParentController::class, 'smsStatus'])->name('admin.parent.sms.status')->middleware('permission:parent-actions');
Route::post('/admin/parent/add-additional-note', [BackendParentController::class, 'additionalNote'])->name('admin.parent.additional.note.add')->middleware('permission:parent-actions');
});
