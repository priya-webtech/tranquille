<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\ProductBrandController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\BookingDashboardController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\RefferController;
use App\Http\Controllers\PolicyController;
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

Route::get('/', function () {
    return view('auth.login');
});


Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('notifications', [UserController::class, 'notifications']);
    Route::get('latest-notification', [UserController::class, 'get_latest_notification']);
    /*=== dropdown Route ===*/
    Route::get('serviceDropdown', [CommonController::class, 'serviceDropdown']);
    Route::post('treatmentDropdown', [CommonController::class, 'treatmentDropdown'])->name('treatmentDropdown');
    Route::post('userDropdown', [CommonController::class, 'userDropdown'])->name('userDropdown');
    Route::post('vendorDropdown', [CommonController::class, 'vendorDropdown'])->name('vendorDropdown');
    /*=== Users Route ===*/
    Route::resource('dashboard', CommonController::class, ['except' => ['create', 'update']]);
    Route::get('/changePassword', [CommonController::class, 'showChangePasswordGet'])->name('changePasswordGet');
    Route::post('/changePassword', [CommonController::class, 'changePasswordPost'])->name('changePasswordPost');
    // Route::any('toptenvendor', [CommonController::class, 'toptenvendor']);
    /*=== Users Route ===*/
    Route::resource('users', UserController::class, ['except' => ['create', 'update']]);
    /*=== Approval Route ===*/
    Route::get('approval', [UserController::class, 'approval'])->name('approval');
    Route::get('booking/list', [UserController::class, 'bookinglist'])->name('bookinglist');
    Route::get('ratinglist', [UserController::class, 'ratinglist'])->name('ratinglist');
    Route::get('userNotification', [UserController::class, 'userNotification'])->name('userNotification');
    Route::get('userReffer', [UserController::class, 'userReffer'])->name('userReffer');
    Route::get('userTransection', [UserController::class, 'userTransection'])->name('userTransection');
    /*=== Vendors Route ===*/
    Route::resource('vendors', VendorController::class);
    Route::post('vendors-active', [VendorController::class, 'active'])->name('vendors-active');
    Route::post('vendordetail', [VendorController::class, 'show'])->name('vendordetail');
    Route::get('vendorBooking', [VendorController::class, 'vendorBooking'])->name('vendorBooking');
    Route::get('vendorNotification', [VendorController::class, 'vendorNotification'])->name('vendorNotification');
    Route::get('vendorMembership', [VendorController::class, 'vendorMembership'])->name('vendorMembership');
    Route::get('vendorReview', [VendorController::class, 'vendorReview'])->name('vendorReview');
    Route::get('teamMember', [VendorController::class, 'teamMember'])->name('teamMember');
    Route::get('vendorOffer', [VendorController::class, 'vendorOffer'])->name('vendorOffer');
    Route::delete('deleteTeam/{id}', [VendorController::class, 'deleteTeam'])->name('deleteTeam');
    Route::delete('deleteGallery/{id}', [VendorController::class, 'deleteGallery'])->name('deleteGallery');
    Route::delete('deleteProduct/{id}', [VendorController::class, 'deleteProduct'])->name('deleteProduct');
    /*=== Approvel Dashboard Route ===*/
    Route::resource('vendorApproval', ApprovalController::class, ['except' => ['create', 'update']]);
    Route::resource('dashboardBooking', BookingDashboardController::class, ['except' => ['create', 'update']]);
    //  Route::post('activation', [ApprovalController::class, 'activation'])->name('activation');
    //  Route::post('vendordetail', [VendorController::class, 'show'])->name('vendordetail');
    /*=== Role Route ===*/
    Route::resource('roles', RoleController::class, ['except' => ['create', 'show', 'update']]);
    /*=== Country Route ===*/
    Route::resource('country', CountryController::class, ['except' => ['create', 'show', 'update']]);
    /*=== Notification Route ===*/
    Route::resource('notification', NotificationController::class, ['except' => ['create', 'show', 'update']]);
    /*=== Subscription Route ===*/
    // Route::resource('subscription', SubscriptionController::class, ['only' => ['index', 'destroy']]);
    Route::resource('subscription', SubscriptionController::class, ['except' => ['create', 'show', 'update']]);
    /*=== Service Route ===*/
    Route::resource('service', ServiceController::class, ['except' => ['create', 'show', 'update']]);
    /*=== Treatment Route ===*/
    Route::resource('treatments', TreatmentController::class, ['except' => ['create', 'show', 'update']]);
    /*=== Product brand Route ===*/
    Route::resource('product', ProductBrandController::class, ['except' => ['create', 'show', 'update']]);
    /*=== contact us user Route ===*/
    Route::resource('contactus', ContactUsController::class, ['except' => ['create', 'show', 'update']]);
    /*=== offer Route ===*/
    Route::resource('offer', OfferController::class, ['except' => ['create', 'show', 'update']]);
    /*=== status user Route ===*/
    Route::resource('status', StatusController::class, ['except' => ['create', 'show', 'update']]);
    /*=== status Booking Route ===*/
    Route::resource('booking', BookingController::class, ['except' => ['create', 'show', 'update']]);
    Route::get('/booking/pdf', [BookingController::class, 'createPDF']);
    /*=== status Booking Route ===*/
    Route::resource('membership', MembershipController::class, ['except' => ['create', 'show', 'update']]);
    /*=== Review Route ===*/
    Route::resource('feedback', FeedbackController::class, ['except' => ['create', 'show', 'update']]);
    /*=== payment Route ===*/
    Route::resource('payment', PaymentController::class, ['except' => ['create', 'show', 'update']]);
    /*=== language Route ===*/
    Route::resource('language', LanguageController::class, ['except' => ['create', 'show', 'update']]);
    /*=== reffer Route ===*/
    Route::resource('reffer', RefferController::class, ['except' => ['create', 'show', 'update']]);
});

Route::get('redirectUrl/{id}', [BookingController::class, 'redirectUrl'])->name('redirectUrl');
Route::get('webhookUrl/{id}', [BookingController::class, 'webhookUrl'])->name('webhookUrl');

Route::get('privacypolicy', [PolicyController::class, 'privacypolicy']);
Route::get('cancellationpolicy', [PolicyController::class, 'cancellationpolicy']);
Route::get('termscondition', [PolicyController::class, 'termscondition']);
Route::get('howitswork', [PolicyController::class, 'howitswork']);
Route::get('aboutus', [PolicyController::class, 'aboutus']);

require __DIR__ . '/auth.php';
