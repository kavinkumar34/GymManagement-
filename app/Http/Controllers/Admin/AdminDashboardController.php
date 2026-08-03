<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Contact;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ===== STATISTICS =====
        $totalOrders = Order::count();
        
        // ==========================================
        // TOTAL REVENUE
        // Revenue = (order_items.final_price - products.price) * quantity + shipping_charge
        // ==========================================
        $totalRevenue = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.payment_status', 'SUCCESS')
            ->sum(DB::raw('(order_items.final_price - products.price) * order_items.quantity + orders.shipping_charge')) ?? 0;
        
        $totalProducts = Product::count();
        
        // Total Members - All users from users table
        $totalMembers = User::count();
        
        $pendingOrders = Order::where('order_status', 'Pending')->count();
        
        // ==========================================
        // MONTHLY REVENUE
        // Revenue = (order_items.final_price - products.price) * quantity + shipping_charge
        // For your data: (236 - 100) × 2 + 100 = 136 × 2 + 100 = 272 + 100 = 372
        // ==========================================
        $monthlyRevenue = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.payment_status', 'SUCCESS')
            ->whereMonth('orders.created_at', now()->month)
            ->whereYear('orders.created_at', now()->year)
            ->sum(DB::raw('(order_items.final_price - products.price) * order_items.quantity + orders.shipping_charge')) ?? 0;
        
        // ==========================================
        // REVENUE BREAKDOWN BY ORDER (for verification)
        // ==========================================
        $revenueByOrder = Order::where('payment_status', 'SUCCESS')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->get()
            ->map(function($order) {
                // Get order items with product details
                $orderItems = OrderItem::where('order_id', $order->id)
                    ->join('products', 'order_items.product_id', '=', 'products.id')
                    ->select(
                        'order_items.*',
                        'products.price as product_price',
                        DB::raw('(order_items.final_price - products.price) * order_items.quantity as product_revenue')
                    )
                    ->get();
                
                $totalProductRevenue = $orderItems->sum('product_revenue');
                $totalFinalPrice = $orderItems->sum(function($item) {
                    return $item->final_price * $item->quantity;
                });
                $totalProductPrice = $orderItems->sum(function($item) {
                    return $item->product_price * $item->quantity;
                });
                
                // Total revenue including shipping
                $totalRevenue = $totalProductRevenue + ($order->shipping_charge ?? 0);
                
                return (object) [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'total_amount' => $order->total_amount,
                    'shipping_charge' => $order->shipping_charge ?? 0,
                    'total_final_price' => $totalFinalPrice,
                    'total_product_price' => $totalProductPrice,
                    'product_revenue' => $totalProductRevenue,
                    'total_revenue' => $totalRevenue,
                    'items' => $orderItems
                ];
            });
        
        // ==========================================
        // MONTHLY REVENUE DETAIL (for display in debug)
        // ==========================================
        $monthlyRevenueDetails = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.payment_status', 'SUCCESS')
            ->whereMonth('orders.created_at', now()->month)
            ->whereYear('orders.created_at', now()->year)
            ->select(
                'products.name as product_name',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.final_price * order_items.quantity) as total_final_price'),
                DB::raw('SUM(products.price * order_items.quantity) as total_product_price'),
                DB::raw('SUM((order_items.final_price - products.price) * order_items.quantity) as product_revenue'),
                DB::raw('SUM((order_items.final_price - products.price) * order_items.quantity) + SUM(orders.shipping_charge) as total_revenue_with_shipping')
            )
            ->groupBy('products.id', 'products.name')
            ->get();
        
        // ==========================================
        // MONTHLY REVENUE WITH SHIPPING DETAILS
        // ==========================================
        $monthlyShippingTotal = Order::where('payment_status', 'SUCCESS')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('shipping_charge') ?? 0;
        
        $monthlyProductRevenue = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.payment_status', 'SUCCESS')
            ->whereMonth('orders.created_at', now()->month)
            ->whereYear('orders.created_at', now()->year)
            ->sum(DB::raw('(order_items.final_price - products.price) * order_items.quantity')) ?? 0;
        
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
        
        // ==========================================
        // TOP SELLING PRODUCTS
        // ==========================================
        $topProducts = OrderItem::select(
                'product_id',
                DB::raw('SUM(quantity) as total_sold'),
                DB::raw('SUM(final_price * quantity) as total_revenue')
            )
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'SUCCESS')
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
        
        // ==========================================
        // MONTHLY REVENUE DATA (last 12 months)
        // ==========================================
        $monthlyLabels = [];
        $monthlyRevenueData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyLabels[] = $month->format('M');
            
            $revenue = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->where('orders.payment_status', 'SUCCESS')
                ->whereYear('orders.created_at', $month->year)
                ->whereMonth('orders.created_at', $month->month)
                ->sum(DB::raw('(order_items.final_price - products.price) * order_items.quantity + orders.shipping_charge')) ?? 0;
            
            $monthlyRevenueData[] = $revenue;
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
        
        // ==========================================
        // GROWTH PERCENTAGES
        // ==========================================
        
        // Orders Growth
        $lastMonthOrders = Order::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $ordersGrowth = $lastMonthOrders > 0 
            ? round((($totalOrders - $lastMonthOrders) / $lastMonthOrders) * 100, 1) 
            : 0;
        
        // Revenue Growth
        $lastMonthRevenue = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.payment_status', 'SUCCESS')
            ->whereMonth('orders.created_at', now()->subMonth()->month)
            ->whereYear('orders.created_at', now()->subMonth()->year)
            ->sum(DB::raw('(order_items.final_price - products.price) * order_items.quantity + orders.shipping_charge')) ?? 0;
        $revenueGrowth = $lastMonthRevenue > 0 
            ? round((($totalRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1) 
            : 0;
        
        // Products Growth
        $lastMonthProducts = Product::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $productsGrowth = $lastMonthProducts > 0 
            ? round((($totalProducts - $lastMonthProducts) / $lastMonthProducts) * 100, 1) 
            : 0;
        
        // Members Growth
        $lastMonthMembers = User::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $membersGrowth = $lastMonthMembers > 0 
            ? round((($totalMembers - $lastMonthMembers) / $lastMonthMembers) * 100, 1) 
            : 0;
        
        return view('admin.dashboard', compact(
            'totalOrders', 'totalRevenue', 'totalProducts', 
            'totalMembers', 'pendingOrders', 'monthlyRevenue',
            'monthlyProductRevenue', 'monthlyShippingTotal',
            'recentOrders', 'recentMembers', 'recentMessages',
            'topProducts', 'monthlyLabels', 'monthlyRevenueData',
            'statusLabels', 'statusData',
            'ordersGrowth', 'revenueGrowth', 'productsGrowth', 'membersGrowth',
            'revenueByOrder', 'monthlyRevenueDetails'
        ));
    }
}