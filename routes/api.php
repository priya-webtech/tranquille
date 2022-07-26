<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BookingController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
/*===== Commun Route Without Auth ============*/
Route::get('country', [CustomController::class, 'getCountry']);
Route::get('language', [CustomController::class, 'getLanguage']);
Route::get('getServices', [CustomController::class, 'getServices']);
Route::get('getServiceTreatments', [CustomController::class, 'getServiceTreatments']);
Route::get('getServiceFilterDate', [CustomController::class, 'getServiceFilterDate']);
/*===== User  Route ============*/
Route::post('register', [AuthController::class, 'register']);
Route::post('verify_email_otp', [AuthController::class, 'verifyEmailOtp']);
Route::post('forget_password', [AuthController::class, 'forgetPassword']);
Route::post('verify_forget_otp', [AuthController::class, 'verifyEmailOtp']);
Route::post('resetPassword', [AuthController::class, 'resetPassword']);
Route::post('checkphone', [AuthController::class, 'checkPhone']);
Route::post('checkemail', [AuthController::class, 'checkemail']);
Route::post('phoneOtpRequest', [AuthController::class, 'phoneOtpRequest']);
Route::post('emailOtpRequest', [AuthController::class, 'emailOtpRequest']);
Route::post('socialLogin', [AuthController::class, 'socialLogin']);
Route::post('login', [AuthController::class, 'login']);
Route::post('searchVendorFilter', [VendorController::class, 'searchVendorFilter']);
Route::post('searchVendorList', [VendorController::class, 'searchVendorList']);
Route::post('contactUs', [CustomController::class, 'contactUs']);
Route::post('getProductBrand', [CustomController::class, 'getProductBrand']);
Route::post('getVendorInfo', [VendorController::class, 'getVendorInfo']);
Route::get('subscriptionPlan', [CustomController::class, 'subscriptionPlan']);
Route::post('userDashboard', [UserController::class, 'userDashboard']);
Route::post('dashboardServices', [UserController::class, 'dashboardServices']);
/*===== Vender Route ============*/
Route::post('venderRegisterFirst', [VendorController::class, 'venderRegisterFirst']);
Route::get('getYearsList', [BookingController::class, 'getYearsList']);
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('changePassword', [AuthController::class, 'changePassword']);
    Route::get('getuserInfo', [AuthController::class, 'getuserInfo']);
    //Notification 
    Route::get('notificationList', [UserController::class, 'notificationList']);
    Route::get('getuserEarnList', [CustomController::class, 'getuserEarnList']);
    Route::post('referralEarn', [CustomController::class, 'referralEarn']);

    /*===== User Auth Route ============*/
    Route::post('updateUser', [AuthController::class, 'updateProfile']);
    Route::post('availableVendorSlot', [BookingController::class, 'availableVendorSlot']);
    Route::post('booking', [BookingController::class, 'booking']);
    Route::post('bookingInfo', [BookingController::class, 'bookingInfo']);
    Route::post('bookingActiveStatus', [BookingController::class, 'bookingActiveStatus']);
    Route::post('bookingPaymentStatus', [BookingController::class, 'bookingPaymentStatus']);
    Route::post('bookingPaymentMethodUpdate', [BookingController::class, 'bookingPaymentMethodUpdate']);
    Route::post('getstripeToken', [BookingController::class, 'getstripeToken']);
    //Customer Booking
    Route::get('customerUpcomingBooking', [BookingController::class, 'customerUpcomingBooking']);
    Route::get('customerPreviousBooking', [BookingController::class, 'customerPreviousBooking']);
    Route::get('customerTransectionList', [BookingController::class, 'customerTransectionList']);
    //Cancel Booking
    Route::post('cancelBooking', [BookingController::class, 'cancelBooking']);
    //Reschedule Booking
    Route::post('rescheduleBooking', [BookingController::class, 'rescheduleBooking']);
    //Rating Booking
    Route::post('ratingBooking', [BookingController::class, 'ratingBooking']);
    //Delete Booking
    Route::post('deleteBooking', [BookingController::class, 'deleteBooking']);
    //Delete Notification
    Route::post('deleteNotification', [BookingController::class, 'deleteNotification']);
    /*===== End User Auth Route ============*/

    /*===== Vender Auth Route ============*/
    Route::get('checkMembership', [CustomController::class, 'checkMembership']);
    Route::post('vendorService', [VendorController::class, 'vendorService']);
    Route::post('vendorTreatments', [VendorController::class, 'vendorTreatments']);
    Route::post('venderRegisterThree', [VendorController::class, 'venderRegisterThree']);
    Route::post('venderRegisterLogo', [VendorController::class, 'venderRegisterLogo']);
    Route::post('venderRegisterLocation', [VendorController::class, 'venderRegisterLocation']);
    Route::post('venderLocationUpdate', [VendorController::class, 'venderLocationUpdate']);
    Route::post('venderRegisterWhyChooseYou', [VendorController::class, 'venderRegisterWhyChooseYou']);
    Route::post('venderRegisterBusineesHours', [VendorController::class, 'venderRegisterBusineesHours']);
    Route::post('venderRegisterWorkDemos', [VendorController::class, 'venderRegisterWorkDemos']);
    Route::post('vendorEditInformation', [VendorController::class, 'updateVendorInfo']);
    Route::post('updateVendorAddress', [VendorController::class, 'updateVendorAddress']);
    Route::post('vendorWorkGallerydelete', [VendorController::class, 'deleteVendorGallery']);
    Route::post('vendorAddNewTeamMember', [VendorController::class, 'vendorAddNewTeamMember']);
    Route::get('getVendorTeamMember', [VendorController::class, 'getVendorTeamMember']);
    Route::post('statusChangeTeamMember', [VendorController::class, 'statusChangeTeamMember']);
    Route::post('vendorDeleteTeamMember', [VendorController::class, 'vendorDeleteTeamMember']);
    Route::get('getVendorServiceTreatment', [VendorController::class, 'getVendorServiceTreatment']);
    //Vendore Appointments / Booking
    Route::get('vendorRequestBooking', [BookingController::class, 'vendorRequestBooking']);
    Route::get('vendorUpcomingBooking', [BookingController::class, 'vendorUpcomingBooking']);
    Route::get('vendorPreviousBooking', [BookingController::class, 'vendorPreviousBooking']);
    //Vendor Payment List
    Route::get('vendorTransectionList', [BookingController::class, 'vendorTransectionList']);
    Route::post('earningReportDownload', [BookingController::class, 'earningReportDownload']);
    Route::post('deleteTransection', [BookingController::class, 'deleteTransection']);
    //Delete Vendore Service and Treatment
    Route::post('vendorDeleteService', [VendorController::class, 'vendorDeleteService']);
    Route::post('vendorDeleteTreatment', [VendorController::class, 'vendorDeleteTreatment']);
    Route::post('renewMembership', [VendorController::class, 'renewMembership']);
    Route::post('purchaseMembership', [VendorController::class, 'purchaseMembership']);
    Route::post('purchaseMembershipResponse', [VendorController::class, 'purchaseMembershipResponse']);
    Route::post('purchaseMembershipStatus', [VendorController::class, 'purchaseMembershipStatus']);
    //Accept Booking
    Route::post('acceptBooking', [BookingController::class, 'acceptBooking']);
    //Done Booking
    Route::post('doneBooking', [BookingController::class, 'doneBooking']);
    //Reject Booking
    Route::post('rejectBooking', [BookingController::class, 'rejectBooking']);
    Route::get('getVendorRatings', [BookingController::class, 'getVendorRatings']);
    //Reschedule Booking by Vendor
    Route::post('rescheduleVendorBooking', [BookingController::class, 'rescheduleVendorBooking']);
    Route::get('calendarBooking', [BookingController::class, 'calendarBooking']);
    Route::post('bookingPayment', [BookingController::class, 'bookingPayment']);
    Route::post('blockBookingTime', [BookingController::class, 'blockBookingTime']);
    Route::post('getbookingPaymentStatus', [BookingController::class, 'getbookingPaymentStatus']);
    Route::post('getCalendarSchedule', [BookingController::class, 'getCalendarSchedule']);
    Route::post('updateNotifySetting', [CustomController::class, 'updateNotifySetting']);
    Route::post('AddNewClient', [AuthController::class, 'AddNewClient']);
    Route::post('searchClient', [CustomController::class, 'searchClient']);
});
