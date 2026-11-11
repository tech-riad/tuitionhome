<?php

use App\Http\Controllers\Backend\TutorConsultationRequestController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin/consultation-requests')->name('admin.consultation-requests.')->group(function () {
    Route::get('/', [TutorConsultationRequestController::class, 'index'])->name('index');
    Route::get('/parents', [TutorConsultationRequestController::class, 'parentIndex'])
        ->name('parents.index');
    Route::get('/sms/editor', [TutorConsultationRequestController::class, 'smsEditor'])->name('sms.editor');
    Route::post('/sms/editor', [TutorConsultationRequestController::class, 'selectSmsRecipients'])->name('sms.editor.select');
    Route::post('/sms/send', [TutorConsultationRequestController::class, 'sendBulkSms'])->name('sms.send');
    Route::post('/{consultationRequest}/invoice', [TutorConsultationRequestController::class, 'createInvoice'])
        ->name('invoice.create');
    Route::patch('/{consultationRequest}/payment-status', [TutorConsultationRequestController::class, 'updatePaymentStatus'])
        ->name('payment-status');
    Route::patch('/{consultationRequest}/invoice/cancel', [TutorConsultationRequestController::class, 'cancelInvoice'])
        ->name('invoice.cancel');
    Route::patch('/{consultationRequest}', [TutorConsultationRequestController::class, 'updateDetails'])
        ->name('update');
    Route::patch('/{consultationRequest}/status', [TutorConsultationRequestController::class, 'updateStatus'])
        ->name('status');
    Route::patch('/{consultationRequest}/message', [TutorConsultationRequestController::class, 'updateMessage'])
        ->name('message.update');
    Route::post('/{consultationRequest}/notes', [TutorConsultationRequestController::class, 'storeNote'])
        ->name('notes.store');
});
