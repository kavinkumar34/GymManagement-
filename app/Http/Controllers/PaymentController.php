<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\UserAddress;
use App\Models\Coupon;
use App\Models\OrderCancellation;
use App\Models\ReturnExchange;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
  

    /**
     * Handle guest user registration and auto-login
     */
    private function handleGuestUser($request)
    {
        // If user is already logged in, return the user
        if (Auth::check()) {
            return Auth::user();
        }
        
        $guestName = $request->input('guest_name');
        $guestPhone = $request->input('guest_phone');
        $guestEmail = $request->input('guest_email');
        
        // If no guest data, return null
        if (!$guestName || !$guestPhone || !$guestEmail) {
            return null;
        }
        
        // Check if user already exists with this email or phone
        $existingUser = \App\Models\User::where('email', $guestEmail)
            ->orWhere('phone', $guestPhone)
            ->first();
        
        if ($existingUser) {
            // Login existing user
            Auth::login($existingUser);
            Log::info('Guest user logged in: ' . $guestEmail);
            return $existingUser;
        }
        
        // Create new user (password = phone number)
        $user = \App\Models\User::create([
            'name' => $guestName,
            'email' => $guestEmail,
            'phone' => $guestPhone,
            'password' => bcrypt($guestPhone),
            'is_verified' => 1,
            'otp' => null,
            'otp_expires_at' => null
        ]);
        
        // Login the new user
        Auth::login($user);
        Log::info('New guest user registered: ' . $guestEmail);
        
        return $user;
    }

    public function buyNow(Request $request)
    {
        // ===== HANDLE GUEST USER AUTO-REGISTRATION =====
        $user = $this->handleGuestUser($request);
        
        // If still no user, redirect to login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login or provide contact details to place order');
        }
        
        // ===== UPDATE USER PHONE IF NOT SET =====
        if (empty($user->phone) && $request->guest_phone) {
            $user->phone = $request->guest_phone;
            $user->save();
        }
        
        $checkoutCart = session()->get('checkout_cart');
        
        if ($checkoutCart && count($checkoutCart) > 0) {
            return $this->processCartCheckout($request, $user, $checkoutCart);
        } else {
            return $this->processSingleProduct($request, $user);
        }
    }
    
    private function processSingleProduct($request, $user)
    {
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;
        $variantId = $request->variant_id ?? null;
        $size = $request->size ?? null;
        $color = $request->color ?? null;
        
        // Get shipping charge from request
        $shippingCharge = $request->input('shipping_charge', 0);
        
        // ===== CHECK IF THIS IS A VARIANT PRODUCT =====
        if ($variantId) {
            // ===== VARIANT PRODUCT - CHECK VARIANT STOCK =====
            $variant = \App\Models\ProductVariant::find($variantId);
            
            if (!$variant) {
                return redirect()->back()->with('error', 'Variant not found');
            }
            
            if ($variant->stock < $quantity) {
                return redirect()->back()->with('error', "Only {$variant->stock} items available for {$product->name} ({$size} - {$color})");
            }
            
            // Get price from variant
            $amount = $variant->final_price ?? $variant->price ?? 0;
            $finalPrice = $variant->final_price ?? $variant->price ?? 0;
            $totalAmount = number_format($amount * $quantity, 2, '.', '');
            
        } else {
            // ===== NORMAL PRODUCT - CHECK PRODUCT STOCK =====
            if ($product->stock < $quantity) {
                return redirect()->back()->with('error', "Only {$product->stock} items available for {$product->name}");
            }
            
            $amount = $product->final_price ?? $product->price ?? 0;
            $finalPrice = $product->final_price ?? $product->price ?? 0;
            $totalAmount = number_format($amount * $quantity, 2, '.', '');
        }
        
        $txnid = 'TXN' . time() . rand(1000, 9999);
        $productInfo = substr(preg_replace('/[^A-Za-z0-9 ]/', '', $product->name), 0, 100);
        
        $order = $this->createOrder($txnid, $user->id, $totalAmount, $shippingCharge, $request);
        
        // Get product image
        $productImage = $product->image ?? null;
        
        // ===== CREATE ORDER ITEM WITH VARIANT DETAILS =====
        if ($variantId && isset($variant)) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'variant_id' => $variantId,
                'size' => $size,
                'color' => $color,
                'product_name' => $product->name . ' (' . $size . ' - ' . $color . ')',
                'quantity' => $quantity,
                'price' => $amount,
                'final_price' => $finalPrice,
                'product_image' => $productImage
            ]);
            
            // ===== DEDUCT VARIANT STOCK =====
            $variant->decrement('stock', $quantity);
            
        } else {
            // Normal product
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'variant_id' => null,
                'size' => null,
                'color' => null,
                'product_name' => $product->name,
                'quantity' => $quantity,
                'price' => $amount,
                'final_price' => $finalPrice,
                'product_image' => $productImage
            ]);
            
            // ===== DEDUCT PRODUCT STOCK =====
            $product->decrement('stock', $quantity);
        }
        
        // ===== SAVE GUEST ADDRESS TO DATABASE =====
        $addressData = $request->input('address');
        if ($addressData) {
            if (is_string($addressData)) {
                $addressData = json_decode($addressData, true);
            }
            if (is_array($addressData) && !empty($addressData['address'])) {
                $this->saveGuestAddress($user, $addressData);
            }
        }
        
        // Also check for guest address fields directly from request
        if ($request->guest_address && $request->guest_city && $request->guest_state) {
            $guestAddressData = [
                'name' => $request->guest_name ?? $user->name,
                'email' => $request->guest_email ?? $user->email,
                'address' => $request->guest_address,
                'city' => $request->guest_city,
                'state' => $request->guest_state,
                'pincode' => $request->guest_pincode,
                'phone' => $request->guest_address_phone ?? $request->guest_phone ?? $user->phone
            ];
            $this->saveGuestAddress($user, $guestAddressData);
        }
        
