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
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\Admin\DeliverablePincodeController;

// ============ MODELS ============
use App\Models\UserAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SubCategory;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


// ============ HOME PAGE ============
Route::get('/', function () {
    return view('home');
})->name('home');

// ============ PRODUCT DETAIL PAGE ============
Route::get('/product/{id}', [ProductDetailController::class, 'show'])->name('product.show');

// ============ CAPTCHA ============
Route::get('/captcha', [CaptchaController::class, 'generate']);

// ============ MEMBER/TRAINER LOGIN & REGISTER ============
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/member/register', [MemberRegisterController::class, 'showRegisterForm'])->name('member.register');
Route::post('/member/register', [MemberRegisterController::class, 'register'])->name('member.register.submit');

// ============ ADMIN LOGIN & REGISTER ============
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/register', [AdminRegisterController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [AdminRegisterController::class, 'register'])->name('admin.register.submit');

// ============ LOGOUT ============
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// ============ CART & WISHLIST & SHOP ROUTES ============
Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/wishlist', function () {
    return view('wishlist');
})->name('wishlist');

Route::get('/shop', function () {
    return view('shop');
})->name('shop');

// ============ CONTACT ROUTES ============
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// ============ PAYMENT ROUTES ============
Route::post('/buy-now', [PaymentController::class, 'buyNow'])->name('buy.now')->middleware('auth');
Route::post('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::post('/payment/failure', [PaymentController::class, 'paymentFailure'])->name('payment.failure');
Route::get('/order/success/{id}', [PaymentController::class, 'orderSuccess'])->name('order.success')->middleware('auth');
Route::get('/my-orders', [PaymentController::class, 'myOrders'])->name('my.orders')->middleware('auth');

// ============ COD ORDER ROUTE ============
Route::post('/place-cod-order', [PaymentController::class, 'placeCodOrder'])->name('place.cod.order')->middleware('auth');

// ============ TRACK ORDER & ABOUT ============
Route::get('/track-order', [TrackOrderController::class, 'index'])->name('track.order');
Route::get('/about', function () {
    return view('about');
})->name('about');

// ============ ADMIN ROUTES ============
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Member Management
    Route::get('/members/create', [MemberController::class, 'create'])->name('member.create');
    Route::post('/members/store', [MemberController::class, 'store'])->name('member.store');
    Route::get('/members', [MemberController::class, 'index'])->name('members');
    Route::get('/members/{id}/edit', [MemberController::class, 'edit'])->name('member.edit');
    Route::put('/members/{id}', [MemberController::class, 'update'])->name('member.update');
    Route::delete('/members/{id}', [MemberController::class, 'destroy'])->name('member.destroy');
    Route::get('/members/{id}', [MemberController::class, 'show'])->name('member.show');
    
    // Trainer Management
    Route::get('/trainers/create', [TrainerController::class, 'create'])->name('trainer.create');
    Route::post('/trainers/store', [TrainerController::class, 'store'])->name('trainer.store');
    Route::get('/trainers', [TrainerController::class, 'index'])->name('trainers');
    Route::get('/trainers/{id}/edit', [TrainerController::class, 'edit'])->name('trainer.edit');
    Route::put('/trainers/{id}', [TrainerController::class, 'update'])->name('trainer.update');
    Route::delete('/trainers/{id}', [TrainerController::class, 'destroy'])->name('trainer.destroy');
    Route::get('/trainers/{id}', [TrainerController::class, 'show'])->name('trainer.show');
    
    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/logo', [SettingsController::class, 'uploadLogo'])->name('settings.upload.logo');
    
    // Top Categories
    Route::get('/topcategories', [TopCategoryController::class, 'index'])->name('topcategories.index');
    Route::get('/topcategories/create', [TopCategoryController::class, 'create'])->name('topcategories.create');
    Route::post('/topcategories', [TopCategoryController::class, 'store'])->name('topcategories.store');
    Route::get('/topcategories/{id}/edit', [TopCategoryController::class, 'edit'])->name('topcategories.edit');
    Route::put('/topcategories/{id}', [TopCategoryController::class, 'update'])->name('topcategories.update');
    Route::delete('/topcategories/{id}', [TopCategoryController::class, 'destroy'])->name('topcategories.destroy');

    // Brands
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/brands/{id}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/brands/{id}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');
    
    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('/categories/quick-store', [CategoryController::class, 'quickStore'])->name('categories.quick.store');
    Route::get('/categories/{id}/products', [CategoryController::class, 'showProducts'])->name('categories.products');
    
    // Sub Categories
    Route::get('/subcategories', [SubCategoryController::class, 'index'])->name('subcategories.index');
    Route::get('/subcategories/create', [SubCategoryController::class, 'create'])->name('subcategories.create');
    Route::post('/subcategories', [SubCategoryController::class, 'store'])->name('subcategories.store');
    Route::get('/subcategories/{id}/edit', [SubCategoryController::class, 'edit'])->name('subcategories.edit');
    Route::put('/subcategories/{id}', [SubCategoryController::class, 'update'])->name('subcategories.update');
    Route::delete('/subcategories/{id}', [SubCategoryController::class, 'destroy'])->name('subcategories.destroy');
    
    // Product Types
    Route::get('/producttypes', [ProductTypeController::class, 'index'])->name('producttypes.index');
    Route::get('/producttypes/create', [ProductTypeController::class, 'create'])->name('producttypes.create');
    Route::post('/producttypes', [ProductTypeController::class, 'store'])->name('producttypes.store');
    Route::get('/producttypes/{id}/edit', [ProductTypeController::class, 'edit'])->name('producttypes.edit');
    Route::put('/producttypes/{id}', [ProductTypeController::class, 'update'])->name('producttypes.update');
    Route::delete('/producttypes/{id}', [ProductTypeController::class, 'destroy'])->name('producttypes.destroy');
    
    // Attributes
    Route::get('/attributes', [AttributeController::class, 'index'])->name('attributes.index');
    Route::get('/attributes/create', [AttributeController::class, 'create'])->name('attributes.create');
    Route::post('/attributes', [AttributeController::class, 'store'])->name('attributes.store');
    Route::get('/attributes/{id}/edit', [AttributeController::class, 'edit'])->name('attributes.edit');
    Route::put('/attributes/{id}', [AttributeController::class, 'update'])->name('attributes.update');
    Route::delete('/attributes/{id}', [AttributeController::class, 'destroy'])->name('attributes.destroy');
    
    // Size Charts
    Route::get('/sizecharts', [SizeChartController::class, 'index'])->name('sizecharts.index');
    Route::get('/sizecharts/create', [SizeChartController::class, 'create'])->name('sizecharts.create');
    Route::post('/sizecharts', [SizeChartController::class, 'store'])->name('sizecharts.store');
    Route::get('/sizecharts/{id}/edit', [SizeChartController::class, 'edit'])->name('sizecharts.edit');
    Route::put('/sizecharts/{id}', [SizeChartController::class, 'update'])->name('sizecharts.update');
    Route::delete('/sizecharts/{id}', [SizeChartController::class, 'destroy'])->name('sizecharts.destroy');
    
    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::post('/update-stock', [ProductController::class, 'updateStock'])->name('update.stock');
    
    // AJAX Routes
    Route::get('/get-categories/{topId}', [CategoryController::class, 'getByTopCategory'])->name('get.categories');
    Route::get('/get-subcategories/{categoryId}', [SubCategoryController::class, 'getByCategory'])->name('get.subcategories');
    Route::get('/get-producttypes/{subCategoryId}', [ProductTypeController::class, 'getBySubCategory'])->name('get.producttypes');
    Route::get('/get-category-attributes/{categoryId}', [AttributeController::class, 'getCategoryAttributes'])->name('get.category.attributes');
    Route::get('/get-subcategory-attributes/{subCategoryId}', [AttributeController::class, 'getSubCategoryAttributes'])->name('get.subcategory.attributes');
    
    // ⭐ GST ROUTE - Make sure this is INSIDE the admin group
    Route::get('/get-gst-rate/{topCategoryId}', [ProductController::class, 'getGstRate'])->name('get.gst.rate');
    
    // Contacts
    Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{id}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{id}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
    Route::post('/contacts/{id}/status', [AdminContactController::class, 'updateStatus'])->name('contacts.status');
    
    // Banners
    Route::get('/banners', [BannerController::class, 'index'])->name('banners.index');
    Route::get('/banners/create', [BannerController::class, 'create'])->name('banners.create');
    Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
    Route::get('/banners/{id}/edit', [BannerController::class, 'edit'])->name('banners.edit');
    Route::put('/banners/{id}', [BannerController::class, 'update'])->name('banners.update');
    Route::delete('/banners/{id}', [BannerController::class, 'destroy'])->name('banners.destroy');
    
    // Payments/Orders
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{id}', [AdminPaymentController::class, 'getOrderDetails'])->name('payments.details');
    Route::post('/payments/{id}/status', [AdminPaymentController::class, 'updateOrderStatus'])->name('payments.status');
    Route::post('/payments/{id}/shipment', [AdminPaymentController::class, 'updateShipment'])->name('payments.shipment');
    Route::get('/payments/{id}/edit', [AdminPaymentController::class, 'edit'])->name('payments.edit');
    Route::put('/payments/{id}', [AdminPaymentController::class, 'update'])->name('payments.update');
    Route::delete('/payments/{id}', [AdminPaymentController::class, 'destroy'])->name('payments.destroy');
    Route::post('/payments/mark-viewed', [AdminPaymentController::class, 'markViewed'])->name('payments.mark-viewed');
    Route::get('/payments/check-new', [AdminPaymentController::class, 'getNewOrdersCount'])->name('payments.check-new');
    
    // ============ PINCODE / STATE MANAGEMENT ROUTES ============
    Route::resource('pincodes', DeliverablePincodeController::class);
    Route::post('pincodes/bulk-import', [DeliverablePincodeController::class, 'bulkImport'])->name('pincodes.bulk');
    Route::post('pincodes/bulk-update-shipping', [DeliverablePincodeController::class, 'bulkUpdateShipping'])->name('pincodes.bulk-update-shipping');
    Route::post('pincodes/bulk-delete', [DeliverablePincodeController::class, 'bulkDelete'])->name('pincodes.bulk-delete');
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
Route::get('/api/products/subcategory/{id}', [ProductApiController::class, 'getProductsBySubCategory']);
Route::get('/api/products/stocks', [ProductApiController::class, 'getProductStocks']);
Route::get('/api/banners', [BannerApiController::class, 'getBanners']);

// ============ SUB CATEGORIES API ============
Route::get('/api/subcategories/{categoryId}', function($categoryId) {
    $subCategories = SubCategory::where('category_id', $categoryId)
        ->where('is_active', 1)
        ->withCount('products')
        ->get();
    return response()->json($subCategories);
})->name('api.subcategories');

// ============ CART SESSION ROUTE ============
Route::post('/api/set-checkout-cart', function (Request $request) {
    session(['checkout_cart' => $request->cart]);
    return response()->json(['success' => true]);
})->middleware('auth');

// ============ PINCODE CHECK API ============
Route::get('/api/check-pincode/{pincode}', function ($pincode) {
    $isDeliverable = \App\Models\DeliverablePincode::isDeliverable($pincode);
    $deliveryInfo = \App\Models\DeliverablePincode::getDeliveryInfo($pincode);
    
    return response()->json([
        'success' => true,
        'deliverable' => $isDeliverable,
        'delivery_days' => $deliveryInfo ? $deliveryInfo->delivery_days : null,
        'city' => $deliveryInfo ? $deliveryInfo->city : null,
        'state' => $deliveryInfo ? $deliveryInfo->state : null,
        'message' => $isDeliverable ? 'Delivery available' : 'Delivery not available for this pincode'
    ]);
})->name('check.pincode');

// ============ USER API ============
Route::get('/api/user', function () {
    if (auth()->check()) {
        $user = auth()->user();
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? ''
            ]
        ]);
    }
    return response()->json(['success' => false, 'message' => 'Not logged in']);
})->name('api.user');

