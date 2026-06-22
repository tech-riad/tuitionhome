<?php

use App\Http\Controllers\Backend\Parent\ParentActionController;
use App\Http\Controllers\Backend\Payment\PaymentController;
use App\Http\Controllers\Backend\Tutor\InactiveTutorController;

use Illuminate\Support\Facades\Route ;

Route::middleware(['auth'])->group(function () {
Route::any('/admin/verify-parent/{id}',[ ParentActionController::class,'verifyParent'])->name('admin.verify.parent')->middleware('permission:parent-actions');
Route::any('/admin/make-super-parent/{id}',[ ParentActionController::class,'makeSuperParent'])->name('admin.make.super.parent')->middleware('permission:parent-actions');
Route::any('/admin/make-unplesant-parent/{id}',[ ParentActionController::class,'makeUnplesantParent'])->name('admin.make.unplesant.parent')->middleware('permission:parent-actions');
Route::any('/admin/deactive-parent/{id}', [ParentActionController::class, 'deactiveParent'])
    ->name('admin.deactivate.parent')
    ->middleware('permission:parent-active-deactive');
Route::any('/admin/create-note/{id}', [ParentActionController::class, 'createNote'])
    ->name('admin.cretae.note.parent')
    ->middleware('permission:parent-actions');
Route::get('/admin/fetch-note/{id}', [ParentActionController::class, 'fetchNoteByParentId'])
    ->name('admin.fetch.note.parent')
    ->middleware('permission:parent-actions');
Route::post('/admin/create/parent', [ParentActionController::class, 'newParentCreate'])
    ->name('admin.create.parent')
    ->middleware('permission:parent-actions');
Route::get('/admin/inactive/parent', [ParentActionController::class, 'inactiveParent'])
    ->name('admin.inactive.parent')
    ->middleware('permission:parent-active-deactive');
});