return $this->createRazorpayOrder(
    $user,
    $txnid,
    $totalAmount,
    $productInfo,
    $order->id
);    }
    
    private function processCartCheckout($request, $user, $checkoutCart)
    {
        // ===== HANDLE GUEST USER AUTO-REGISTRATION (if user is null) =====
        if (!$user) {
            $user = $this->handleGuestUser($request);
        }
        
        // If still no user, redirect to login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login or provide contact details to place order');
        }
        
        // ===== UPDATE USER PHONE IF NOT SET =====
        if (empty($user->phone) && $request->guest_phone) {
            $user->phone = $request->guest_phone;
            $user->save();
        }
        
        // Get total amount from request or calculate
        $totalAmount = $request->input('total_amount');
        if (!$totalAmount) {
            $totalAmount = 0;
            foreach ($checkoutCart as $item) {
                $product = Product::find($item['id']);
                if ($product) {
                    $amount = $product->final_price ?? $product->price ?? 0;
                    $totalAmount += $amount * $item['quantity'];
                }
            }
        }
        $totalAmount = (float) $totalAmount;
        
        // Get shipping charge from request
        $shippingCharge = $request->input('shipping_charge', 0);
        
        $productItems = [];
        $productInfo = '';
        
        foreach ($checkoutCart as $item) {
            $product = Product::find($item['id']);
            if (!$product) continue;
            
            $variantId = $item['variant_id'] ?? null;
            $size = $item['size'] ?? null;
            $color = $item['color'] ?? null;
            
            // ===== CHECK STOCK BASED ON VARIANT =====
            if ($variantId) {
                $variant = \App\Models\ProductVariant::find($variantId);
                if (!$variant) {
                    return redirect()->route('cart')->with('error', "Variant not found for {$product->name}");
                }
                if ($item['quantity'] > $variant->stock) {
                    return redirect()->route('cart')->with('error', "Only {$variant->stock} items available for {$product->name} ({$size} - {$color})");
                }
                $amount = $variant->final_price ?? $variant->price ?? 0;
                $finalPrice = $variant->final_price ?? $variant->price ?? 0;
            } else {
                if ($item['quantity'] > $product->stock) {
                    return redirect()->route('cart')->with('error', "Only {$product->stock} items available for {$product->name}");
                }
                $amount = $product->final_price ?? $product->price ?? 0;
                $finalPrice = $product->final_price ?? $product->price ?? 0;
            }
            
            $productItems[] = [
                'product' => $product,
                'variant_id' => $variantId,
                'size' => $size,
                'color' => $color,
                'quantity' => $item['quantity'],
                'price' => $amount,
                'final_price' => $finalPrice
            ];
            $productInfo .= $product->name . ' x' . $item['quantity'] . ', ';
        }
        
        $productInfo = substr(rtrim($productInfo, ', '), 0, 100);
        $txnid = 'TXN' . time() . rand(1000, 9999);
        
        $order = $this->createOrder($txnid, $user->id, $totalAmount, $shippingCharge, $request);
        
        foreach ($productItems as $item) {
            $productImage = \App\Models\ProductImage::where('product_id', $item['product']->id)
                ->where(function($q) use ($item){
                    if(!empty($item['variant_id'])){
                        $q->where('variant_id', $item['variant_id']);
                    }else{
                        $q->whereNull('variant_id');
                    }
                })
                ->orderByDesc('is_main')
                ->orderBy('display_order')
                ->value('image_path');

            if(!$productImage){
                $productImage = \App\Models\ProductImage::where('product_id', $item['product']->id)
                    ->orderByDesc('is_main')
                    ->orderBy('display_order')
                    ->value('image_path');
            }
            
            // ===== CREATE ORDER ITEM WITH VARIANT DETAILS =====
            if ($item['variant_id']) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'variant_id' => $item['variant_id'],
                    'size' => $item['size'],
                    'color' => $item['color'],
                    'product_name' => $item['product']->name . ' (' . $item['size'] . ' - ' . $item['color'] . ')',
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'final_price' => $item['final_price'],
                    'product_image' => $productImage
                ]);
                
                // ===== DEDUCT VARIANT STOCK =====
                $variant = \App\Models\ProductVariant::find($item['variant_id']);
                if ($variant) {
                    $variant->decrement('stock', $item['quantity']);
                }
            } else {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'variant_id' => null,
                    'size' => null,
                    'color' => null,
                    'product_name' => $item['product']->name,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'final_price' => $item['final_price'],
                    'product_image' => $productImage
                ]);
                
                // ===== DEDUCT PRODUCT STOCK =====
                $item['product']->decrement('stock', $item['quantity']);
            }
        }
        
        // ===== RECORD COUPON USAGE =====
        $couponCode = $request->input('coupon_code');
        $couponDiscount = $request->input('coupon_discount') ?? 0;
        
        if ($couponCode && $couponDiscount > 0) {
            $this->recordCouponUsage($order, $couponCode, $couponDiscount);
        }
        
        session()->forget('checkout_cart');
        
        // ===== SAVE GUEST ADDRESS TO DATABASE =====
        $addressData = $request->input('address');
        if ($addressData) {
            if (is_string($addressData)) {
                $addressData = json_decode($addressData, true);
            }
            if (is_array($addressData) && !empty($addressData['address'])) {
                $this->saveGuestAddress($user, $addressData);
            }
        }
        
        // Also check for guest address fields directly from request
        if ($request->guest_address && $request->guest_city && $request->guest_state) {
            $guestAddressData = [
                'name' => $request->guest_name ?? $user->name,
                'email' => $request->guest_email ?? $user->email,
                'address' => $request->guest_address,
                'city' => $request->guest_city,
                'state' => $request->guest_state,
                'pincode' => $request->guest_pincode,
                'phone' => $request->guest_address_phone ?? $request->guest_phone ?? $user->phone
            ];
            $this->saveGuestAddress($user, $guestAddressData);
        }
        
