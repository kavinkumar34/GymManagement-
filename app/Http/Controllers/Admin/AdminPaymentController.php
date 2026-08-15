<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminPaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('transaction_id', 'like', "%{$search}%")
                    ->orWhere('payment_id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->order_status != '') {
            $query->where('order_status', $request->order_status);
        }

        $sortBy = $request->sort_by ?? 'id';
        $sortOrder = $request->sort_order ?? 'desc';

        switch ($sortBy) {
            case 'customer':
                $query->leftJoin('users', 'orders.user_id', '=', 'users.id')
                    ->select('orders.*')
                    ->orderBy('users.name', $sortOrder);
                break;
            case 'total_amount':
                $query->orderBy('total_amount', $sortOrder);
                break;
            case 'order_number':
                $query->orderBy('order_number', $sortOrder);
                break;
            case 'created_at':
                $query->orderBy('created_at', $sortOrder);
                break;
            default:
                $query->orderBy('id', 'desc');
        }

        $orders = $query->paginate($request->per_page ?? 10);

        // Hide badge after opening Orders page
        cache()->forever('orders_last_viewed', now());

        return view('admin.payments.index', compact('orders'));
    }
    
    public function show($id)
    {
        $order = Order::with('user', 'items')->findOrFail($id);
        return view('admin.payments.show', compact('order'));
    }
    
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.payments.edit', compact('order'));
    }
    
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'payment_status' => 'required|in:PENDING,SUCCESS,FAILED',
            'order_status' => 'required|in:Pending,Confirmed,Shipped,Delivered,Cancelled,Failed',
        ]);
        
        $order->update([
            'payment_status' => $request->payment_status,
            'order_status' => $request->order_status,
        ]);
        
        return redirect()->route('admin.payments')->with('success', 'Order status updated successfully!');
    }
    
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        
        return redirect()->route('admin.payments')->with('success', 'Order deleted successfully!');
    }
    
    public function markViewed(Request $request)
    {
        cache()->forever('orders_last_viewed', now());
        return response()->json(['success' => true]);
    }
    
    public function getNewOrdersCount(Request $request)
    {
        $lastViewed = cache()->get('orders_last_viewed', now()->subDays(30));
        $count = Order::where('payment_status', 'PENDING')
            ->where('created_at', '>', $lastViewed)
            ->count();
        return response()->json(['new_count' => $count]);
    }
    
    /**
     * Update Refund Status
     */
    public function updateRefundStatus(Request $request, $orderId)
    {
        try {
            $request->validate([
                'refund_status' => 'required|in:pending,processing,completed'
            ]);

            $order = Order::findOrFail($orderId);
            
            // Only allow refund status update for cancelled orders with successful payment
            if ($order->order_status != 'Cancelled' || $order->payment_status != 'SUCCESS') {
                return response()->json([
                    'success' => false,
                    'message' => 'Refund status can only be updated for cancelled orders with successful payment.'
                ], 400);
            }

            $order->refund_status = $request->refund_status;
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Refund status updated successfully.',
                'refund_status' => $order->refund_status
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function getOrderDetails($id)
    {
        try {
            $order = Order::with(['user', 'items', 'cancellation'])->find($id);

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ]);
            }

            // =========================================================
            // ★★★ SHIPPING ADDRESS - ORDER'S SELECTED ADDRESS ONLY ★★★
            // =========================================================
            $shippingAddress = null;

            if (!empty($order->payment_details)) {
                try {
                    $paymentDetails = is_string($order->payment_details)
                        ? json_decode($order->payment_details, true)
                        : $order->payment_details;

                    if (is_array($paymentDetails) && isset($paymentDetails['shipping_address']) && is_array($paymentDetails['shipping_address'])) {
                        $shippingAddress = $paymentDetails['shipping_address'];
                    } elseif (is_array($paymentDetails) && isset($paymentDetails['address']) && is_array($paymentDetails['address'])) {
                        $shippingAddress = $paymentDetails['address'];
                    }
                } catch (\Exception $e) {
                    $shippingAddress = null;
                }
            }

            // FALLBACK ONLY IF OLD ORDER HAS NO SAVED ADDRESS
            if (!$shippingAddress || empty($shippingAddress['address'])) {
                $shippingAddress = [
                    'name' => $order->user->name ?? '',
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
                    'product_image' => $productImage,
                    'product' => $item->product
                ];
            }

            // =========================================================
            // ★★★ CALCULATE ADDITIONAL FIELDS ★★★
            // =========================================================
            $productRevenue = $order->items->sum(function($item) {
                return ($item->final_price ?? $item->price) * $item->quantity;
            });
            
            $actualPrice = $order->items->sum(function($item) {
                $product = Product::find($item->product_id);
                return ($product->price ?? $item->price) * $item->quantity;
            });
            
            $profit = $productRevenue - $actualPrice;
            $totalWithShipping = $profit + ($order->shipping_charge ?? 0);

            // Refund status labels
            $refundLabels = [
                'pending' => 'Pending',
                'processing' => 'Processing',
                'completed' => 'Completed',
                'none' => 'N/A'
            ];
            $refundStatusLabel = $refundLabels[$order->refund_status] ?? 'N/A';
            
            // Refund status badge class
            $refundBadgeClass = 'secondary';
            if ($order->refund_status == 'pending') {
                $refundBadgeClass = 'failed';
            } elseif ($order->refund_status == 'processing') {
                $refundBadgeClass = 'pending';
            } elseif ($order->refund_status == 'completed') {
                $refundBadgeClass = 'success';
            }

            // =========================================================
            // ★★★ RESPONSE ★★★
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
                    'refund_status_label' => $refundStatusLabel,
                    'refund_status_badge' => $refundBadgeClass,
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
                    'product_revenue' => $productRevenue,
                    'actual_price' => $actualPrice,
                    'profit' => $profit,
                    'total_with_shipping' => $totalWithShipping
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Admin getOrderDetails error: ' . $e->getMessage(), [
                'order_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function updateOrderStatus(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);
            $newStatus = $request->order_status;
            
            // Validate status
            $validStatuses = ['Pending', 'Confirmed', 'Shipped', 'Delivered', 'Cancelled', 'Failed'];
            if (!in_array($newStatus, $validStatuses)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid order status'
                ]);
            }
            
            $order->order_status = $newStatus;
            
            // Auto update payment status to PAID for COD when Delivered
            if ($newStatus === 'Delivered' && $order->payment_method === 'COD') {
                $order->payment_status = 'SUCCESS';
            }
            
            $order->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully',
                'order_status' => $order->order_status,
                'payment_status' => $order->payment_status
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function updateShipment(Request $request, $id)
    {
        try {
            $order = Order::find($id);
            
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ]);
            }
            
            $trackingData = [
                'tracking_id' => $request->tracking_id,
                'courier_name' => $request->courier_name,
                'tracking_link' => $request->tracking_link
            ];
            
            $paymentDetails = $order->payment_details ? json_decode($order->payment_details, true) : [];
            $paymentDetails['tracking'] = $trackingData;
            $order->payment_details = json_encode($paymentDetails);
            $order->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Shipment details updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}