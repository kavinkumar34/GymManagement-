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

// ============ NEW CONTROLLERS ============
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\TopCategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ProductTypeController;
use App\Http\Controllers\Admin\SizeChartController;
use App\Http\Controllers\ProductDetailController;  // ADD THIS LINE

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// ============ HOME PAGE ============
Route::get('/', function () {
    return view('home');
})->name('home');

// ============ PRODUCT DETAIL PAGE (MUST BE OUTSIDE ADMIN GROUP) ============
Route::get('/product/{id}', [ProductDetailController::class, 'show'])->name('product.show');

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
    
    // ============ DASHBOARD ============
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
    
    // Top Category Routes
    Route::get('/topcategories', [TopCategoryController::class, 'index'])->name('topcategories.index');
    Route::get('/topcategories/create', [TopCategoryController::class, 'create'])->name('topcategories.create');
    Route::post('/topcategories', [TopCategoryController::class, 'store'])->name('topcategories.store');
    Route::get('/topcategories/{id}/edit', [TopCategoryController::class, 'edit'])->name('topcategories.edit');
    Route::put('/topcategories/{id}', [TopCategoryController::class, 'update'])->name('topcategories.update');
    Route::delete('/topcategories/{id}', [TopCategoryController::class, 'destroy'])->name('topcategories.destroy');

    // ============ BRAND MANAGEMENT ROUTES ============
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/brands/{id}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/brands/{id}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');
    
    // ============ CATEGORY MANAGEMENT ROUTES ============
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
    // ============ SUB CATEGORY MANAGEMENT ROUTES ============
    Route::get('/subcategories', [SubCategoryController::class, 'index'])->name('subcategories.index');
    Route::get('/subcategories/create', [SubCategoryController::class, 'create'])->name('subcategories.create');
    Route::post('/subcategories', [SubCategoryController::class, 'store'])->name('subcategories.store');
    Route::get('/subcategories/{id}/edit', [SubCategoryController::class, 'edit'])->name('subcategories.edit');
    Route::put('/subcategories/{id}', [SubCategoryController::class, 'update'])->name('subcategories.update');
    Route::delete('/subcategories/{id}', [SubCategoryController::class, 'destroy'])->name('subcategories.destroy');
    
    // ============ PRODUCT TYPE MANAGEMENT ROUTES ============
    Route::get('/producttypes', [ProductTypeController::class, 'index'])->name('producttypes.index');
    Route::get('/producttypes/create', [ProductTypeController::class, 'create'])->name('producttypes.create');
    Route::post('/producttypes', [ProductTypeController::class, 'store'])->name('producttypes.store');
    Route::get('/producttypes/{id}/edit', [ProductTypeController::class, 'edit'])->name('producttypes.edit');
    Route::put('/producttypes/{id}', [ProductTypeController::class, 'update'])->name('producttypes.update');
    Route::delete('/producttypes/{id}', [ProductTypeController::class, 'destroy'])->name('producttypes.destroy');
    
    // ============ ATTRIBUTE MANAGEMENT ROUTES ============
    Route::get('/attributes', [AttributeController::class, 'index'])->name('attributes.index');
    Route::get('/attributes/create', [AttributeController::class, 'create'])->name('attributes.create');
    Route::post('/attributes', [AttributeController::class, 'store'])->name('attributes.store');
    Route::get('/attributes/{id}/edit', [AttributeController::class, 'edit'])->name('attributes.edit');
    Route::put('/attributes/{id}', [AttributeController::class, 'update'])->name('attributes.update');
    Route::delete('/attributes/{id}', [AttributeController::class, 'destroy'])->name('attributes.destroy');
    
    // ============ SIZE CHART MANAGEMENT ROUTES ============
    Route::get('/sizecharts', [SizeChartController::class, 'index'])->name('sizecharts.index');
    Route::get('/sizecharts/create', [SizeChartController::class, 'create'])->name('sizecharts.create');
    Route::post('/sizecharts', [SizeChartController::class, 'store'])->name('sizecharts.store');
    Route::get('/sizecharts/{id}/edit', [SizeChartController::class, 'edit'])->name('sizecharts.edit');
    Route::put('/sizecharts/{id}', [SizeChartController::class, 'update'])->name('sizecharts.update');
    Route::delete('/sizecharts/{id}', [SizeChartController::class, 'destroy'])->name('sizecharts.destroy');
    
    // ============ PRODUCT MANAGEMENT ROUTES ============
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

    // ============ QUICK ADD CATEGORY (AJAX) ============
    Route::post('/categories/quick-store', [CategoryController::class, 'quickStore'])->name('categories.quick.store');
    
    // ============ VIEW PRODUCTS IN CATEGORY ============
    Route::get('/categories/{id}/products', [CategoryController::class, 'showProducts'])->name('categories.products');
    
    // ============ AJAX ROUTES FOR DYNAMIC FORMS ============
    Route::get('/get-categories/{topId}', [CategoryController::class, 'getByTopCategory'])->name('get.categories');
    Route::get('/get-subcategories/{categoryId}', [SubCategoryController::class, 'getByCategory'])->name('get.subcategories');
    Route::get('/get-producttypes/{subCategoryId}', [ProductTypeController::class, 'getBySubCategory'])->name('get.producttypes');
    Route::get('/get-category-attributes/{categoryId}', [AttributeController::class, 'getCategoryAttributes'])->name('get.category.attributes');
    Route::get('/get-subcategory-attributes/{subCategoryId}', [AttributeController::class, 'getSubCategoryAttributes'])->name('get.subcategory.attributes');
    
    // Stock Update (AJAX)
    Route::post('/update-stock', [ProductController::class, 'updateStock'])->name('update.stock');
    
    // ============ CONTACT MANAGEMENT ROUTES ============
    Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{id}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{id}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
    Route::post('/contacts/{id}/status', [AdminContactController::class, 'updateStatus'])->name('contacts.status');
    
    // ============ BANNER MANAGEMENT ROUTES ============
    Route::get('/banners', [BannerController::class, 'index'])->name('banners.index');
    Route::get('/banners/create', [BannerController::class, 'create'])->name('banners.create');
    Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
    Route::get('/banners/{id}/edit', [BannerController::class, 'edit'])->name('banners.edit');
    Route::put('/banners/{id}', [BannerController::class, 'update'])->name('banners.update');
    Route::delete('/banners/{id}', [BannerController::class, 'destroy'])->name('banners.destroy');
    
    // ============ PAYMENT/ORDER MANAGEMENT ROUTES ============
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [AdminPaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [AdminPaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{id}/edit', [AdminPaymentController::class, 'edit'])->name('payments.edit');
    Route::put('/payments/{id}', [AdminPaymentController::class, 'update'])->name('payments.update');
    Route::delete('/payments/{id}', [AdminPaymentController::class, 'destroy'])->name('payments.destroy');
    Route::post('/payments/{id}/status', [AdminPaymentController::class, 'updateStatus'])->name('payments.status');
    Route::post('/payments/mark-viewed', [AdminPaymentController::class, 'markViewed'])->name('payments.mark-viewed');
    Route::get('/payments/check-new', [AdminPaymentController::class, 'getNewOrdersCount'])->name('payments.check-new');
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