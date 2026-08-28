<?php

use Illuminate\Support\Facades\Route ;
use App\Http\Controllers\Backend\CorporatePartner\BackendCPcontroller;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function() {

    Route::get('/cpprofiles',[BackendCPcontroller::class,'index'])->name('cpprofile.index');
    
});