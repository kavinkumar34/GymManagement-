<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

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
}