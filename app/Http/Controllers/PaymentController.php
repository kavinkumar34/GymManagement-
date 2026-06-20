<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Mail\OrderConfirmationMail;

class PaymentController extends Controller
{
    private $merchantKey = '5FOEb9';
    private $merchantSalt = 'Q7wnZax0G4ySOkdHDpW7bb1Zv8KvsGCs';
    private $payuUrl = 'https://test.payu.in/_payment';

    public function buyNow(Request $request)
    {
        // Check login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to purchase');
        }

        $user = Auth::user();
        
        // Check if coming from cart (multiple items) or single product
        $checkoutCart = session()->get('checkout_cart');
        
        if ($checkoutCart && count($checkoutCart) > 0) {
            // Process multiple items from cart
            return $this->processCartCheckout($request, $user, $checkoutCart);
        } else {
            // Process single product
            return $this->processSingleProduct($request, $user);
        }
    }
    
    private function processSingleProduct($request, $user)
    {
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;
        
        // Check stock
        $stock = $product->stock;
        if ($quantity > $stock) {
            return redirect()->back()->with('error', "Only {$stock} items available for {$product->name}");
        }
        
        $amount = $product->discount_price ?? $product->price;
        $totalAmount = number_format($amount * $quantity, 2, '.', '');
        $txnid = 'TXN' . time() . rand(1000, 9999);
        $productInfo = substr(preg_replace('/[^A-Za-z0-9 ]/', '', $product->name), 0, 100);
        
        // Create order
        $order = $this->createOrder($txnid, $user->id, $totalAmount);
        
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $quantity,
            'price' => $amount
        ]);
        
        // Update product stock
        $product->decrement('stock', $quantity);
        
        return $this->redirectToPayU($user, $txnid, $totalAmount, $productInfo, $order->id);
    }
    
    private function processCartCheckout($request, $user, $checkoutCart)
    {
        $totalAmount = 0;
        $productItems = [];
        $productInfo = '';
        
        foreach ($checkoutCart as $item) {
            $product = Product::find($item['id']);
            if (!$product) {
                continue;
            }
            
            // Check stock for each item
            if ($item['quantity'] > $product->stock) {
                return redirect()->route('cart')->with('error', "Only {$product->stock} items available for {$product->name}. Please update your cart.");
            }
            
            $amount = $product->discount_price ?? $product->price;
            $totalAmount += $amount * $item['quantity'];
            $productItems[] = [
                'product' => $product,
                'quantity' => $item['quantity'],
                'price' => $amount
            ];
            $productInfo .= $product->name . ' x' . $item['quantity'] . ', ';
        }
        
        $productInfo = substr(rtrim($productInfo, ', '), 0, 100);
        $txnid = 'TXN' . time() . rand(1000, 9999);
        
        // Create order
        $order = $this->createOrder($txnid, $user->id, $totalAmount);
        
        // Create order items and update stock
        foreach ($productItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'product_name' => $item['product']->name,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
            
            // Update product stock
            $item['product']->decrement('stock', $item['quantity']);
        }
        
        // Clear the checkout cart session
        session()->forget('checkout_cart');
        
        return $this->redirectToPayU($user, $txnid, $totalAmount, $productInfo, $order->id);
    }
    
    private function createOrder($txnid, $userId, $totalAmount)
    {
        return Order::create([
            'order_number' => $txnid,
            'user_id' => $userId,
            'total_amount' => $totalAmount,
            'payment_status' => 'PENDING',
            'order_status' => 'Pending',
            'payment_method' => 'PayU',
            'transaction_id' => $txnid,
            'order_date' => now()
        ]);
    }
    
    private function redirectToPayU($user, $txnid, $totalAmount, $productInfo, $orderId)
    {
        // Correct PayU Hash Format
        $hashString = $this->merchantKey . '|' . $txnid . '|' . $totalAmount . '|' . $productInfo . '|' . 
                      $user->name . '|' . $user->email . '|' . '||||||||||' . $this->merchantSalt;
        
        $hash = hash('sha512', $hashString);
        
        // Store order ID in session
        session(['pending_order_id' => $orderId]);
        session(['pending_user_id' => $user->id]);

        $successUrl = url('/payment/success');
        $failureUrl = url('/payment/failure');

        return view('payment.payu-form', [
            'action' => $this->payuUrl,
            'key' => $this->merchantKey,
            'txnid' => $txnid,
            'amount' => $totalAmount,
            'productinfo' => $productInfo,
            'firstname' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? '9876543210',
            'surl' => $successUrl,
            'furl' => $failureUrl,
            'hash' => $hash
        ]);
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

        // Check if already processed
        if ($order->payment_status == 'SUCCESS') {
            return redirect()->route('order.success', $order->id)->with('success', 'Payment already confirmed!');
        }

        // Restore user session using order's user_id
        if (!Auth::check() && $order->user_id) {
            Auth::loginUsingId($order->user_id);
        }

        if ($status == 'success' || $mihpayid) {
            $order->update([
                'payment_status' => 'SUCCESS',
                'order_status' => 'Confirmed',
                'payment_id' => $mihpayid,
                'payment_details' => json_encode($request->all())
            ]);
            
            Log::info('Payment successful for order: ' . $txnid);
            session()->forget('pending_order_id');
            session()->forget('checkout_cart');
            
            // ⭐⭐⭐ SEND EMAIL CONFIRMATION ⭐⭐⭐
            $this->sendOrderConfirmationEmail($order);
            
            // IMPORTANT: Return redirect with clear cart parameter
            return redirect()->route('order.success', ['id' => $order->id, 'clear_cart' => 1])->with('success', 'Payment successful!');
        } else {
            // Restore stock if payment failed
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->quantity);
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
            // Restore user session
            if (!Auth::check() && $order->user_id) {
                Auth::loginUsingId($order->user_id);
            }
            
            // Restore stock
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->quantity);
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
        
        if (!Auth::check() && $order->user_id) {
            Auth::loginUsingId($order->user_id);
        }
        
        if ($order->user_id != Auth::id()) {
            abort(403);
        }

        // Pass clear_cart flag to view
        $clearCart = request()->has('clear_cart');
        
        return view('payment.order-success', compact('order', 'clearCart'));
    }
    
    public function myOrders()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view orders');
        }
        
        $orders = Order::with('items')
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(10);
        
        return view('payment.my-orders', compact('orders'));
    }
    
    public function placeCodOrder(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to place order');
        }
        
        $user = Auth::user();
        $cart = session()->get('checkout_cart');
        
        if (!$cart || count($cart) == 0) {
            return redirect()->route('cart')->with('error', 'Your cart is empty');
        }
        
        $totalAmount = 0;
        $productItems = [];
        
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if (!$product) {
                continue;
            }
            
            // Check stock
            if ($item['quantity'] > $product->stock) {
                return redirect()->route('cart')->with('error', "Only {$product->stock} items available for {$product->name}");
            }
            
            $amount = $product->discount_price ?? $product->price;
            $totalAmount += $amount * $item['quantity'];
            $productItems[] = [
                'product' => $product,
                'quantity' => $item['quantity'],
                'price' => $amount
            ];
        }
        
        $txnid = 'COD' . time() . rand(1000, 9999);
        
        // Create order
        $order = Order::create([
            'order_number' => $txnid,
            'user_id' => $user->id,
            'total_amount' => $totalAmount,
            'payment_status' => 'PENDING',
            'order_status' => 'Pending',
            'payment_method' => 'COD',
            'transaction_id' => $txnid,
            'order_date' => now(),
            'payment_details' => json_encode([
                'shipping_address' => $request->address,
                'payment_method' => 'COD'
            ])
        ]);
        
        // Create order items and update stock
        foreach ($productItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'product_name' => $item['product']->name,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
            
            // Update product stock
            $item['product']->decrement('stock', $item['quantity']);
        }
        
        // Clear the checkout cart session
        session()->forget('checkout_cart');
        
        // ⭐⭐⭐ SEND EMAIL CONFIRMATION FOR COD ⭐⭐⭐
        $this->sendOrderConfirmationEmail($order);
        
        return redirect()->route('order.success', $order->id)->with('success', 'Order placed successfully! You will pay on delivery.');
    }
    
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
        
        // Check if order can be cancelled (only pending or confirmed orders)
        if (!in_array($order->order_status, ['Pending', 'Confirmed'])) {
            return response()->json(['success' => false, 'message' => 'This order cannot be cancelled as it is already ' . $order->order_status]);
        }
        
        // Create cancellation record
        \App\Models\OrderCancellation::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'cancellation_reason' => $request->cancellation_reason,
            'cancellation_comment' => $request->cancellation_comment
        ]);
        
        // Update order status to Cancelled
        $order->order_status = 'Cancelled';
        $order->save();
        
        // Restore product stock
        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->increment('stock', $item->quantity);
            }
        }
        
        return response()->json(['success' => true, 'message' => 'Order cancelled successfully']);
    }

    public function getOrderDetails($id)
    {
        try {
            $order = Order::with(['user', 'items'])->find($id);
            
            if (!$order) {
                return response()->json(['success' => false, 'message' => 'Order not found']);
            }
            
            // Get user's saved address from user_addresses table
            $userAddress = \App\Models\UserAddress::where('user_id', $order->user_id)
                ->orderBy('is_default', 'desc')
                ->first();
            
            // Try to get shipping address from payment_details
            $shippingAddress = null;
            if ($order->payment_details) {
                try {
                    $paymentDetails = is_string($order->payment_details) ? json_decode($order->payment_details, true) : $order->payment_details;
                    if (isset($paymentDetails['shipping_address'])) {
                        $shippingAddress = $paymentDetails['shipping_address'];
                    }
                } catch (\Exception $e) {}
            }
            
            // If no address in payment_details, use user's saved address
            if ((!$shippingAddress || empty($shippingAddress['address'])) && $userAddress) {
                $shippingAddress = [
                    'name' => $userAddress->name,
                    'address' => $userAddress->address,
                    'area' => $userAddress->area,
                    'city' => $userAddress->city,
                    'state' => $userAddress->state,
                    'pincode' => $userAddress->pincode,
                    'phone' => $userAddress->phone
                ];
            }
            
            $items = [];
            foreach ($order->items as $item) {
                $items[] = [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'product_image' => $item->product_image ?? ($item->product ? $item->product->image : null)
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
                    'order_date' => $order->order_date ?? $order->created_at,
                    'created_at' => $order->created_at,
                    'user' => $order->user ? [
                        'name' => $order->user->name,
                        'email' => $order->user->email,
                        'phone' => $order->user->phone ?? 'N/A'
                    ] : null,
                    'items' => $items,
                    'shipping_address' => $shippingAddress
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * ⭐ NEW: Send Order Confirmation Email with Debugging
     */
    private function sendOrderConfirmationEmail($order)
    {
        try {
            // Log that we're trying to send email
            Log::info('Attempting to send order confirmation email for order: ' . $order->order_number);
            
            // Get user
            $user = $order->user;
            if (!$user) {
                Log::error('No user found for order: ' . $order->order_number);
                return;
            }
            
            // Get shipping address
            $shippingAddress = null;
            if ($order->payment_details) {
                $paymentDetails = is_string($order->payment_details) ? json_decode($order->payment_details, true) : $order->payment_details;
                if (isset($paymentDetails['shipping_address']) && !empty($paymentDetails['shipping_address'])) {
                    $shippingAddress = $paymentDetails['shipping_address'];
                } elseif (isset($paymentDetails['address']) && !empty($paymentDetails['address'])) {
                    $shippingAddress = $paymentDetails['address'];
                }
            }
            
            // If no address in payment_details, get from user_addresses
            if (!$shippingAddress) {
                $userAddress = \App\Models\UserAddress::where('user_id', $order->user_id)
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
            
            $items = $order->items;
            
            // Send email
            Mail::to($user->email)->send(new OrderConfirmationMail($order, $user, $items, $shippingAddress));
            
            Log::info('✅ Order confirmation email sent successfully to: ' . $user->email . ' for order: ' . $order->order_number);
            
        } catch (\Exception $e) {
            Log::error('❌ Failed to send order confirmation email: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
        }
    }
}