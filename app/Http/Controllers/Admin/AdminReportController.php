<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        // Get filter values
        $filterType = $request->get('filter_type', 'monthly');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $status = $request->get('status');
        
        // Build query for orders
        $ordersQuery = Order::with('user');
        
        // Apply filters
        if ($startDate && $endDate) {
            $ordersQuery->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($filterType == 'daily') {
            $ordersQuery->whereDate('created_at', today());
        } elseif ($filterType == 'weekly') {
            $ordersQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($filterType == 'monthly') {
            $ordersQuery->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year);
        } elseif ($filterType == 'yearly') {
            $ordersQuery->whereYear('created_at', now()->year);
        }
        
        if ($status) {
            $ordersQuery->where('order_status', $status);
        }
        
        // Get orders with pagination
        $orders = $ordersQuery->orderBy('created_at', 'desc')->paginate(15);
        
        // ==========================================
        // CALCULATE FOR EACH ORDER
        // ==========================================
        foreach ($orders as $order) {
            // Get order items with product and variant details
            $order->items = OrderItem::where('order_id', $order->id)
                ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
                ->leftJoin('product_variants', 'order_items.variant_id', '=', 'product_variants.id')
                ->select(
                    'order_items.*',
                    DB::raw('COALESCE(products.price, product_variants.price, order_items.price) as product_price')
                )
                ->get();
            
            // Calculate totals for this order
            $order->product_revenue = $order->items->sum(function($item) {
                return $item->final_price * $item->quantity;
            });
            
            $order->actual_price = $order->items->sum(function($item) {
                return $item->product_price * $item->quantity;
            });
            
            $order->profit = $order->product_revenue - $order->actual_price;
            $order->shipping_charge = $order->shipping_charge ?? 0;
            $order->total_with_shipping = $order->product_revenue + $order->shipping_charge;
        }
        
        // ==========================================
        // TOTAL STATISTICS
        // ==========================================
        
        // Total Orders Count
        $totalOrdersCount = Order::count();
        
        // Total Product Revenue (from order_items final_price × quantity)
        $totalProductRevenue = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'SUCCESS')
            ->sum(DB::raw('order_items.final_price * order_items.quantity')) ?? 0;
        
        // Total Actual Price (from products.price or product_variants.price × quantity)
        $totalActualPrice = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('product_variants', 'order_items.variant_id', '=', 'product_variants.id')
            ->where('orders.payment_status', 'SUCCESS')
            ->sum(DB::raw('COALESCE(products.price, product_variants.price, order_items.price) * order_items.quantity')) ?? 0;
        
        // Total Profit
        $totalProfit = $totalProductRevenue - $totalActualPrice;
        
        // Total Shipping
        $totalShipping = Order::where('payment_status', 'SUCCESS')->sum('shipping_charge') ?? 0;
        
        // Total with Shipping
        $totalWithShipping = $totalProductRevenue + $totalShipping;
        
        // ==========================================
        // MONTHLY REVENUE DATA (for chart)
        // ==========================================
        $monthlyLabels = [];
        $monthlyRevenueData = [];
        $monthlyProfitData = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyLabels[] = $month->format('M Y');
            
            // Monthly Product Revenue
            $revenue = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('orders.payment_status', 'SUCCESS')
                ->whereYear('orders.created_at', $month->year)
                ->whereMonth('orders.created_at', $month->month)
                ->sum(DB::raw('order_items.final_price * order_items.quantity')) ?? 0;
            
            $monthlyRevenueData[] = $revenue;
            
            // Monthly Actual Price
            $actualPrice = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
                ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
                ->leftJoin('product_variants', 'order_items.variant_id', '=', 'product_variants.id')
                ->where('orders.payment_status', 'SUCCESS')
                ->whereYear('orders.created_at', $month->year)
                ->whereMonth('orders.created_at', $month->month)
                ->sum(DB::raw('COALESCE(products.price, product_variants.price, order_items.price) * order_items.quantity')) ?? 0;
            
            // Monthly Profit
            $monthlyProfitData[] = $revenue - $actualPrice;
        }
        
        // ==========================================
        // STATUS COUNTS
        // ==========================================
        $statusCounts = [
            'Pending' => Order::where('order_status', 'Pending')->count(),
            'Confirmed' => Order::where('order_status', 'Confirmed')->count(),
            'Shipped' => Order::where('order_status', 'Shipped')->count(),
            'Delivered' => Order::where('order_status', 'Delivered')->count(),
            'Cancelled' => Order::where('order_status', 'Cancelled')->count(),
            'Failed' => Order::where('order_status', 'Failed')->count(),
        ];
        
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
            ->limit(10)
            ->get()
            ->map(function($item) {
                $product = Product::find($item->product_id);
                return (object) [
                    'name' => $product ? $product->name : 'Unknown',
                    'total_sold' => $item->total_sold,
                    'total_revenue' => $item->total_revenue
                ];
            });
        
        return view('admin.reports.orders', compact(
            'orders',
            'totalOrdersCount',
            'totalProductRevenue',
            'totalActualPrice',
            'totalProfit',
            'totalShipping',
            'totalWithShipping',
            'monthlyLabels',
            'monthlyRevenueData',
            'monthlyProfitData',
            'statusCounts',
            'topProducts',
            'filterType',
            'startDate',
            'endDate',
            'status'
        ));
    }
    
    public function export(Request $request)
    {
        return redirect()->back()->with('success', 'Export feature coming soon!');
    }
}