<?php

use App\Http\Controllers\ControllerAdmin;
use App\Http\Controllers\ControllerCart;
use App\Http\Controllers\ControllerShop;
use App\Http\Controllers\ControllerUser;
use App\Http\Controllers\ControllerWishlist;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\OtpVerificationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ContactQueryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminAuthentication;
use App\Http\Controllers\Admin\PaymentVerificationController;
use App\Http\Controllers\Admin\ShippingDetailController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::view('/about', 'about')->name('about');
Route::view('/terms',  'terms')->name('terms');
Route::view('/refund-cancellation', 'refund')->name('refund');
Route::view('/faqs',   'faqs')->name('faqs');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/shop',                [ControllerShop::class, 'index'])->name('shop.index');
Route::get('/shop/{product_slug}', [ControllerShop::class, 'details_product'])
    ->name('shop.product.details');

/*
|--------------------------------------------------------------------------
| Cart & Wishlist (public)
|--------------------------------------------------------------------------
*/
Route::get('/cart',                            [ControllerCart::class, 'index'])->name('cart.index');
Route::post('/cart/add',                       [ControllerCart::class, 'add_to_cart'])->name('cart.add');
Route::put('/cart/update-quantity-increase/{rowId}', [ControllerCart::class, 'cart_quantity_increase'])
    ->name('cart.quantity.increase');
Route::put('/cart/update-quantity-decrease/{rowId}', [ControllerCart::class, 'cart_quantity_decrease'])
    ->name('cart.quantity.decrease');
Route::delete('/cart/delete/{rowId}',          [ControllerCart::class, 'cart_item_remove'])->name('cart.delete');
Route::delete('/cart/clear',                   [ControllerCart::class, 'cart_empty'])->name('cart.clear');
Route::post('/cart/apply-coupon',              [ControllerCart::class, 'coupons_apply_to_cart'])->name('cart.apply.coupon');
Route::delete('/cart/remove-coupon',           [ControllerCart::class, 'delete_coupon_code'])->name('cart.remove.coupon');

Route::post('/wishlist/add',                   [ControllerWishlist::class, 'add_to_wishlist'])->name('wishlist.add');
Route::get('/wishlist',                        [ControllerWishlist::class, 'index'])->name('wishlist.index');
Route::delete('/wishlist/delete/{rowId}',      [ControllerWishlist::class, 'wishlist_item_remove'])->name('wishlist.delete');
Route::delete('/wishlist/clear',               [ControllerWishlist::class, 'wishlist_empty'])->name('wishlist.clear');
Route::post('/wishlist/move-to-cart/{rowId}',  [ControllerWishlist::class, 'wishlist_to_cart'])->name('wishlist.move.to.cart');

Route::get('/search', [HomeController::class, 'product_search'])->name('home.search');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/account-dashboard', [ControllerUser::class, 'index'])->name('user.index');

    Route::get('/user/page-search', [ControllerUser::class, 'pageSearch'])
        ->name('user.page.search');

    // Orders & Payments
    Route::get('/account-orders',             [ControllerUser::class, 'orders'])->name('user.orders');
    Route::get(
        '/account/orders/details/{order_id}',
        [ControllerUser::class, 'details_about_orders']
    )->name('user.order.details');
    Route::put('/account/orders/cancel',      [ControllerUser::class, 'order_status_update'])->name('user.order.cancel');

    // Checkout
    Route::get('/checkout',                   [ControllerCart::class, 'checkout'])->name('cart.checkout');
    Route::post('/place-order',               [ControllerCart::class, 'order_place'])->name('cart.checkout.place.order');
    Route::get('/confirmation-of-order',      [ControllerCart::class, 'confirmation_of_order'])
        ->name('cart.confirmation.of.order');

    // Address Management
    Route::get('/user-address-details', [ControllerUser::class, 'user_address'])
    ->name('user.address-details');

Route::get('/user-address-create',  [ControllerUser::class, 'create_address'])
    ->name('user.address-create');

Route::post('/user/address/create', [ControllerUser::class, 'storeAddress'])
    ->name('user.address.store');

Route::get('/user-address/{id}/edit', [ControllerUser::class, 'modify_address'])
    ->whereNumber('id')
    ->name('user.address-modify');

Route::match(['put','patch'], '/user-address/{id}', [ControllerUser::class, 'update_address'])
    ->whereNumber('id')
    ->name('user.address.update');

