<?php

use App\Http\Controllers\Backend\Payment\PaymentController;
use App\Http\Controllers\Backend\Tutor\InactiveTutorController;

use Illuminate\Support\Facades\Route ;

Route::middleware(['auth'])->group(function () {
Route::get('/admin/payment',[ PaymentController::class,'index'])->name('admin.payment')->middleware('permission:revenue-payment');
Route::get('/admin/payment/sms-recharge',[ PaymentController::class,'smsRecharge'])->name('admin.sms.recharge')->middleware('permission:sms-reacharge-payment');
Route::post('/admin/add-payment/sms-recharge',[ PaymentController::class,'smsRechargeAdd'])->name('admin.sms.recharge.add')->middleware('permission:sms-reacharge-payment');
Route::post('/admin/payment/verify-service-charge',[ PaymentController::class,'verifyPaymentServiceCharge'])->name('admin.service.payment.verify')->middleware('permission:payment-actions');
Route::get('/admin/payment/monthly-revenue',[ PaymentController::class,'monthlyRevenue'])->name('admin.monthly.revenue')->middleware('permission:monthly-revenue');
Route::post('/admin/payment/note-create',[ PaymentController::class,'paymentNote'])->name('admin.payment.note')->middleware('permission:payment-actions');
Route::get('/admin/get-note-details/{itemId}', [PaymentController::class, 'getNoteDetails'])->name('admin.get.note.details')->middleware('permission:payment-actions');
Route::any('/admin/revenue/filter', [PaymentController::class, 'filterRevenue'])->name('admin.revenue.filter')->middleware('permission:revenue-payment');
Route::any('/admin/revenue/serch', [PaymentController::class, 'searchRevenue'])->name('admin.revenue.search')->middleware('permission:revenue-payment');
Route::any('/admin/all-revenue', [PaymentController::class, 'allRevenue'])->name('admin.revenue.all')->middleware('permission:revenue-payment');
Route::any('/admin/set-point-sms-recharge', [PaymentController::class, 'setPointSmsRecharge'])->name('admin.revenue.setpoint.smsrecharge')->middleware('permission:sms-reacharge-payment');
Route::get('/admin/payment/due',[ PaymentController::class,'duePayment'])->name('admin.due.payment')->middleware('permission:due-payment');
Route::post('/admin/payment/verify-due-payment',[ PaymentController::class,'verifyPaymentDue'])->name('admin.service.due.verify')->middleware('permission:due-payment-actions');
Route::post('/admin/due/note-create',[ PaymentController::class,'dueNote'])->name('admin.due.note')->middleware('permission:due-payment-actions');
Route::get('/admin/due/note-details/{itemId}',[ PaymentController::class,'dueNotedetails'])->name('admin.due.note.details')->middleware('permission:due-payment-actions');
Route::any('/admin/due/serch', [PaymentController::class, 'searchDue'])->name('admin.due.search')->middleware('permission:due-payment');
Route::any('/admin/set-point-due', [PaymentController::class, 'setPointDue'])->name('admin.setpoint.due')->middleware('permission:due-payment');
// Route::get('/admin/payment/setpoint-due',[ PaymentController::class,'setPointDue'])->name('admin.setpoint.due')->middleware('permission:revenue-payment');
Route::any('/admin/due/filter', [PaymentController::class, 'filterDue'])->name('admin.due.filter')->middleware('permission:due-payment');
Route::any('/admin/due/pending-date-filter', [PaymentController::class, 'filterDuePendingDate'])->name('admin.due.filter.pendingdate')->middleware('permission:due-payment');

Route::any('/admin/due/today-payment', [PaymentController::class, 'todayPayDue'])->name('admin.due.todaypay')->middleware('permission:due-payment');


Route::get('/admin/payment/employee',[ PaymentController::class,'employee'])->name('admin.payment.employee')->middleware('permission:employee-payment');
Route::any('/admin/payment/employee/selected',[ PaymentController::class,'selectedEmployee'])->name('admin.payment.selected.employee')->middleware('permission:employee-payment');
Route::any('/admin/employee/payment/filter', [PaymentController::class, 'filterEmpPayment'])->name('admin.emp.payment.filter')->middleware('permission:employee-payment');

Route::any('/admin/payment/employee/search',[ PaymentController::class,'employeeSearch'])->name('admin.payment.employee.search')->middleware('permission:employee-payment');


Route::post('/admin/payment/due-paid',[ PaymentController::class,'duePaymentPaid'])->name('admin.due.paid')->middleware('permission:pay-due-payment');


Route::get('/admin/payment/sms-recharge-due',[ PaymentController::class,'smsRechargeDue'])->name('admin.sms.recharge.due')->middleware('permission:sms-reacharge-payment');
Route::any('/admin/set-point/sms-recharge-due',[ PaymentController::class,'smsRechargeDueSetPoint'])->name('admin.sms.recharge.due.setpoint')->middleware('permission:sms-reacharge-payment');
Route::any('/admin/sms-recharge-due/search',[ PaymentController::class,'smsRechargeDueFilter'])->name('admin.sms.recharge.due.search')->middleware('permission:sms-reacharge-payment');

Route::any('/admin/payment/sms-recharge-search',[ PaymentController::class,'smsRechargeSearch'])->name('admin.sms.recharge.search')->middleware('permission:sms-reacharge-payment');

// Transction History
Route::get('/admin/invoice/{id}',[PaymentController::class,'tutorInvoice'])->name('admin.tutorInvoice')->middleware('permission:revenue-payment');
Route::get('/admin/refund-payment/{id}',[PaymentController::class,'refundStatus'])->name('admin.refundStatus')->middleware('permission:revenue-payment');

Route::get('/admin/membership-transction/{id}',[PaymentController::class,'membershipTrx'])->name('admin.membershipTrx')->middleware('permission:revenue-payment');
Route::get('/admin/refund-transction/{id}',[PaymentController::class,'refundTrx'])->name('admin.refundTrx')->middleware('permission:revenue-payment');

// Revenue payment Add
Route::post('/admin/payment-add',[PaymentController::class,'paymentAdd'])->name('admin.payment.add')->middleware('permission:admin-payment-add');
});
