<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');
        
        // Search functionality
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('transaction_id', 'like', "%{$search}%")
                  ->orWhere('payment_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filter by payment status
        if ($request->payment_status && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }
        
        // Filter by order status
        if ($request->order_status && $request->order_status != '') {
            $query->where('order_status', $request->order_status);
        }
        
        // Sorting
        $sortBy = $request->sort_by ?? 'id';
        $sortOrder = $request->sort_order ?? 'desc';
        
        // Handle customer sorting (joining users table)
        if ($sortBy == 'customer') {
            $query->leftJoin('users', 'orders.user_id', '=', 'users.id')
                  ->select('orders.*')
                  ->orderBy('users.name', $sortOrder);
        } elseif ($sortBy == 'total_amount') {
            $query->orderBy('total_amount', $sortOrder);
        } elseif ($sortBy == 'order_number') {
            $query->orderBy('order_number', $sortOrder);
        } elseif ($sortBy == 'created_at') {
            $query->orderBy('created_at', $sortOrder);
        } else {
            $query->orderBy('id', $sortOrder);
        }
        
        // Pagination (default 10 per page)
        $perPage = $request->per_page ?? 10;
        $orders = $query->paginate($perPage);
        
        // Set session that admin has viewed payments page
        session(['payments_last_viewed_at' => now()]);
        
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
    
    // Add this new method to mark payments as viewed
    public function markViewed(Request $request)
    {
        session(['payments_last_viewed_at' => now()]);
        return response()->json(['success' => true]);
    }
    
    // Add this new method to get new orders count
    public function getNewOrdersCount(Request $request)
    {
        $lastViewedAt = session('payments_last_viewed_at', now()->subDays(30));
        
        $newCount = Order::where('payment_status', 'PENDING')
            ->where('created_at', '>', $lastViewedAt)
            ->count();
        
        return response()->json(['new_count' => $newCount]);
    }
}