// ============ USER ADDRESSES API ==========
Route::get('/api/user-addresses', function () {
    if (auth()->check()) {
        $addresses = UserAddress::where('user_id', auth()->id())
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json([
            'success' => true,
            'addresses' => $addresses
        ]);
    }
    return response()->json(['success' => false, 'addresses' => []]);
})->name('api.user.addresses');

Route::post('/api/user-addresses', function (Illuminate\Http\Request $request) {
    try {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'User not logged in']);
        }
        
        \Log::info('Saving address', $request->all());
        
        $address = UserAddress::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'email' => $request->email ?? auth()->user()->email,
            'address' => $request->address,
            'area' => $request->area,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'phone' => $request->phone,
            'is_default' => $request->is_default ?? false
        ]);
        
        return response()->json(['success' => true, 'address' => $address]);
    } catch (\Exception $e) {
        \Log::error('Address save error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
})->name('api.user.addresses.store');

Route::delete('/api/user-addresses/{id}', function ($id) {
    if (auth()->check()) {
        $address = UserAddress::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();
        if ($address) {
            $address->delete();
            return response()->json(['success' => true]);
        }
    }
    return response()->json(['success' => false]);
})->name('api.user.addresses.delete');

// ============ DELIVERABLE PINCODES API ==========
Route::get('/api/deliverable-pincodes', function () {
    $pincodes = \App\Models\DeliverablePincode::where('is_active', 1)
        ->select('pincode', 'city', 'state', 'delivery_days', 'is_active')
        ->get();
    return response()->json([
        'success' => true,
        'pincodes' => $pincodes
    ]);
})->name('deliverable.pincodes');