Route::patch('/user-address/{id}/set-default', [ControllerUser::class, 'set_default_address'])
    ->whereNumber('id')
    ->name('user.address-set-default');

Route::delete('/user-address/{id}', [ControllerUser::class, 'destroy_address'])
    ->whereNumber('id')
    ->name('user.address-destroy');


    // Account Details
    Route::get('/account-details',            [ControllerUser::class, 'dashboard'])->name('user.dashboard');
    Route::put('user/update-password',        [ControllerUser::class, 'updatePassword'])->name('user.updatePassword');
    Route::put('user/update-details',         [ControllerUser::class, 'updateDetails'])->name('user.update.details');

    // Payment Verification (post‐estimate)
    Route::get('/orders/{order}/verify-payment',  [ControllerCart::class, 'showVerifyPaymentForm'])
        ->name('payment.verify');
    Route::post('/orders/{order}/verify-payment', [ControllerCart::class, 'verifyPayment'])
        ->name('payment.verify.submit');
});

/*
|--------------------------------------------------------------------------
| Password Reset & OTP
|--------------------------------------------------------------------------
*/
Route::post('/forgot-password/send-otp', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');
Route::get('/forgot-password/email',    [ForgotPasswordController::class, 'reset_email'])->name('forgot-password.email');
Route::post('/forgot-password/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])
    ->name('password.verifyOtp');
Route::put('/forgot-password/reset',    [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');
Route::get('/forgot-password/reset-password', [ForgotPasswordController::class, 'reset_password_form'])
    ->name('forgot-password.reset-password');
Route::get('/verify-otp',               [OtpVerificationController::class, 'showVerifyOtpForm'])->name('verify.otp');
Route::post('/verify-otp',              [OtpVerificationController::class, 'verifyOtp'])->name('verify.otp.submit');
Route::post('/resend-otp',              [RegisterController::class, 'resendOtp'])->name('resend.otp');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', AdminAuthentication::class])->group(function () {
    // Dashboard
    Route::get('/admin',                  [ControllerAdmin::class, 'index'])->name('admin.index');

    Route::get('/admin/page-search', [ControllerAdmin::class, 'pageSearch'])
        ->name('admin.page.search');


    // List & search
    Route::get(
        '/admin/payment-verifications',
        [PaymentVerificationController::class, 'index']
    )->name('admin.payment-verifications.index');

    // Show one (opens in new tab)
    Route::get(
        '/admin/payment-verifications/{verification}',
        [PaymentVerificationController::class, 'show']
    )->name('admin.payment-verifications.show');

    // Delete
    Route::delete(
        '/admin/payment-verifications/{verification}',
        [PaymentVerificationController::class, 'destroy']
    )->name('admin.payment-verifications.destroy');

    Route::put(
        '/admin/payment-verifications/{verification}/verify',
        [PaymentVerificationController::class, 'verify']
    )->name('admin.payment-verifications.verify');


    Route::put(
        'admin/orders/{order}/shipping-details',
        [ShippingDetailController::class, 'update']
    )->name('admin.shipping-details.update');

    // Brands
    Route::get('/admin/brands',           [ControllerAdmin::class, 'brands'])->name('admin.brands');
    Route::get('/admin/brand/add',        [ControllerAdmin::class, 'add_brand'])->name('admin.brand.add');
    Route::post('/admin/brand/save',      [ControllerAdmin::class, 'save_brand'])->name('admin.brand.save');
    Route::get('/admin/brand/modify/{id}', [ControllerAdmin::class, 'modify_brand'])->name('admin.brand.modify');
    Route::put('/admin/brand/update',     [ControllerAdmin::class, 'brand_update'])->name('admin.brand.update');
    Route::delete('/admin/brand/remove/{id}', [ControllerAdmin::class, 'remove_brand'])->name('admin.brand.remove');

    // Categories
    Route::get('/admin/category',         [ControllerAdmin::class, 'category'])->name('admin.category');
    Route::get('/admin/category/create',  [ControllerAdmin::class, 'create_category'])->name('admin.category.create');
    Route::post('/admin/category/save',   [ControllerAdmin::class, 'save_category'])->name('admin.category.save');
    Route::get('/admin/category/modify/{id}', [ControllerAdmin::class, 'modify_category'])->name('admin.category.modify');
    Route::put('/admin/category/update',  [ControllerAdmin::class, 'category_update'])->name('admin.category.update');
    Route::delete('/admin/category/remove/{id}', [ControllerAdmin::class, 'remove_category'])
        ->name('admin.category.remove');

    // Products
    Route::get('/admin/products',         [ControllerAdmin::class, 'products'])->name('admin.products');
    Route::get('/admin/products/create',  [ControllerAdmin::class, 'create_products'])->name('admin.products_create');
    Route::post('/admin/products/save',   [ControllerAdmin::class, 'save_products'])->name('admin.products.save');
    Route::get('/admin/products/modify/{id}', [ControllerAdmin::class, 'modify_products'])
        ->name('admin.products.modify');
    Route::put('/admin/products/update',  [ControllerAdmin::class, 'update_product'])->name('admin.products.update');
    Route::delete('/admin/products/remove/{id}', [ControllerAdmin::class, 'remove_product'])
        ->name('admin.products.remove');

    // Coupons
    Route::get('/admin/coupons',          [ControllerAdmin::class, 'coupons'])->name('admin.coupons');
    Route::get('/admin/coupons/add',      [ControllerAdmin::class, 'coupons_add'])->name('admin.coupons.add');
    Route::post('/admin/coupons/save',    [ControllerAdmin::class, 'save_coupon'])->name('admin.coupons.save');
    Route::get('/admin/coupons/modify/{id}', [ControllerAdmin::class, 'modify_coupon'])
        ->name('admin.coupons.modify');
    Route::put('/admin/coupons/update',   [ControllerAdmin::class, 'coupon_update'])->name('admin.coupons.update');
    Route::delete('/admin/coupons/remove/{id}', [ControllerAdmin::class, 'remove_coupon'])
        ->name('admin.coupons.remove');

    // Orders
    Route::get('/admin/orders',           [ControllerAdmin::class, 'orders'])->name('admin.orders');
    Route::get('/admin/orders/details/{order_id}', [ControllerAdmin::class, 'details_about_orders'])
        ->name('admin.order.details');
    Route::put('/admin/orders/status-update', [ControllerAdmin::class, 'order_status_update'])
        ->name('admin.order.status.update');
    Route::put('/admin/orders/shipping-update', [ControllerAdmin::class, 'updateShipping'])
        ->name('admin.order.shipping.update');

    // Slides
    Route::get('/admin/slides',           [ControllerAdmin::class, 'slide'])->name('admin.slides');
    Route::get('/admin/slides/create',    [ControllerAdmin::class, 'slider_create'])->name('admin.slides.create');
    Route::post('/admin/slides/save',     [ControllerAdmin::class, 'save_slider'])->name('admin.slides.save');
    Route::get('/admin/slides/modify/{id}', [ControllerAdmin::class, 'modify_slider'])
        ->name('admin.slides.modify');
    Route::put('/admin/slides/update',    [ControllerAdmin::class, 'update_slider'])->name('admin.slides.update');
    Route::delete('/admin/slides/remove/{id}', [ControllerAdmin::class, 'remove_slide'])
        ->name('admin.slide.remove');

    // Search
    Route::get('/admin/search',           [ControllerAdmin::class, 'search'])->name('admin.search');

    // Settings
    Route::get('/account-settings',       [ControllerAdmin::class, 'dashboard'])->name('admin.settings');
    Route::put('admin/update-details',    [ControllerAdmin::class, 'updateDetails'])->name('admin.updateDetails');
    Route::put('admin/update-password',   [ControllerAdmin::class, 'updatePassword'])->name('admin.updatePassword');

    // Users
    Route::get('/admin/users',            [ControllerAdmin::class, 'usersWithOrderCount'])->name('admin.users');
    Route::delete('/admin/user/remove/{id}', [ControllerAdmin::class, 'remove_user'])
        ->name('admin.user.remove');

    // Contact Queries
    Route::get('/admin/contact-queries',          [ContactQueryController::class, 'index'])
        ->name('contact-queries.index');
    Route::get('/admin/contact-queries/{query}',  [ContactQueryController::class, 'show'])
        ->name('admin.contact-queries.show');
    Route::post('/admin/contact-queries/{query}/reply', [ContactQueryController::class, 'reply'])
        ->name('admin.contact-queries.reply');
    Route::delete('/admin/contact-queries/{query}',    [ContactQueryController::class, 'destroy'])
        ->name('admin.contact-queries.destroy');
});

// Home (fallback)
Route::get('/home', [HomeController::class, 'index'])->name('home');
