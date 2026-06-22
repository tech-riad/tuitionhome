<?php

use App\Http\Controllers\Backend\Setting\SettingController;
use Illuminate\Support\Facades\Route ;


Route::middleware(['auth'])->group(function () {

Route::get('/admin/user-agent', [SettingController::class, 'userAgent'])->name('admin.user.agent')->middleware('auth')->middleware('permission:user-agent');
Route::post('/admin/user-agent-add', [SettingController::class, 'userAgentAdd'])->name('admin.user.agent.add')->middleware('auth')->middleware('permission:user-agent-add');



// Social Media
Route::get('/admin/social-medias', [SettingController::class, 'socialMedia'])->name('admin.social.media');
Route::post('/admin/add-social-media-account', [SettingController::class, 'socialMediaAdd'])->name('admin.add.social.media');
Route::delete('admin/social-media/{id}', [SettingController::class, 'destroy'])->name('admin.delete.social.media');

Route::get('/admin/get-social-media/{id}', [SettingController::class, 'getSocialMedia']);
Route::post('/admin/update-social-media/{id}', [SettingController::class, 'updateSocialMedia']);

});