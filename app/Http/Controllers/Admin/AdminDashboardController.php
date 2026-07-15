<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Contact;
use App\Models\OrderItem;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ===== STATISTICS =====
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'SUCCESS')->sum('total_amount');
        $totalProducts = Product::count();
        
        // Total Members - All users from users table
        $totalMembers = User::count();
        
        $pendingOrders = Order::where('order_status', 'Pending')->count();
        
        // Monthly Revenue
        $monthlyRevenue = Order::where('payment_status', 'SUCCESS')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');
        
        // ===== RECENT ORDERS (last 5) =====
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // ===== RECENT MEMBERS (from users table - last 5) =====
        $recentMembers = User::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // ===== RECENT CONTACT MESSAGES (last 5) =====
        $recentMessages = Contact::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // ===== TOP SELLING PRODUCTS =====
        $topProducts = OrderItem::select(
                'product_id',
                \DB::raw('SUM(quantity) as total_sold'),
                \DB::raw('SUM(price * quantity) as total_revenue')
            )
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get()
            ->map(function($item) {
                $product = Product::find($item->product_id);
                return (object) [
                    'name' => $product ? $product->name : 'Unknown',
                    'total_sold' => $item->total_sold,
                    'total_revenue' => $item->total_revenue
                ];
            });
        
        // ===== MONTHLY REVENUE DATA (last 12 months) =====
        $monthlyLabels = [];
        $monthlyRevenueData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyLabels[] = $month->format('M');
            $monthlyRevenueData[] = Order::where('payment_status', 'SUCCESS')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_amount');
        }
        
        // ===== ORDER STATUS DISTRIBUTION =====
        $statusLabels = ['Pending', 'Confirmed', 'Shipped', 'Delivered', 'Cancelled', 'Failed'];
        $statusData = [
            Order::where('order_status', 'Pending')->count(),
            Order::where('order_status', 'Confirmed')->count(),
            Order::where('order_status', 'Shipped')->count(),
            Order::where('order_status', 'Delivered')->count(),
            Order::where('order_status', 'Cancelled')->count(),
            Order::where('order_status', 'Failed')->count()
        ];
        
        // ===== GROWTH PERCENTAGES =====
        $ordersGrowth = 0;
        $revenueGrowth = 0;
        $productsGrowth = 0;
        $membersGrowth = 0;
        
        return view('admin.dashboard', compact(
            'totalOrders', 'totalRevenue', 'totalProducts', 
            'totalMembers', 'pendingOrders', 'monthlyRevenue',
            'recentOrders', 'recentMembers', 'recentMessages',
            'topProducts', 'monthlyLabels', 'monthlyRevenueData',
            'statusLabels', 'statusData',
            'ordersGrowth', 'revenueGrowth', 'productsGrowth', 'membersGrowth'
        ));
    }
}