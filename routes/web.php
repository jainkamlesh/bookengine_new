<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\HotelGroupController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\RoomFacilityController;
use App\Http\Controllers\Admin\InventoryMasterController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\RatePlanController;
use App\Http\Controllers\Admin\ExtraController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\RateTypeController;
use App\Http\Controllers\Admin\HotelLoginController;
use App\Http\Controllers\Admin\BulkController;
use App\Http\Controllers\Admin\LogsController;
use App\Http\Controllers\Admin\ServiceController;

use App\Http\Controllers\Admin\ManageHotelBookingController;

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\ServiceBookingController;
use App\Http\Controllers\Admin\RequestBookingController;
use App\Http\Controllers\Admin\WhatsappTemplateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Admin login pages
Route::get('/uControl', [AdminController::class, 'index'])->name('admin.index');
Route::post('/uControl', [AdminController::class, 'checkLogin'])->name('admin.checklogin');
Route::get('/uControl/logout', [AdminController::class, 'logoutAdmin'])->name('admin.logout');


Route::post('/google_map_api', [HotelController::class, 'GoogleMapAPI'])->name('hotel.google.map.api');

Route::get('/hotel_booking_form', [ManageHotelBookingController::class, 'index']);

Route::post('/save_widget_hotel_booking_form', [ManageHotelBookingController::class, 'saveData'])->name('save.widget.hotel.booking.form');