// ============ ORDER DETAILS API (FOR MY ORDERS MODAL) ==========
Route::get('/api/order-details/{id}', function ($id) {
    if (!auth()->check()) {
        return response()->json(['success' => false, 'message' => 'Not logged in']);
    }
    
    try {
        // Get order with user and items
        $order = Order::with(['user', 'items'])
            ->where('user_id', auth()->id())
            ->find($id);
        
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found']);
        }
        
        // Get shipping address from user_addresses table
        $shippingAddress = null;
        
        // Try to get address from payment_details first
        if ($order->payment_details) {
            try {
                $paymentDetails = is_string($order->payment_details) ? json_decode($order->payment_details, true) : $order->payment_details;
                if (isset($paymentDetails['shipping_address']) && !empty($paymentDetails['shipping_address'])) {
                    $shippingAddress = $paymentDetails['shipping_address'];
                } elseif (isset($paymentDetails['address']) && !empty($paymentDetails['address'])) {
                    $shippingAddress = $paymentDetails['address'];
                }
            } catch (\Exception $e) {}
        }
        
        // If no address in payment_details, get the default address from user_addresses table
        if (!$shippingAddress || empty($shippingAddress['address'])) {
            $userAddress = UserAddress::where('user_id', auth()->id())
                ->orderBy('is_default', 'desc')
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($userAddress) {
                $shippingAddress = [
                    'name' => $userAddress->name,
                    'address' => $userAddress->address,
                    'area' => $userAddress->area ?? '',
                    'city' => $userAddress->city,
                    'state' => $userAddress->state,
                    'pincode' => $userAddress->pincode,
                    'phone' => $userAddress->phone
                ];
            }
        }
        
        // Calculate subtotal and format items
        $subtotal = 0;
        $items = [];
        foreach ($order->items as $item) {
            $itemTotal = $item->price * $item->quantity;
            $subtotal += $itemTotal;
            
            // Get product image separately if needed
            $productImage = null;
            if ($item->product_id) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $productImage = $product->image;
                }
            }
            
            $items[] = [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product_name,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'product_image' => $productImage
            ];
        }
        
        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'total_amount' => $order->total_amount,
                'payment_status' => $order->payment_status,
                'order_status' => $order->order_status,
                'payment_method' => $order->payment_method,
                'transaction_id' => $order->transaction_id,
                'payment_id' => $order->payment_id,
                'payment_details' => $order->payment_details,
                'created_at' => $order->created_at,
                'user' => $order->user ? [
                    'name' => $order->user->name,
                    'email' => $order->user->email,
                    'phone' => $order->user->phone ?? 'N/A'
                ] : null,
                'items' => $items,
                'shipping_address' => $shippingAddress,
                'subtotal' => $subtotal,
                'shipping_cost' => 0
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
})->name('api.order.details')->middleware('auth');

// ============ CANCEL ORDER ROUTE ============
Route::post('/cancel-order', [PaymentController::class, 'cancelOrder'])->name('cancel.order')->middleware('auth');