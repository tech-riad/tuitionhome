<?php

use App\Http\Controllers\Backend\Notice\NoticeController;
use Illuminate\Support\Facades\Route ;



Route::middleware(['auth'])->group(function () {
    Route::get('/admin/all-notice',[ NoticeController::class,'allNotice'])->name('admin.all.notice');

    Route::post('/admin/all-notice/tutor-filter',[ NoticeController::class,'noticeTutorFilter'])->name('admin.all.notice.tutor.filter');
    Route::post('/admin/send-notice/tutor-dashboard',[ NoticeController::class,'noticeSendFilter'])->name('admin.all.notice.tutor.send');
    Route::post('/admin/send-notice-command/tutor-dashboard',[ NoticeController::class,'NoticeTest'])->name('admin.all.notice.tutor.send.command');
    Route::post('/admin/send-notice-status/change',[ NoticeController::class,'statusChange'])->name('admin.all.notice.tutor.send.status.change');
    // Unit Notice Send
    Route::post('/admin/send-notice/dashboard-unit',[ NoticeController::class,'unitNoticeSend'])->name('admin.all.notice.unit.send');
    // parent Notice
    Route::post('/admin/all-notice/parent-filter',[ NoticeController::class,'noticeParentFilter'])->name('admin.all.notice.parent.filter');
    Route::any('/admin/marketting-plan/delete/{id}',[ NoticeController::class,'noticeDelete'])->name('admin.all.notice.delete');
    Route::post('/admin/marketting-plan/restore/{id}', [NoticeController::class, 'noticeRestore'])->name('admin.all.notice.restore');
    Route::get('/admin/marketting-plan/{id}/edit', [NoticeController::class, 'edit'])->name('admin.all.notice.edit');
    Route::post('/admin/marketting-plan/update', [NoticeController::class, 'markettinPlanUpdate'])->name('admin.marketting.plan.update');


    // Popup Image Dashboard Route Start
    Route::get('/admin/all-popup-image',[ NoticeController::class,'allPopupImage'])->name('admin.all.popupimage');
    Route::post('/admin/all-popup/tutor-filter',[ NoticeController::class,'popupTutorFilter'])->name('admin.all.popup.tutor.filter');
    Route::post('/admin/all-popup/tutor',[ NoticeController::class,'popupSendFilter'])->name('admin.all.popup.tutor.send');
    Route::post('/admin/all-popup/parent-filter',[ NoticeController::class,'popupParentFilter'])->name('admin.all.popup.parent.filter');
    Route::post('/admin/send-popup-status/change',[ NoticeController::class,'statusChangePopup'])->name('admin.all.popup.tutor.send.status.change');
    Route::post('/admin/send-popup/dashboard-unit',[ NoticeController::class,'unitPopupSend'])->name('admin.all.popup.unit.send');
    Route::any('/admin/popup-plan/delete/{id}',[ NoticeController::class,'popupDelete'])->name('admin.all.popup.delete');

    // SMS Marketting Route Start
    Route::get('/admin/sms-marketting',[ NoticeController::class,'smsMarketting'])->name('admin.sms.marketting');
    Route::post('/admin/sms-marketting/tutor-filter',[ NoticeController::class,'sendMarketingSms'])->name('admin.sms.marketting.tutor.filter');
    Route::post('/admin/sms-marketting/tutor',[ NoticeController::class,'smsMarkettingSendFilter'])->name('admin.sms.marketting.tutor.send');
    Route::post('/admin/sms-marketting/parent-filter',[ NoticeController::class,'smsMarkettingParentFilter'])->name('admin.sms.marketting.parent.filter');
    Route::post('/admin/send-sms-status/change',[ NoticeController::class,'statusChangeSms'])->name('admin.sms.marketting.tutor.send.status.change');
    Route::post('/admin/send-sms/dashboard-unit',[ NoticeController::class,'unitSmsSend'])->name('admin.sms.unit.send');


    // Sms Marketing Unit Route Start
    Route::get('/admin/sms-marketing-unit',[ NoticeController::class,'smsMarketingUnit'])->name('admin.sms.marketing.unit');
    Route::post('/admin/sms-marketing-unit-filter', [NoticeController::class, 'smsMarketingUnitFilter'])->name('admin.sms.marketing.unit.filter');
    Route::post('/admin/sms-marketing-unit-send-sms', [NoticeController::class, 'smsMarketingUnitSendSms'])->name('admin.sms.marketing.unit.send.sms');
    Route::post('/admin/sms-marketing-delete/{id}', [NoticeController::class, 'smsMarketingDelete'])->name('admin.sms.marketing.delete');


    // Popup Image
    Route::get('/admin/popup-image',[ NoticeController::class,'popupImage'])->name('admin.popup.image');
    Route::post('/admin/popup-image-send',[ NoticeController::class,'popupImageSend'])->name('admin.popup.image.send');
    Route::post('/admin/item/status-update', [NoticeController::class, 'updateStatus'])->name('admin.item.status.update');
    Route::any('/admin/item-plan/delete/{id}',[ NoticeController::class,'popupItemDelete'])->name('admin.item.popup.delete');


});