Route::prefix('uControl')->middleware(['AdminAuth','language_check'])->name('admin.')->group(function () {
    // By pass login
    Route::get('/by-pass/{id}', [AdminController::class, 'byPassHotelLogin'])->name('byPassHotelLogin');

    // Edit Profile
    Route::get('/edit-profile', [AdminController::class, 'editProfile'])->name('aditProfile');
    Route::post('/edit-profile', [AdminController::class, 'saveProfile'])->name('aditProfile');


    // Hotels
    Route::get('/hotels', [HotelController::class, 'index'])->name('hotels');
    Route::get('add-hotel', [HotelController::class, 'add'])->name('add.hotel');
    Route::get('/hotel-edit/{id}', [HotelController::class, 'edit'])->name('hotel.edit');
    Route::get('/hotel-status/{id}', [HotelController::class, 'hotelstatus'])->name('hotel.status');
    Route::get('/hotel-delete/{id}', [HotelController::class, 'delete'])->name('hotel.delete');
    Route::post('/hotel-store', [HotelController::class, 'store'])->name('hotel.store');

    //download-hotel-widget
    Route::get('/download/hotel/widget', [HotelController::class, 'downloadHotelWidget'])->name('download.hotel.widget');

	//Hotel group

	Route::get('/hotelgroup', [HotelGroupController::class, 'index'])->name('hotelgroup');
	Route::get('add-hotelgroup', [HotelGroupController::class, 'add'])->name('add.hotelgroup');
	Route::get('/hotelgroup-edit/{id}', [HotelGroupController::class, 'edit'])->name('hotelgroup.edit');
    Route::get('/hotelgroup-delete/{id}', [HotelGroupController::class, 'delete'])->name('hotelgroup.delete');
	Route::post('/hotelgroup-store', [HotelGroupController::class, 'store'])->name('hotelgroup.store');
    Route::get('/hotelgrouplist/{id}', [HotelGroupController::class, 'list'])->name('hotelgrouplist');
    Route::get('/edit-group-profile', [HotelGroupController::class, 'editProfile'])->name('editHotelGroupProfile');

    // Currency
    Route::get('currency', [CurrencyController::class, 'index'])->name('currency');
    Route::get('add-currency', [CurrencyController::class, 'add'])->name('add.currency');
    Route::get('/currency-edit/{id}', [CurrencyController::class, 'edit'])->name('currency.edit');
    Route::get('/currency-delete/{id}', [CurrencyController::class, 'delete'])->name('currency.delete');
    Route::post('/currency-store', [CurrencyController::class, 'store'])->name('currency.store');


    // Room Facility
    Route::get('room-option', [RoomFacilityController::class, 'index'])->name('room-option');
    Route::get('add-room-option', [RoomFacilityController::class, 'add'])->name('add.room-option');
    Route::get('/room-option-edit/{id}', [RoomFacilityController::class, 'edit'])->name('room-option.edit');
    Route::get('/room-option-delete/{id}', [RoomFacilityController::class, 'delete'])->name('room-option.delete');
    Route::post('/room-option-store', [RoomFacilityController::class, 'store'])->name('room-option.store');


    // Hotel management login
    Route::get('/hotel', [HotelLoginController::class, 'index'])->name('hotel.dashboard');
    Route::get('/hotel/edit-profile', [HotelLoginController::class, 'editProfile'])->name('hotel.edit_profile');
    Route::post('/hotel/edit-profile', [HotelLoginController::class, 'saveProfile'])->name('hotel.edit_profile');

    Route::get('/change-password', [HotelLoginController::class, 'changePassword'])->name('hotel.changePassword');
    Route::post('/change-password', [HotelLoginController::class, 'savePassword'])->name('hotel.changePassword');

    // Hotel Profile
    Route::get('/hotel-profile', [HotelLoginController::class, 'hotelProfile'])->name('hotel.profile');
    Route::post('/hotel-storer', [HotelLoginController::class, 'store'])->name('hotel.profile.store');


    // ---------------- Room management routes ---------------------//
    // Room Type

    Route::get('room-type', [RoomTypeController::class, 'index'])->name('room-type');
    Route::get('add-room-type', [RoomTypeController::class, 'add'])->name('add.room-type');
    Route::get('/room-type-edit/{id}', [RoomTypeController::class, 'edit'])->name('room-type.edit');
    Route::get('/room-type-delete/{id}', [RoomTypeController::class, 'delete'])->name('room-type.delete');
    Route::post('/room-type-store', [RoomTypeController::class, 'store'])->name('room-type.store');
    Route::post('/room-image-store', [RoomTypeController::class, 'storeimage'])->name('room-type.storeimage');
    Route::post('/room-image-delete', [RoomTypeController::class, 'deleteimage'])->name('room-type.deleteimage');

    // ---------------- Service management routes ---------------------//
    // Service

    Route::get('service', [ServiceController::class, 'index'])->name('service');
    Route::get('add-service', [ServiceController::class, 'add'])->name('add.service');
    Route::get('/service-edit/{id}', [ServiceController::class, 'edit'])->name('service.edit');
    Route::get('/service-delete/{id}', [ServiceController::class, 'delete'])->name('service.delete');
    Route::post('/service-store', [ServiceController::class, 'store'])->name('service.store');
    Route::post('/service-image-store', [ServiceController::class, 'storeimage'])->name('service.storeimage');
    Route::post('/service-image-delete', [ServiceController::class, 'deleteimage'])->name('service.deleteimage');

    // Rate Type

    Route::get('rate-type', [RateTypeController::class, 'index'])->name('rate-type');
    Route::get('add-rate-type', [RateTypeController::class, 'add'])->name('add.rate-type');
    Route::get('/rate-type-edit/{id}', [RateTypeController::class, 'edit'])->name('rate-type.edit');
    Route::get('/rate-type-delete/{id}', [RateTypeController::class, 'delete'])->name('rate-type.delete');
    Route::post('/rate-type-store', [RateTypeController::class, 'store'])->name('rate-type.store');

    // Rate Plan

    Route::get('rate-plan', [RatePlanController::class, 'index'])->name('rate-plan');
    Route::get('add-rate-plan', [RatePlanController::class, 'add'])->name('add.rate-plan');
    Route::get('/rate-plan-edit/{id}', [RatePlanController::class, 'edit'])->name('rate-plan.edit');
    Route::get('/rate-plan-delete/{id}', [RatePlanController::class, 'delete'])->name('rate-plan.delete');
    Route::post('/rate-plan-store', [RatePlanController::class, 'store'])->name('rate-plan.store');
    Route::post('/derived-rate-plan-store', [RatePlanController::class, 'derived_store'])->name('rate-plan.set-derived');

    // Extra
    Route::get('extra', [ExtraController::class, 'index'])->name('extra');
    Route::get('add-extra', [ExtraController::class, 'add'])->name('add.extra');
    Route::get('/extra-edit/{id}', [ExtraController::class, 'edit'])->name('extra.edit');
    Route::get('/extra-delete/{id}', [ExtraController::class, 'delete'])->name('extra.delete');
    Route::post('/extra-store', [ExtraController::class, 'store'])->name('extra.store');


    // Coupon
    Route::get('coupon', [CouponController::class, 'index'])->name('coupon');
    Route::get('add-coupon', [CouponController::class, 'add'])->name('add.coupon');
    Route::get('/coupon-edit/{id}', [CouponController::class, 'edit'])->name('coupon.edit');
    Route::get('/coupon-delete/{id}', [CouponController::class, 'delete'])->name('coupon.delete');
    Route::post('/coupon-store', [CouponController::class, 'store'])->name('coupon.store');

    // Offer
    Route::get('offer', [OfferController::class, 'index'])->name('offer');
    Route::get('add-offer', [OfferController::class, 'add'])->name('add.offer');
    Route::get('/offer-edit/{id}', [OfferController::class, 'edit'])->name('offer.edit');
    Route::get('/offer-delete/{id}', [OfferController::class, 'delete'])->name('offer.delete');
    Route::post('/offer-store', [OfferController::class, 'store'])->name('offer.store');

    // Calender
    Route::get('calender', [InventoryMasterController::class, 'calender'])->name('hotel.calender');
    Route::post('calender-store', [InventoryMasterController::class, 'store'])->name('hotel.calender.store');

    Route::post('get-calender-data', [InventoryMasterController::class, 'getCalendarData'])->name('hotel.get.calender.data');

    Route::post('hotel-manage-calender-data', [InventoryMasterController::class, 'manageStoreCalendarData'])->name('hotel.manage.calendar.data');

    // Bulk update
    Route::get('bulk-update', [BulkController::class, 'index'])->name('hotel.bulk.update');
    Route::post('hotel-manage-bulk-calender-data', [BulkController::class, 'manageStoreBulkCalendarData'])->name('hotel.manage.bulk.calendar.data');
    Route::post('bulk-update', [BulkController::class, 'store'])->name('hotel.bulk.update');

    //logs
    Route::get('hotel-logs', [LogsController::class, 'index'])->name('hotel.logs');
    Route::post('hotel-display-logs-data', [LogsController::class, 'dataList'])->name('hotel.display.logs.data');
    Route::get('hotel-logs-details/{id?}', [LogsController::class, 'logsDetails'])->name('hotel.logs.details');


    Route::get('booking-list', [BookingController::class, 'index'])->name('hotel.booking');
    Route::post('booking-list', [BookingController::class, 'listData'])->name('hotel.list.booking.data');
    Route::get('/booking-detail/{id}', [BookingController::class, 'detail'])->name('hotel.detail.booking.data');
    Route::get('/booking-edit/{id}', [BookingController::class, 'booking_edit'])->name('hotel.edit.booking.data');
    Route::post('booking-update', [BookingController::class, 'update'])->name('hotel.update.booking.data');
    Route::post('booking-status', [BookingController::class, 'booking_status'])->name('hotel.status.booking.data');
    Route::post('/booking-delete', [BookingController::class, 'booking_delete'])->name('hotel.delete.booking.data');
    Route::post('/booking-duplicat', [BookingController::class, 'booking_duplicat'])->name('hotel.duplicat.booking.data');

    Route::get('service-booking-list', [ServiceBookingController::class, 'index'])->name('service.booking');
    Route::post('service-booking-list', [ServiceBookingController::class, 'listData'])->name('service.list.booking.data');
    Route::get('/service-booking-detail/{id}', [ServiceBookingController::class, 'detail'])->name('service.detail.booking.data');

    //reports
    Route::get('/reports', [BookingController::class, 'reports'])->name('hotel.reports');
    Route::post('booking-report', [BookingController::class, 'reportData_ajax'])->name('hotel.report.booking.data');

    //booking requests
    Route::get('/requests', [RequestBookingController::class, 'index'])->name('hotel.requests');
    Route::post('requests-data', [RequestBookingController::class, 'listData'])->name('hotel.requests.booking.data');
    Route::post('requests-upload', [RequestBookingController::class, 'requestsUpload'])->name('hotel.requests.booking.upload');

    // whatsapp template
    Route::get('whatsapp-template', [WhatsappTemplateController::class, 'index'])->name('whatsapp-template');
    Route::get('add-whatsapp-template', [WhatsappTemplateController::class, 'add'])->name('add.whatsapp-template');
    Route::get('/whatsapp-template-edit/{id}', [WhatsappTemplateController::class, 'edit'])->name('whatsapp-template.edit');
    Route::get('/whatsapp-template-delete/{id}', [WhatsappTemplateController::class, 'delete'])->name('whatsapp-template.delete');
    Route::post('/whatsapp-template-store', [WhatsappTemplateController::class, 'store'])->name('whatsapp-template.store');

});
