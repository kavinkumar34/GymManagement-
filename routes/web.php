<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\MemberRegisterController;
use App\Http\Controllers\Auth\AdminRegisterController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\CaptchaController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\TrainerController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Trainer\TrainerDashboardController;
use App\Http\Controllers\Member\MemberDashboardController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TrackOrderController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\BannerApiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// ============ HOME PAGE ============
Route::get('/', function () {
    return view('home');
})->name('home');

// ============ CAPTCHA ============
Route::get('/captcha', [CaptchaController::class, 'generate']);

// ============ MEMBER/TRAINER LOGIN ============
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// ============ MEMBER/TRAINER REGISTER ============
Route::get('/member/register', [MemberRegisterController::class, 'showRegisterForm'])->name('member.register');
Route::post('/member/register', [MemberRegisterController::class, 'register'])->name('member.register.submit');

// ============ ADMIN LOGIN ============
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');

// ============ ADMIN REGISTER ============
Route::get('/admin/register', [AdminRegisterController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [AdminRegisterController::class, 'register'])->name('admin.register.submit');

// ============ LOGOUT ============
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// ============ CART ROUTE ============
Route::get('/cart', function () {
    return view('cart');
})->name('cart');

// ============ WISHLIST ROUTE ============
Route::get('/wishlist', function () {
    return view('wishlist');
})->name('wishlist');

// ============ CONTACT ROUTES (Public) ============
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// ============ PAYMENT ROUTES ============
Route::post('/buy-now', [PaymentController::class, 'buyNow'])->name('buy.now')->middleware('auth');
Route::post('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::post('/payment/failure', [PaymentController::class, 'paymentFailure'])->name('payment.failure');
Route::get('/order/success/{id}', [PaymentController::class, 'orderSuccess'])->name('order.success')->middleware('auth');
Route::get('/my-orders', [PaymentController::class, 'myOrders'])->name('my.orders')->middleware('auth');

// ============ TRACK ORDER ROUTE ============
Route::get('/track-order', [TrackOrderController::class, 'index'])->name('track.order');

// ============ ABOUT PAGE ============
Route::get('/about', function () {
    return view('about');
})->name('about');

// ============ ADMIN ROUTES ============
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // ============ MEMBER MANAGEMENT ROUTES ============
    Route::get('/members/create', [MemberController::class, 'create'])->name('member.create');
    Route::post('/members/store', [MemberController::class, 'store'])->name('member.store');
    Route::get('/members', [MemberController::class, 'index'])->name('members');
    Route::get('/members/{id}/edit', [MemberController::class, 'edit'])->name('member.edit');
    Route::put('/members/{id}', [MemberController::class, 'update'])->name('member.update');
    Route::delete('/members/{id}', [MemberController::class, 'destroy'])->name('member.destroy');
    Route::get('/members/{id}', [MemberController::class, 'show'])->name('member.show');
    
    // ============ TRAINER MANAGEMENT ROUTES ============
    Route::get('/trainers/create', [TrainerController::class, 'create'])->name('trainer.create');
    Route::post('/trainers/store', [TrainerController::class, 'store'])->name('trainer.store');
    Route::get('/trainers', [TrainerController::class, 'index'])->name('trainers');
    Route::get('/trainers/{id}/edit', [TrainerController::class, 'edit'])->name('trainer.edit');
    Route::put('/trainers/{id}', [TrainerController::class, 'update'])->name('trainer.update');
    Route::delete('/trainers/{id}', [TrainerController::class, 'destroy'])->name('trainer.destroy');
    Route::get('/trainers/{id}', [TrainerController::class, 'show'])->name('trainer.show');
    
    // ============ SETTINGS MANAGEMENT ROUTES ============
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/logo', [SettingsController::class, 'uploadLogo'])->name('settings.upload.logo');
    
    // ============ CATEGORY MANAGEMENT ROUTES ============
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
    // ============ QUICK ADD CATEGORY (AJAX) ============
    Route::post('/categories/quick-store', [CategoryController::class, 'quickStore'])->name('categories.quick.store');
    
    // ============ VIEW PRODUCTS IN CATEGORY ============
    Route::get('/categories/{id}/products', [CategoryController::class, 'showProducts'])->name('categories.products');
    
    // ============ PRODUCT MANAGEMENT ROUTES ============
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

    // ============ CONTACT MANAGEMENT ROUTES ============
    Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts');
    Route::get('/contacts/{id}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{id}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
    Route::post('/contacts/{id}/status', [AdminContactController::class, 'updateStatus'])->name('contacts.status');
    
    // ============ BANNER MANAGEMENT ROUTES ============
    Route::get('/banners', [BannerController::class, 'index'])->name('banners');
    Route::get('/banners/create', [BannerController::class, 'create'])->name('banners.create');
    Route::post('/banners/store', [BannerController::class, 'store'])->name('banners.store');
    Route::get('/banners/{id}/edit', [BannerController::class, 'edit'])->name('banners.edit');
    Route::put('/banners/{id}', [BannerController::class, 'update'])->name('banners.update');
    Route::delete('/banners/{id}', [BannerController::class, 'destroy'])->name('banners.destroy');
    
    // ============ PAYMENT/ORDER MANAGEMENT ROUTES ============
    // Note: Route order matters - specific routes before parameter routes
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments');
    Route::get('/payments/create', [AdminPaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments/store', [AdminPaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{id}/edit', [AdminPaymentController::class, 'edit'])->name('payments.edit');
    Route::put('/payments/{id}', [AdminPaymentController::class, 'update'])->name('payments.update');
    Route::delete('/payments/{id}', [AdminPaymentController::class, 'destroy'])->name('payments.destroy');
    Route::post('/payments/{id}/status', [AdminPaymentController::class, 'updateStatus'])->name('payments.status');
    
    // ============ PAYMENT BADGE AJAX ROUTES ============
    Route::post('/payments/mark-viewed', [AdminPaymentController::class, 'markViewed'])->name('payments.mark-viewed');
    Route::get('/payments/check-new', [AdminPaymentController::class, 'getNewOrdersCount'])->name('payments.check-new');
    
    // This route must be last in the payments group (catches specific ID after other routes)
    Route::get('/payments/{id}', [AdminPaymentController::class, 'show'])->name('payments.show');
});

// ============ TRAINER ROUTES ============
Route::middleware(['auth'])->prefix('trainer')->name('trainer.')->group(function () {
    Route::get('/dashboard', [TrainerDashboardController::class, 'index'])->name('dashboard');
});

// ============ MEMBER ROUTES ============
Route::middleware(['auth'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('dashboard');
});

// ============ API ROUTES (Public) ============
Route::get('/api/categories', [ProductApiController::class, 'getCategories']);
Route::get('/api/products', [ProductApiController::class, 'getProducts']);
Route::get('/api/best-sellers', [ProductApiController::class, 'getBestSellers']);
Route::get('/api/products/search', [ProductApiController::class, 'searchProducts']);
Route::get('/api/products/category/{id}', [ProductApiController::class, 'getProductsByCategory']);
Route::get('/api/products/stocks', [ProductApiController::class, 'getProductStocks']);
Route::get('/api/banners', [BannerApiController::class, 'getBanners']);

// ============ CART SESSION ROUTE ============
Route::post('/api/set-checkout-cart', function (Request $request) {
    session(['checkout_cart' => $request->cart]);
    return response()->json(['success' => true]);
})->middleware('auth');