return $this->createRazorpayOrder(
    $user,
    $txnid,
    $totalAmount,
    $productInfo,
    $order->id
);    }
    
    private function createOrder(
        $txnid,
        $userId,
        $totalAmount,
        $shippingCharge = 0,
        $request = null
    ) {
        $paymentDetails = [];

        if ($request) {
            // Guest data
            if ($request->guest_name) {
                $paymentDetails['guest_name'] = $request->guest_name;
            }
            if ($request->guest_phone) {
                $paymentDetails['guest_phone'] = $request->guest_phone;
            }
            if ($request->guest_email) {
                $paymentDetails['guest_email'] = $request->guest_email;
            }

            // Shipping state
            if ($request->shipping_state) {
                $shippingState = $request->shipping_state;
                if (is_string($shippingState)) {
                    $shippingState = json_decode($shippingState, true);
                }
                $paymentDetails['shipping_state'] = $shippingState;
            }

            // =========================================================
            // ★★★ GET THE EXACT SELECTED ADDRESS ★★★
            // =========================================================
            $selectedAddress = null;
            $selectedAddressId = null;

            // 1. ★★★ FIRST TRY: Get from 'address' field ★★★
            $addressInput = $request->input('address');
            if ($addressInput) {
                if (is_string($addressInput)) {
                    $decoded = json_decode($addressInput, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $selectedAddress = $decoded;
                        if (!empty($selectedAddress['id'])) {
                            $selectedAddressId = $selectedAddress['id'];
                        }
                    }
                } elseif (is_array($addressInput)) {
                    $selectedAddress = $addressInput;
                    if (!empty($selectedAddress['id'])) {
                        $selectedAddressId = $selectedAddress['id'];
                    }
                }
            }

            // 2. ★★★ SECOND TRY: Get from shipping_address_id ★★★
            if (!$selectedAddressId) {
                $selectedAddressId = $request->input('shipping_address_id');
            }

            // 3. ★★★ THIRD TRY: Get from address_id ★★★
            if (!$selectedAddressId) {
                $selectedAddressId = $request->input('address_id');
            }

            // 4. ★★★ FOURTH TRY: Get from selected_address_id ★★★
            if (!$selectedAddressId) {
                $selectedAddressId = $request->input('selected_address_id');
            }

            // 5. ★★★ FIFTH TRY: Get from order_data ★★★
            if (!$selectedAddress || empty($selectedAddress['address'])) {
                $orderData = $request->input('order_data');
                if ($orderData) {
                    if (is_string($orderData)) {
                        $orderData = json_decode($orderData, true);
                    }
                    if (is_array($orderData) && !empty($orderData['address'])) {
                        $selectedAddress = $orderData['address'];
                        if (!empty($selectedAddress['id'])) {
                            $selectedAddressId = $selectedAddress['id'];
                        }
                    }
                }
            }

            // =========================================================
            // ★★★ DEBUG: LOG WHAT WE FOUND ★★★
            // =========================================================
            \Log::info('🔍 Address lookup result:', [
                'order' => $txnid,
                'selectedAddressId' => $selectedAddressId,
                'selectedAddress' => $selectedAddress,
                'address_from_request' => $request->input('address'),
                'shipping_address_id_from_request' => $request->input('shipping_address_id'),
            ]);

            // =========================================================
            // ★★★ GET FRESH ADDRESS FROM DATABASE ★★★
            // =========================================================
            if ($selectedAddressId && Auth::check()) {
                $dbAddress = UserAddress::where('id', $selectedAddressId)
                    ->where('user_id', $userId)
                    ->first();

                if ($dbAddress) {
                    $selectedAddress = [
                        'id' => $dbAddress->id,
                        'user_id' => $dbAddress->user_id,
                        'name' => $dbAddress->name,
                        'email' => $dbAddress->email,
                        'address' => $dbAddress->address,
                        'area' => $dbAddress->area ?? '',
                        'city' => $dbAddress->city,
                        'state' => $dbAddress->state,
                        'pincode' => $dbAddress->pincode,
                        'phone' => $dbAddress->phone,
                    ];
                    \Log::info('✅ Found address in DB for ID: ' . $selectedAddressId);
                } else {
                    \Log::warning('⚠️ Address not found in DB for ID: ' . $selectedAddressId);
                    $selectedAddress = null;
                }
            }

            // =========================================================
            // ★★★ SAVE THE EXACT ADDRESS TO payment_details ★★★
            // =========================================================
            if (is_array($selectedAddress) && !empty($selectedAddress['address'])) {
                // Make sure all required fields exist
                if (!isset($selectedAddress['name']) || empty($selectedAddress['name'])) {
                    $selectedAddress['name'] = Auth::check() ? Auth::user()->name : ($request->guest_name ?? 'Guest');
                }
                if (!isset($selectedAddress['phone']) || empty($selectedAddress['phone'])) {
                    $selectedAddress['phone'] = Auth::check() ? (Auth::user()->phone ?? '') : ($request->guest_phone ?? '');
                }
                if (!isset($selectedAddress['email']) || empty($selectedAddress['email'])) {
                    $selectedAddress['email'] = Auth::check() ? Auth::user()->email : ($request->guest_email ?? '');
                }

                // SAVE THE EXACT ADDRESS USED FOR THIS ORDER
                $paymentDetails['shipping_address'] = $selectedAddress;

                if (!empty($selectedAddress['id'])) {
                    $paymentDetails['shipping_address_id'] = $selectedAddress['id'];
                }

                \Log::info('✅ Order address saved:', [
                    'order' => $txnid,
                    'address_id' => $selectedAddress['id'] ?? 'N/A',
                    'address' => $selectedAddress['address'],
                    'city' => $selectedAddress['city'] ?? '',
                    'state' => $selectedAddress['state'] ?? ''
                ]);
            } else {
                // ===== FALLBACK: If NO address found, use user's default address =====
                \Log::warning('⚠️ No valid address found, using default for order: ' . $txnid);
                
                if (Auth::check()) {
                    $defaultAddress = UserAddress::where('user_id', $userId)
                        ->where('is_default', 1)
                        ->first();

                    if (!$defaultAddress) {
                        $defaultAddress = UserAddress::where('user_id', $userId)
                            ->orderBy('created_at', 'desc')
                            ->first();
                    }

                    if ($defaultAddress) {
                        $paymentDetails['shipping_address'] = [
                            'id' => $defaultAddress->id,
                            'user_id' => $defaultAddress->user_id,
                            'name' => $defaultAddress->name,
                            'email' => $defaultAddress->email,
                            'address' => $defaultAddress->address,
                            'area' => $defaultAddress->area ?? '',
                            'city' => $defaultAddress->city,
                            'state' => $defaultAddress->state,
                            'pincode' => $defaultAddress->pincode,
                            'phone' => $defaultAddress->phone,
                        ];
                        $paymentDetails['shipping_address_id'] = $defaultAddress->id;
                    }
                }
            }
        }

        return Order::create([
            'order_number' => $txnid,
            'user_id' => $userId,
            'total_amount' => $totalAmount,
            'shipping_charge' => $shippingCharge,
            'payment_status' => 'PENDING',
            'order_status' => 'Pending',
            'refund_status' => 'none',
            'refund_amount' => 0,
'payment_method' => 'Razorpay',
            'transaction_id' => $txnid,
            'order_date' => now(),
            'payment_details' => !empty($paymentDetails) ? json_encode($paymentDetails) : null
        ]);
    }
    
