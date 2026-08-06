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
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

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
                ->leftJoin('product_variants', function($join) {
                    $join->on('order_items.variant_id', '=', 'product_variants.id')
                         ->on('order_items.product_id', '=', 'product_variants.product_id');
                })
                ->select(
                    'order_items.*',
                    'products.price as product_price',
                    'product_variants.price as variant_price',
                    'product_variants.cost_price as variant_cost_price',
                    DB::raw('CASE 
                        WHEN order_items.variant_id IS NOT NULL AND product_variants.cost_price IS NOT NULL THEN product_variants.cost_price
                        WHEN order_items.variant_id IS NOT NULL AND product_variants.price IS NOT NULL THEN product_variants.price
                        WHEN products.price IS NOT NULL THEN products.price
                        ELSE order_items.price
                    END as actual_price_per_unit')
                )
                ->get();
            
            // Calculate totals for this order
            $order->product_revenue = $order->items->sum(function($item) {
                return $item->final_price * $item->quantity;
            });
            
            $order->actual_price = $order->items->sum(function($item) {
                return $item->actual_price_per_unit * $item->quantity;
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
        
        // Total Actual Price
        $totalActualPrice = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('product_variants', function($join) {
                $join->on('order_items.variant_id', '=', 'product_variants.id')
                     ->on('order_items.product_id', '=', 'product_variants.product_id');
            })
            ->where('orders.payment_status', 'SUCCESS')
            ->select(DB::raw('SUM(
                CASE 
                    WHEN order_items.variant_id IS NOT NULL AND product_variants.cost_price IS NOT NULL THEN product_variants.cost_price
                    WHEN order_items.variant_id IS NOT NULL AND product_variants.price IS NOT NULL THEN product_variants.price
                    WHEN products.price IS NOT NULL THEN products.price
                    ELSE order_items.price
                END * order_items.quantity
            ) as total_actual_price'))
            ->first()
            ->total_actual_price ?? 0;
        
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
                ->leftJoin('product_variants', function($join) {
                    $join->on('order_items.variant_id', '=', 'product_variants.id')
                         ->on('order_items.product_id', '=', 'product_variants.product_id');
                })
                ->where('orders.payment_status', 'SUCCESS')
                ->whereYear('orders.created_at', $month->year)
                ->whereMonth('orders.created_at', $month->month)
                ->select(DB::raw('SUM(
                    CASE 
                        WHEN order_items.variant_id IS NOT NULL AND product_variants.cost_price IS NOT NULL THEN product_variants.cost_price
                        WHEN order_items.variant_id IS NOT NULL AND product_variants.price IS NOT NULL THEN product_variants.price
                        WHEN products.price IS NOT NULL THEN products.price
                        ELSE order_items.price
                    END * order_items.quantity
                ) as total_actual_price'))
                ->first()
                ->total_actual_price ?? 0;
            
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
                'order_items.product_id',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.final_price * order_items.quantity) as total_revenue')
            )
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'SUCCESS')
            ->groupBy('order_items.product_id')
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
    
    /**
     * Export Orders Report to CSV
     */
    public function export(Request $request)
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
        
        // Get all orders (no pagination)
        $orders = $ordersQuery->orderBy('created_at', 'desc')->get();
        
        // Calculate for each order
        foreach ($orders as $order) {
            $order->items = OrderItem::where('order_id', $order->id)
                ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
                ->leftJoin('product_variants', function($join) {
                    $join->on('order_items.variant_id', '=', 'product_variants.id')
                         ->on('order_items.product_id', '=', 'product_variants.product_id');
                })
                ->select(
                    'order_items.*',
                    'products.price as product_price',
                    'product_variants.price as variant_price',
                    'product_variants.cost_price as variant_cost_price',
                    DB::raw('CASE 
                        WHEN order_items.variant_id IS NOT NULL AND product_variants.cost_price IS NOT NULL THEN product_variants.cost_price
                        WHEN order_items.variant_id IS NOT NULL AND product_variants.price IS NOT NULL THEN product_variants.price
                        WHEN products.price IS NOT NULL THEN products.price
                        ELSE order_items.price
                    END as actual_price_per_unit')
                )
                ->get();
            
            $order->product_revenue = $order->items->sum(function($item) {
                return $item->final_price * $item->quantity;
            });
            
            $order->actual_price = $order->items->sum(function($item) {
                return $item->actual_price_per_unit * $item->quantity;
            });
            
            $order->profit = $order->product_revenue - $order->actual_price;
            $order->shipping_charge = $order->shipping_charge ?? 0;
            $order->total_with_shipping = $order->product_revenue + $order->shipping_charge;
            
            // Prepare items string
            $order->items_string = $order->items->map(function($item) {
                return $item->product_name . ' (x' . $item->quantity . ')';
            })->implode(', ');
        }
        
        // Create CSV content
        $filename = 'orders_report_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($orders) {
            $handle = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fputs($handle, "\xEF\xBB\xBF");
            
            // Headers
            fputcsv($handle, [
                'Order #',
                'Customer',
                'Items',
                'Product Revenue',
                'Actual Price',
                'Profit',
                'Shipping',
                'Total',
                'Status',
                'Date'
            ]);
            
            // Data rows
            foreach ($orders as $order) {
                // Format date as text to prevent Excel from converting it
                $dateFormatted = '';
                if ($order->created_at) {
                    // Use TEXT format to ensure Excel displays it correctly
                    $dateFormatted = '="' . date('d-m-Y', strtotime($order->created_at)) . '"';
                }
                
                fputcsv($handle, [
                    $order->order_number,
                    $order->user->name ?? 'N/A',
                    $order->items_string,
                    number_format($order->product_revenue ?? 0, 2),
                    number_format($order->actual_price ?? 0, 2),
                    number_format($order->profit ?? 0, 2),
                    number_format($order->shipping_charge ?? 0, 2),
                    number_format($order->total_with_shipping ?? 0, 2),
                    $order->order_status,
                    $dateFormatted
                ]);
            }
            
            fclose($handle);
        };
        
        return Response::stream($callback, 200, $headers);
    }
}