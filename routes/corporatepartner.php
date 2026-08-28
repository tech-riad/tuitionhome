<?php

use Illuminate\Support\Facades\Route ;
use App\Http\Controllers\Backend\CorporatePartner\BackendCPcontroller;
use App\Http\Controllers\Backend\CorporatePartner\BackendCPPartnerProfileController;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function() {

    Route::get('/cpprofiles',[BackendCPcontroller::class,'index'])->name('cpprofile.index');
    Route::post('/cpprofiles/store',[BackendCPcontroller::class,'store'])->name('cpprofile.store');

    // Profile Management
    Route::get('/cpprofile/{id}',[BackendCPPartnerProfileController::class,'index'])->name('getcpProfile.index');
    
});