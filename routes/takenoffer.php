<?php

use App\Http\Controllers\Backend\TakenOffer\TakenOfferController;
use Illuminate\Support\Facades\Route;


Route::get('/admin/taken-offer/assign-offer',[TakenOfferController::class,'assignOffer'])->name('admin.taken_offer.assign.offer')->middleware('auth');
Route::get('/admin/taken-offer/waiting-offer',[TakenOfferController::class,'waitingOffer'])->name('admin.taken_offer.waiting.offer')->middleware('auth');
Route::get('/admin/taken-offer/meeting-offer',[TakenOfferController::class,'mettingOffer'])->name('admin.taken_offer.meeting.offer')->middleware('auth');
Route::get('/admin/taken-offer/trial-offer',[TakenOfferController::class,'trialOffer'])->name('admin.taken_offer.trial.offer')->middleware('auth');
Route::get('/admin/taken-offer/repost-offer',[TakenOfferController::class,'repostOffer'])->name('admin.taken_offer.repost.offer')->middleware('auth');
Route::get('/admin/taken-offer/closed-offer',[TakenOfferController::class,'closedOffer'])->name('admin.taken_offer.closed.offer')->middleware('auth');
Route::get('/admin/taken-offer/due-offer',[TakenOfferController::class,'dueOffer'])->name('admin.taken_offer.due.offer')->middleware('auth');
Route::get('/admin/taken-offer/refund-offer',[TakenOfferController::class,'refundOffer'])->name('admin.taken_offer.refund.offer')->middleware('auth');
Route::get('/admin/taken-offer/problem-offer',[TakenOfferController::class,'problemOffer'])->name('admin.taken_offer.problem.offer')->middleware('auth');
Route::get('/admin/taken-offer/confirm-offer',[TakenOfferController::class,'confirmOffer'])->name('admin.taken_offer.confirm.offer')->middleware('auth');
Route::get('/admin/taken-offer/payment-offer',[TakenOfferController::class,'paymentOffer'])->name('admin.taken_offer.payment.offer')->middleware('auth');

