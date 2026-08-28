<?php

use Illuminate\Support\Facades\Route ;
use App\Http\Controllers\Backend\CorporatePartner\CorporatePartnerRequestController;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function() {

    Route::get('/cprequest',[CorporatePartnerRequestController::class,'index'])->name('cprequest.index');
    Route::post('/cprequest/status-change',[CorporatePartnerRequestController::class,'statusChange'])->name('cprequest.status.change');
    Route::any('/cprequest/delete/{id}',[CorporatePartnerRequestController::class,'delete'])->name('cprequest.delete');
    Route::post('/cprequest/apply/{id}',[CorporatePartnerRequestController::class,'apply'])->name('cprequest.apply');
    Route::post('/cprequest/cancel/{id}',[CorporatePartnerRequestController::class,'cancel'])->name('cprequest.cancel');
});
