<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    return response()->json([
        'success' => true
    ]);
}
    
  public function getNewOrdersCount(Request $request)
{
    $lastViewed = cache()->get(
        'orders_last_viewed',
        now()->subDays(30)
    );

    $count = Order::where('payment_status', 'PENDING')
        ->where('created_at', '>', $lastViewed)
        ->count();

    return response()->json([
        'new_count' => $count
    ]);
}
    
public function getOrderDetails($id)
{
    try {
        $order = Order::with(['user', 'items'])->find($id);
        
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found']);
        }
        
        // Get shipping address from user_addresses table
        $shippingAddress = null;
        
        // Try to get from user_addresses table first
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
        
        // If no address in user_addresses, try from payment_details
        if (!$shippingAddress && $order->payment_details) {
            try {
                $paymentDetails = is_string($order->payment_details) ? json_decode($order->payment_details, true) : $order->payment_details;
                if (isset($paymentDetails['shipping_address'])) {
                    $shippingAddress = $paymentDetails['shipping_address'];
                } elseif (isset($paymentDetails['address'])) {
                    $shippingAddress = $paymentDetails['address'];
                }
            } catch (\Exception $e) {}
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
        
        // ===== NEW: Auto update payment status to PAID for COD when Delivered =====
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