private function createRazorpayOrder($user, $txnid, $totalAmount, $productInfo, $orderId)
{

    try {
        $api = new Api(
            config('services.razorpay.key_id'),
            config('services.razorpay.key_secret')
        );

        // Razorpay amount must be in paisephp artisan optimize:clear
        $amountInPaise = (int) round($totalAmount * 100);

        $razorpayOrder = $api->order->create([
            'receipt' => $txnid,
            'amount' => $amountInPaise,
            'currency' => 'INR',
        ]);

        session([
            'pending_order_id' => $orderId,
            'pending_user_id' => $user->id,
        ]);

        return view('payment.razorpay-form', [
            'razorpayKey' => config('services.razorpay.key_id'),
            'razorpayOrderId' => $razorpayOrder['id'],
            'amount' => $amountInPaise,
            'currency' => 'INR',
            'orderId' => $orderId,
            'txnid' => $txnid,
            'productInfo' => $productInfo,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? '',
        ]);

    } catch (\Exception $e) {
        Log::error('Razorpay order creation failed', [
            'order_id' => $orderId,
            'txnid' => $txnid,
            'error' => $e->getMessage(),
        ]);

        return redirect()->route('cart')
            ->with('error', 'Unable to initialize Razorpay payment. Please try again.');
    }
}

    public function paymentSuccess(Request $request)
    {
        Log::info('PayU Success Callback', $request->all());

        $txnid = $request->input('txnid');
        $status = $request->input('status');
        $mihpayid = $request->input('mihpayid');
        
        if (!$txnid) {
            Log::error('No transaction ID in callback');
            return redirect()->route('home')->with('error', 'Invalid payment response');
        }
        
        $order = Order::where('order_number', $txnid)->first();

        if (!$order) {
            Log::error('Order not found for txnid: ' . $txnid);
            return redirect()->route('home')->with('error', 'Order not found');
        }

        if ($order->payment_status == 'SUCCESS') {
            return redirect()->route('order.success', $order->id)->with('success', 'Payment already confirmed!');
        }

        if (!Auth::check() && $order->user_id) {
            Auth::loginUsingId($order->user_id);
        }

        if ($status == 'success' || $mihpayid) {

            // ★★★ Get existing payment details ★★★
            $existingPaymentDetails = [];

            if (!empty($order->payment_details)) {
                $existingPaymentDetails = is_string($order->payment_details)
                    ? json_decode($order->payment_details, true)
                    : $order->payment_details;

                if (!is_array($existingPaymentDetails)) {
                    $existingPaymentDetails = [];
                }
            }

            // ★★★ CRITICAL: Save the shipping_address before it gets overwritten ★★★
            $shippingAddress = null;
            $shippingAddressId = null;
            
            if (isset($existingPaymentDetails['shipping_address']) && !empty($existingPaymentDetails['shipping_address'])) {
                $shippingAddress = $existingPaymentDetails['shipping_address'];
                $shippingAddressId = $existingPaymentDetails['shipping_address_id'] ?? null;
                
                Log::info('✅ Preserving shipping address for order: ' . $txnid, [
                    'shipping_address_id' => $shippingAddressId,
                    'shipping_address' => $shippingAddress
                ]);
            }

            // ★★★ Add PayU response details ★★★
            $existingPaymentDetails['payu_response'] = $request->all();

            // ★★★ CRITICAL: Restore shipping_address if it was present ★★★
            if ($shippingAddress) {
                $existingPaymentDetails['shipping_address'] = $shippingAddress;
                if ($shippingAddressId) {
                    $existingPaymentDetails['shipping_address_id'] = $shippingAddressId;
                }
            }

            $order->update([
                'payment_status' => 'SUCCESS',
                'order_status' => 'Confirmed',
                'payment_id' => $mihpayid,
                'payment_details' => json_encode($existingPaymentDetails)
            ]);

            Log::info('✅ Payment successful - Address preserved for order: ' . $txnid, [
                'shipping_address_id' => $existingPaymentDetails['shipping_address_id'] ?? null
            ]);

            session()->forget('pending_order_id');
            session()->forget('checkout_cart');
            
            $this->sendOrderConfirmationEmail($order);
            
            return redirect()->route('order.success', ['id' => $order->id, 'clear_cart' => 1])->with('success', 'Payment successful!');
        } else {
            // ===== RESTORE STOCK ON PAYMENT FAILURE =====
            foreach ($order->items as $item) {
                if ($item->variant_id) {
                    $variant = \App\Models\ProductVariant::find($item->variant_id);
                    if ($variant) {
                        $variant->increment('stock', $item->quantity);
                    }
                } else {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->increment('stock', $item->quantity);
                    }
                }
            }
            
            $order->update([
                'payment_status' => 'FAILED',
                'order_status' => 'Failed'
            ]);
            
            Log::warning('Payment failed for order: ' . $txnid);
            return redirect()->route('cart')->with('error', 'Payment failed. Please try again.');
        }
    }

    public function paymentFailure(Request $request)
    {
        Log::error('PayU Failure Callback', $request->all());

        $txnid = $request->input('txnid');
        
        $order = Order::where('order_number', $txnid)->first();

        if ($order) {
            if (!Auth::check() && $order->user_id) {
                Auth::loginUsingId($order->user_id);
            }
            
            // ===== RESTORE STOCK ON PAYMENT FAILURE (BOTH PRODUCT AND VARIANT) =====
            foreach ($order->items as $item) {
                if ($item->variant_id) {
                    // ===== RESTORE VARIANT STOCK =====
                    $variant = \App\Models\ProductVariant::find($item->variant_id);
                    if ($variant) {
                        $variant->increment('stock', $item->quantity);
                    }
                } else {
                    // ===== RESTORE PRODUCT STOCK =====
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->increment('stock', $item->quantity);
                    }
                }
            }
            
            $order->update([
                'payment_status' => 'FAILED',
                'order_status' => 'Failed'
            ]);
        }

        return redirect()->route('cart')->with('error', 'Payment failed or was cancelled. Please try again.');
    }

    public function orderSuccess($id)
    {
        $order = Order::with('items')->findOrFail($id);
        
        // Auto-login if user is not logged in but order belongs to a user
        if (!Auth::check() && $order->user_id) {
            Auth::loginUsingId($order->user_id);
        }
        
        // Check if logged-in user owns this order
        if (Auth::check() && $order->user_id != Auth::id()) {
            abort(403);
        }

        $clearCart = request()->has('clear_cart');
        
        return view('payment.order-success', compact('order', 'clearCart'));
    }
    
    public function myOrders(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view orders');
        }
        
        $query = Order::with('items')->where('user_id', Auth::id());
        
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'LIKE', "%{$search}%")
                  ->orWhereHas('items', function($itemQuery) use ($search) {
                      $itemQuery->where('product_name', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        if ($request->status) {
            $query->where('order_status', $request->status);
        }
        
        if ($request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }
        
        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        
        $orders = $query->orderBy('id', 'desc')->paginate(10);
        $orders->appends($request->all());
        
        return view('payment.my-orders', compact('orders'));
    }
    
    public function placeCodOrder(Request $request)
    {
        // ===== HANDLE GUEST USER AUTO-REGISTRATION =====
        $user = $this->handleGuestUser($request);
        
        // If still no user, redirect to login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login or provide contact details to place order');
        }
        
        // ===== UPDATE USER PHONE IF NOT SET =====
        if (empty($user->phone) && $request->guest_phone) {
            $user->phone = $request->guest_phone;
            $user->save();
        }
        
        $cart = session()->get('checkout_cart');
        
        if (!$cart || count($cart) == 0) {
            return redirect()->route('cart')->with('error', 'Your cart is empty');
        }
        
        // Get total amount from request
        $totalAmount = $request->input('total_amount');
        if (!$totalAmount) {
            $totalAmount = 0;
            foreach ($cart as $item) {
                $product = Product::find($item['id']);
                if ($product) {
                    $amount = $product->final_price ?? $product->price ?? 0;
                    $totalAmount += $amount * $item['quantity'];
                }
            }
        }
        $totalAmount = (float) $totalAmount;
        
        // Get shipping charge from request
        $shippingCharge = $request->input('shipping_charge', 0);
        
        $productItems = [];
        
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if (!$product) continue;
            
            $variantId = $item['variant_id'] ?? null;
            $size = $item['size'] ?? null;
            $color = $item['color'] ?? null;
            
            // ===== CHECK STOCK BASED ON VARIANT =====
            if ($variantId) {
                $variant = \App\Models\ProductVariant::find($variantId);
                if (!$variant) {
                    return redirect()->route('cart')->with('error', "Variant not found for {$product->name}");
                }
                if ($item['quantity'] > $variant->stock) {
                    return redirect()->route('cart')->with('error', "Only {$variant->stock} items available for {$product->name} ({$size} - {$color})");
                }
                $amount = $variant->final_price ?? $variant->price ?? 0;
                $finalPrice = $variant->final_price ?? $variant->price ?? 0;
            } else {
                if ($item['quantity'] > $product->stock) {
                    return redirect()->route('cart')->with('error', "Only {$product->stock} items available for {$product->name}");
                }
                $amount = $product->final_price ?? $product->price ?? 0;
                $finalPrice = $product->final_price ?? $product->price ?? 0;
            }
            
            $productItems[] = [
                'product' => $product,
                'variant_id' => $variantId,
                'size' => $size,
                'color' => $color,
                'quantity' => $item['quantity'],
                'price' => $amount,
                'final_price' => $finalPrice
            ];
        }
        
        $txnid = 'COD' . time() . rand(1000, 9999);
        
        // Get address from request
        $address = $request->input('address');
        if (is_string($address)) {
            $address = json_decode($address, true);
        }
        
        // Build payment details with guest data
        $paymentDetailsData = [
            'shipping_address' => $address,
            'payment_method' => 'COD',
            'total_amount' => $totalAmount,
            'subtotal' => $request->input('subtotal'),
            'shipping_charge' => $shippingCharge,
            'coupon_discount' => $request->input('coupon_discount'),
            'coupon_code' => $request->input('coupon_code')
        ];
        
        // Add guest data if present
        if ($request->guest_name) {
            $paymentDetailsData['guest_name'] = $request->guest_name;
        }
        if ($request->guest_phone) {
            $paymentDetailsData['guest_phone'] = $request->guest_phone;
        }
        if ($request->guest_email) {
            $paymentDetailsData['guest_email'] = $request->guest_email;
        }
        
        $order = Order::create([
            'order_number' => $txnid,
            'user_id' => $user->id,
            'total_amount' => $totalAmount,
            'shipping_charge' => $shippingCharge,
            'payment_status' => 'PENDING',
            'order_status' => 'Pending',
            'refund_status' => 'none',
            'refund_amount' => 0,
            'payment_method' => 'COD',
            'transaction_id' => $txnid,
            'order_date' => now(),
            'payment_details' => json_encode($paymentDetailsData)
        ]);

        // ===== SAVE GUEST ADDRESS TO DATABASE =====
        if ($address && is_array($address)) {
            $this->saveGuestAddress($user, $address);
        }
        
        foreach ($productItems as $item) {
            $productImage = \App\Models\ProductImage::where('product_id', $item['product']->id)
                ->where(function($q) use ($item){
                    if(!empty($item['variant_id'])){
                        $q->where('variant_id', $item['variant_id']);
                    }else{
                        $q->whereNull('variant_id');
                    }
                })
                ->orderByDesc('is_main')
                ->orderBy('display_order')
                ->value('image_path');

            if(!$productImage){
                $productImage = \App\Models\ProductImage::where('product_id', $item['product']->id)
                    ->orderByDesc('is_main')
                    ->orderBy('display_order')
                    ->value('image_path');
            }
            
            // ===== CREATE ORDER ITEM WITH VARIANT DETAILS =====
            if ($item['variant_id']) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'variant_id' => $item['variant_id'],
                    'size' => $item['size'],
                    'color' => $item['color'],
                    'product_name' => $item['product']->name . ' (' . $item['size'] . ' - ' . $item['color'] . ')',
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'final_price' => $item['final_price'],
                    'product_image' => $productImage
                ]);
                
                // ===== DEDUCT VARIANT STOCK =====
                $variant = \App\Models\ProductVariant::find($item['variant_id']);
                if ($variant) {
                    $variant->decrement('stock', $item['quantity']);
                }
            } else {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'variant_id' => null,
                    'size' => null,
                    'color' => null,
                    'product_name' => $item['product']->name,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'final_price' => $item['final_price'],
                    'product_image' => $productImage
                ]);
                
                // ===== DEDUCT PRODUCT STOCK =====
                $item['product']->decrement('stock', $item['quantity']);
            }
        }
        
        // ===== RECORD COUPON USAGE FOR COD =====
        $couponCode = $request->input('coupon_code');
        $couponDiscount = $request->input('coupon_discount') ?? 0;
        
        if ($couponCode && $couponDiscount > 0) {
            $this->recordCouponUsage($order, $couponCode, $couponDiscount);
        }
        
        session()->forget('checkout_cart');
        
        $this->sendOrderConfirmationEmail($order);
        
        return redirect()->route('order.success', $order->id);
    }
    
    /**
     * Record coupon usage after successful order
     */
    private function recordCouponUsage($order, $couponCode, $couponDiscount)
    {
        if (!$couponCode || !$couponDiscount) {
            return;
        }
        
        try {
            $coupon = Coupon::where('code', $couponCode)->first();
            if (!$coupon) {
                return;
            }
            
            // Check if already recorded
            $exists = \DB::table('coupon_usage')
                ->where('coupon_id', $coupon->id)
                ->where('order_id', $order->id)
                ->exists();
            
            if (!$exists) {
                \DB::table('coupon_usage')->insert([
                    'coupon_id' => $coupon->id,
                    'user_id' => $order->user_id,
                    'order_id' => $order->id,
                    'discount_amount' => $couponDiscount,
                    'used_at' => now()
                ]);
                
                // Increment used count in coupons table
                $coupon->increment('used_count');
                
                Log::info('✅ Coupon usage recorded for order: ' . $order->order_number . ', Coupon: ' . $couponCode);
            }
        } catch (\Exception $e) {
            Log::error('❌ Failed to record coupon usage: ' . $e->getMessage());
        }
    }
    
    /**
     * Cancel Order with Refund Status
     */
    public function cancelOrder(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Please login to cancel order']);
        }
        
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'cancellation_reason' => 'required|string|max:100',
            'cancellation_comment' => 'nullable|string'
        ]);
        
        $order = Order::where('id', $request->order_id)
            ->where('user_id', Auth::id())
            ->first();
        
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found']);
        }
        
        if (!in_array($order->order_status, ['Pending', 'Confirmed'])) {
            return response()->json(['success' => false, 'message' => 'This order cannot be cancelled as it is already ' . $order->order_status]);
        }
        
        try {
            DB::beginTransaction();
            
            // Create cancellation record
            OrderCancellation::create([
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'cancellation_reason' => $request->cancellation_reason,
                'cancellation_comment' => $request->cancellation_comment
            ]);
            
            // Update order status
            $order->order_status = 'Cancelled';
            
            // Set refund status if payment was successful
            if ($order->payment_status == 'SUCCESS') {
                $order->refund_status = 'pending';
                $order->refund_amount = $order->total_amount;
            } else {
                $order->refund_status = 'none';
                $order->refund_amount = 0;
            }
            
            $order->save();
            
            // Restore stock
            foreach ($order->items as $item) {
                if ($item->variant_id) {
                    $variant = \App\Models\ProductVariant::find($item->variant_id);
                    if ($variant) {
                        $variant->increment('stock', $item->quantity);
                    }
                } else {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->increment('stock', $item->quantity);
                    }
                }
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true, 
                'message' => 'Order cancelled successfully',
                'refund_status' => $order->refund_status,
                'refund_amount' => $order->refund_amount
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel order: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Get Order Details with Cancellation & Refund Info
     */
    public function getOrderDetails($id)
    {
        try {
$order = Order::with([
    'user',
    'items',
    'cancellation'
])->find($id);
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            // Check if user owns this order
            if (Auth::check() && $order->user_id != Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
            // ==========================================
// RETURN / EXCHANGE REQUEST DETAILS
// ==========================================
$returnRequest = ReturnExchange::with([
    'exchangeProduct',
    'exchangeVariant'
])
    ->where('order_id', $order->id)
    ->latest('id')
    ->first();

            $shippingAddress = null;

            // =========================================================
            // ★★★ Get address from payment_details ★★★
            // =========================================================
            if (!empty($order->payment_details)) {
                $paymentDetails = $order->payment_details;
                
                if (is_string($paymentDetails)) {
                    $paymentDetails = json_decode($paymentDetails, true);
                }

                if (is_array($paymentDetails)) {
                    // Priority 1: Check shipping_address
                    if (isset($paymentDetails['shipping_address']) &&
                        is_array($paymentDetails['shipping_address']) &&
                        !empty($paymentDetails['shipping_address']['address'])) {
                        $shippingAddress = $paymentDetails['shipping_address'];
                    } 
                    // Priority 2: Check address (backup)
                    elseif (isset($paymentDetails['address']) &&
                        is_array($paymentDetails['address']) &&
                        !empty($paymentDetails['address']['address'])) {
                        $shippingAddress = $paymentDetails['address'];
                    }
                }
            }

            // =========================================================
            // ★★★ FALLBACK - ONLY FOR OLD ORDERS ★★★
            // =========================================================
            if (!$shippingAddress || empty($shippingAddress['address'])) {
                $shippingAddress = [
                    'id' => null,
                    'user_id' => $order->user_id,
                    'name' => $order->user->name ?? '',
                    'email' => $order->user->email ?? '',
                    'address' => '',
                    'area' => '',
                    'city' => '',
                    'state' => '',
                    'pincode' => '',
                    'phone' => $order->user->phone ?? ''
                ];
            }

            // =========================================================
            // ★★★ ORDER ITEMS ★★★
            // =========================================================
            $items = [];

            foreach ($order->items as $item) {
                $productImage = \App\Models\ProductImage::where('product_id', $item->product_id)
                    ->where(function ($q) use ($item) {
                        if ($item->variant_id) {
                            $q->where('variant_id', $item->variant_id);
                        } else {
                            $q->whereNull('variant_id');
                        }
                    })
                    ->orderByDesc('is_main')
                    ->orderBy('display_order')
                    ->value('image_path');

                if (!$productImage) {
                    $productImage = \App\Models\ProductImage::where('product_id', $item->product_id)
                        ->orderByDesc('is_main')
                        ->orderBy('display_order')
                        ->value('image_path');
                }

                $items[] = [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'final_price' => $item->final_price ?? $item->price,
                    'size' => $item->size,
                    'color' => $item->color,
                    'variant_id' => $item->variant_id,
                    'product_image' => $productImage
                ];
            }

            // =========================================================
            // ★★★ Calculate Additional Fields ★★★
            // =========================================================
            $orderData = $order->toArray();
            
            // Add calculated fields
            $orderData['product_revenue'] = $order->items->sum(function($item) {
                return ($item->final_price ?? $item->price) * $item->quantity;
            });
            
            $orderData['actual_price'] = $order->items->sum(function($item) {
                $product = Product::find($item->product_id);
                return ($product->price ?? $item->price) * $item->quantity;
            });
            
            $orderData['profit'] = $orderData['product_revenue'] - $orderData['actual_price'];
            $orderData['total_with_shipping'] = $orderData['profit'] + ($order->shipping_charge ?? 0);
            
            // Refund status labels
            $refundLabels = [
                'pending' => 'Pending',
                'processing' => 'Processing',
                'completed' => 'Completed',
                'none' => 'N/A'
            ];
            $orderData['refund_status_label'] = $refundLabels[$order->refund_status] ?? 'N/A';
            
            // Add cancellation details if exists
            if ($order->cancellation) {
                $orderData['cancellation'] = $order->cancellation;
            }

            // =========================================================
            // ★★★ RETURN ORDER DETAILS ★★★
            // =========================================================
            return response()->json([
                'success' => true,
                'order' => [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'total_amount' => $order->total_amount,
                    'shipping_charge' => $order->shipping_charge ?? 0,
                    'payment_status' => $order->payment_status,
                    'order_status' => $order->order_status,
                    'refund_status' => $order->refund_status,
                    'refund_amount' => $order->refund_amount,
                    'refund_status_label' => $orderData['refund_status_label'],
                    'payment_method' => $order->payment_method,
                    'transaction_id' => $order->transaction_id,
                    'payment_id' => $order->payment_id,
                    'payment_details' => $order->payment_details,
                    'order_date' => $order->order_date ?? $order->created_at,
                    'created_at' => $order->created_at,
                    'user' => $order->user ? [
                        'name' => $order->user->name,
                        'email' => $order->user->email,
                        'phone' => $order->user->phone ?? 'N/A'
                    ] : null,
                    'items' => $items,
                    'shipping_address' => $shippingAddress,
                    'cancellation' => $order->cancellation,
                    'return_request' => $returnRequest,
                    'product_revenue' => $orderData['product_revenue'],
                    'actual_price' => $orderData['actual_price'],
                    'profit' => $orderData['profit'],
                    'total_with_shipping' => $orderData['total_with_shipping']
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('getOrderDetails error: ' . $e->getMessage(), [
                'order_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Save guest address to user_addresses table
     */
    private function saveGuestAddress($user, $addressData)
    {
        try {
            // Check if address already exists
            $existingAddress = UserAddress::where('user_id', $user->id)
                ->where('address', $addressData['address'])
                ->where('city', $addressData['city'])
                ->where('state', $addressData['state'])
                ->first();
            
            if (!$existingAddress) {
                UserAddress::create([
                    'user_id' => $user->id,
                    'name' => $addressData['name'] ?? $user->name,
                    'email' => $addressData['email'] ?? $user->email,
                    'address' => $addressData['address'],
                    'city' => $addressData['city'],
                    'state' => $addressData['state'],
                    'pincode' => $addressData['pincode'],
                    'phone' => $addressData['phone'] ?? $user->phone,
                    'is_default' => true
                ]);
                Log::info('✅ Guest address saved for user: ' . $user->id);
            }
        } catch (\Exception $e) {
            Log::error('❌ Failed to save guest address: ' . $e->getMessage());
        }
    }

    private function sendOrderConfirmationEmail($order)
    {
        try {
            Log::info('📧 Attempting to send order confirmation email for order: ' . $order->order_number);
            
            $user = $order->user;
            if (!$user) {
                Log::error('❌ No user found for order: ' . $order->order_number);
                return;
            }
            
            if (empty($user->email) || !filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                Log::error('❌ Invalid user email: ' . ($user->email ?? 'null'));
                return;
            }
            
            $shippingAddress = null;
            if ($order->payment_details) {
                try {
                    $paymentDetails = is_string($order->payment_details) ? json_decode($order->payment_details, true) : $order->payment_details;
                    if (isset($paymentDetails['shipping_address']) && !empty($paymentDetails['shipping_address'])) {
                        $shippingAddress = $paymentDetails['shipping_address'];
                    } elseif (isset($paymentDetails['address']) && !empty($paymentDetails['address'])) {
                        $shippingAddress = $paymentDetails['address'];
                    }
                } catch (\Exception $e) {
                    Log::warning('Could not parse payment_details: ' . $e->getMessage());
                }
            }
            
            if (!$shippingAddress) {
                try {
                    $userAddress = UserAddress::where('user_id', $order->user_id)
                        ->orderBy('is_default', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->first();
                    
                    if ($userAddress) {
                        $shippingAddress = [
                            'name' => $userAddress->name ?? '',
                            'address' => $userAddress->address ?? '',
                            'area' => $userAddress->area ?? '',
                            'city' => $userAddress->city ?? '',
                            'state' => $userAddress->state ?? '',
                            'pincode' => $userAddress->pincode ?? '',
                            'phone' => $userAddress->phone ?? ''
                        ];
                    }
                } catch (\Exception $e) {
                    Log::warning('Could not get user address: ' . $e->getMessage());
                }
            }
            
            $items = $order->items;
            
            Log::info('📧 Sending email to: ' . $user->email);
            
            Mail::to($user->email)->send(new OrderConfirmationMail($order, $user, $items, $shippingAddress));
            
            Log::info('✅ Order confirmation email sent successfully to: ' . $user->email . ' for order: ' . $order->order_number);
            
        } catch (\Exception $e) {
            Log::error('❌ Failed to send order confirmation email: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
        }
    }
    public function verifyRazorpayPayment(Request $request)
{
    try {

        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
            'order_id' => 'required|integer',
        ]);

        $api = new Api(
            config('services.razorpay.key_id'),
            config('services.razorpay.key_secret')
        );

        // Verify Razorpay signature
        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature,
        ];

        $api->utility->verifyPaymentSignature($attributes);

        $order = Order::find($request->order_id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        // Prevent duplicate processing
        if ($order->payment_status === 'SUCCESS') {
            return response()->json([
                'success' => true,
                'message' => 'Payment already verified'
            ]);
        }

        // Get existing payment details
        $paymentDetails = [];

        if (!empty($order->payment_details)) {

            $paymentDetails = is_string($order->payment_details)
                ? json_decode($order->payment_details, true)
                : $order->payment_details;

            if (!is_array($paymentDetails)) {
                $paymentDetails = [];
            }
        }

        // Save Razorpay response
        $paymentDetails['razorpay_response'] = [
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_signature' => $request->razorpay_signature,
        ];

        // Update order
        $order->update([
            'payment_status' => 'SUCCESS',
            'order_status' => 'Confirmed',
            'payment_id' => $request->razorpay_payment_id,
            'transaction_id' => $request->razorpay_payment_id,
            'payment_details' => json_encode($paymentDetails)
        ]);

        Log::info(
            'Razorpay payment verified successfully',
            [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'payment_id' => $request->razorpay_payment_id
            ]
        );

        // Clear checkout session
        session()->forget('pending_order_id');
        session()->forget('pending_user_id');
        session()->forget('checkout_cart');

        // Send confirmation email
        $this->sendOrderConfirmationEmail($order);

        return response()->json([
            'success' => true,
            'message' => 'Payment verified successfully'
        ]);

    } catch (\Exception $e) {

        Log::error(
            'Razorpay payment verification failed',
            [
                'error' => $e->getMessage(),
                'order_id' => $request->order_id ?? null
            ]
        );

        return response()->json([
            'success' => false,
            'message' => 'Payment verification failed'
        ], 400);
    }
}


public function razorpayPaymentFailure(Request $request)
{
    try {

        $orderId = $request->input('order_id');

        $order = Order::find($orderId);

        if ($order) {

            // Restore stock only if order is still pending
            if ($order->payment_status === 'PENDING') {

                foreach ($order->items as $item) {

                    if ($item->variant_id) {

                        $variant = \App\Models\ProductVariant::find(
                            $item->variant_id
                        );

                        if ($variant) {
                            $variant->increment(
                                'stock',
                                $item->quantity
                            );
                        }

                    } else {

                        $product = Product::find(
                            $item->product_id
                        );

                        if ($product) {
                            $product->increment(
                                'stock',
                                $item->quantity
                            );
                        }
                    }
                }

                $order->update([
                    'payment_status' => 'FAILED',
                    'order_status' => 'Failed'
                ]);
            }
        }

        session()->forget('pending_order_id');
        session()->forget('pending_user_id');
        session()->forget('checkout_cart');

        return redirect()
            ->route('cart')
            ->with(
                'error',
                'Payment failed or was cancelled. Please try again.'
            );

    } catch (\Exception $e) {

        Log::error(
            'Razorpay failure handling error: ' .
            $e->getMessage()
        );

        return redirect()
            ->route('cart')
            ->with(
                'error',
                'Payment failed. Please try again.'
            );
    }
}
}