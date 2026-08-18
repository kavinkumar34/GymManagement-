<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Contact;
use App\Models\OrderItem;
use App\Models\ReturnExchange;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // =========================================================
        // TOTAL ORDERS
        // Cancelled orders excluded
        // =========================================================

        $totalOrders = Order::where(
            'order_status',
            '!=',
            'Cancelled'
        )->count();


        // =========================================================
        // TOTAL PRODUCTS
        // =========================================================

        $totalProducts = Product::count();


        // =========================================================
        // TOTAL MEMBERS / USERS
        // =========================================================

        $totalMembers = User::count();


        // =========================================================
        // PENDING ORDERS
        // =========================================================

        $pendingOrders = Order::where(
            'order_status',
            'Pending'
        )->count();


        // =========================================================
        // GET ALL VALID ORDERS FOR REVENUE
        //
        // SAME LOGIC AS orders.blade.php
        //
        // Product Revenue:
        // final_price × billable quantity
        //
        // billable quantity:
        // ordered quantity - completed returned quantity
        //
        // SHIPPING IS NOT INCLUDED
        // =========================================================

        $revenueOrders = Order::with('items')
            ->where('payment_status', 'SUCCESS')
            ->where('order_status', '!=', 'Cancelled')
            ->get();


        // =========================================================
        // TOTAL REVENUE
        // EXACTLY SAME AS ORDERS PAGE PRODUCT REVENUE
        // =========================================================

        $totalRevenue = 0;

        foreach ($revenueOrders as $order) {

            $orderItemIds = $order->items
                ->pluck('id')
                ->toArray();

            $completedReturnQuantities = [];

            if (!empty($orderItemIds)) {

                $completedReturnQuantities =
                    ReturnExchange::whereIn(
                        'order_item_id',
                        $orderItemIds
                    )
                    ->where(
                        'request_type',
                        'return'
                    )
                    ->where(
                        'status',
                        'completed'
                    )
                    ->select(
                        'order_item_id',
                        DB::raw(
                            'SUM(COALESCE(return_quantity, 1)) as returned_quantity'
                        )
                    )
                    ->groupBy(
                        'order_item_id'
                    )
                    ->pluck(
                        'returned_quantity',
                        'order_item_id'
                    )
                    ->toArray();
            }


            $orderProductRevenue = $order->items->sum(
                function ($item) use ($completedReturnQuantities) {

                    $orderedQuantity =
                        (int) ($item->quantity ?? 0);

                    $returnedQuantity =
                        (int) (
                            $completedReturnQuantities[
                                $item->id
                            ] ?? 0
                        );

                    $billableQuantity = max(
                        0,
                        $orderedQuantity - $returnedQuantity
                    );

                    return
                        (float) ($item->final_price ?? 0)
                        * $billableQuantity;
                }
            );


            $totalRevenue += $orderProductRevenue;
        }


        // =========================================================
        // REVENUE THIS MONTH
        //
        // EXACTLY SAME PRODUCT REVENUE CALCULATION
        // Only current month orders
        // =========================================================

        $monthlyRevenueOrders = Order::with('items')
            ->where('payment_status', 'SUCCESS')
            ->where('order_status', '!=', 'Cancelled')
            ->whereMonth(
                'created_at',
                now()->month
            )
            ->whereYear(
                'created_at',
                now()->year
            )
            ->get();


        $monthlyRevenue = 0;

        foreach ($monthlyRevenueOrders as $order) {

            $orderItemIds = $order->items
                ->pluck('id')
                ->toArray();

            $completedReturnQuantities = [];

            if (!empty($orderItemIds)) {

                $completedReturnQuantities =
                    ReturnExchange::whereIn(
                        'order_item_id',
                        $orderItemIds
                    )
                    ->where(
                        'request_type',
                        'return'
                    )
                    ->where(
                        'status',
                        'completed'
                    )
                    ->select(
                        'order_item_id',
                        DB::raw(
                            'SUM(COALESCE(return_quantity, 1)) as returned_quantity'
                        )
                    )
                    ->groupBy(
                        'order_item_id'
                    )
                    ->pluck(
                        'returned_quantity',
                        'order_item_id'
                    )
                    ->toArray();
            }


            $orderProductRevenue = $order->items->sum(
                function ($item) use ($completedReturnQuantities) {

                    $orderedQuantity =
                        (int) ($item->quantity ?? 0);

                    $returnedQuantity =
                        (int) (
                            $completedReturnQuantities[
                                $item->id
                            ] ?? 0
                        );

                    $billableQuantity = max(
                        0,
                        $orderedQuantity - $returnedQuantity
                    );

                    return
                        (float) ($item->final_price ?? 0)
                        * $billableQuantity;
                }
            );


            $monthlyRevenue += $orderProductRevenue;
        }


        // =========================================================
        // MONTHLY PRODUCT REVENUE
        // For chart
        //
        // SAME PRODUCT REVENUE LOGIC
        // =========================================================

        $monthlyLabels = [];

        $monthlyRevenueData = [];


        for ($i = 11; $i >= 0; $i--) {

            $month = now()->copy()->subMonths($i);

            $monthlyLabels[] =
                $month->format('M');


            $monthOrders = Order::with('items')
                ->where('payment_status', 'SUCCESS')
                ->where('order_status', '!=', 'Cancelled')
                ->whereYear(
                    'created_at',
                    $month->year
                )
                ->whereMonth(
                    'created_at',
                    $month->month
                )
                ->get();


            $monthRevenue = 0;


            foreach ($monthOrders as $order) {

                $orderItemIds = $order->items
                    ->pluck('id')
                    ->toArray();

                $completedReturnQuantities = [];

                if (!empty($orderItemIds)) {

                    $completedReturnQuantities =
                        ReturnExchange::whereIn(
                            'order_item_id',
                            $orderItemIds
                        )
                        ->where(
                            'request_type',
                            'return'
                        )
                        ->where(
                            'status',
                            'completed'
                        )
                        ->select(
                            'order_item_id',
                            DB::raw(
                                'SUM(COALESCE(return_quantity, 1)) as returned_quantity'
                            )
                        )
                        ->groupBy(
                            'order_item_id'
                        )
                        ->pluck(
                            'returned_quantity',
                            'order_item_id'
                        )
                        ->toArray();
                }


                $monthRevenue += $order->items->sum(
                    function ($item) use ($completedReturnQuantities) {

                        $orderedQuantity =
                            (int) ($item->quantity ?? 0);

                        $returnedQuantity =
                            (int) (
                                $completedReturnQuantities[
                                    $item->id
                                ] ?? 0
                            );

                        $billableQuantity = max(
                            0,
                            $orderedQuantity - $returnedQuantity
                        );

                        return
                            (float) ($item->final_price ?? 0)
                            * $billableQuantity;
                    }
                );
            }


            $monthlyRevenueData[] =
                round($monthRevenue, 2);
        }


        // =========================================================
        // MONTHLY SHIPPING TOTAL
        // Keep separately if other dashboard code needs it
        // =========================================================

        $monthlyShippingTotal = Order::where(
            'payment_status',
            'SUCCESS'
        )
            ->where(
                'order_status',
                '!=',
                'Cancelled'
            )
            ->whereMonth(
                'created_at',
                now()->month
            )
            ->whereYear(
                'created_at',
                now()->year
            )
            ->sum('shipping_charge') ?? 0;


        // =========================================================
        // MONTHLY PRODUCT REVENUE
        // Separate variable if existing dashboard uses it
        // =========================================================

        $monthlyProductRevenue =
            $monthlyRevenue;


        // =========================================================
        // RECENT ORDERS
        // =========================================================

        $recentOrders = Order::with('user')
            ->where(
                'order_status',
                '!=',
                'Cancelled'
            )
            ->orderBy(
                'created_at',
                'desc'
            )
            ->limit(5)
            ->get();


        // =========================================================
        // RECENT MEMBERS
        // =========================================================

        $recentMembers = User::orderBy(
            'created_at',
            'desc'
        )
            ->limit(5)
            ->get();


        // =========================================================
        // RECENT CONTACT MESSAGES
        // =========================================================

        $recentMessages = Contact::orderBy(
            'created_at',
            'desc'
        )
            ->limit(5)
            ->get();


        // =========================================================
        // TOP SELLING PRODUCTS
        // =========================================================

        $topProducts = OrderItem::select(
                'product_id',
                DB::raw(
                    'SUM(quantity) as total_sold'
                ),
                DB::raw(
                    'SUM(final_price * quantity) as total_revenue'
                )
            )
            ->join(
                'orders',
                'order_items.order_id',
                '=',
                'orders.id'
            )
            ->where(
                'orders.payment_status',
                'SUCCESS'
            )
            ->where(
                'orders.order_status',
                '!=',
                'Cancelled'
            )
            ->groupBy(
                'product_id'
            )
            ->orderBy(
                'total_sold',
                'desc'
            )
            ->limit(5)
            ->get()
            ->map(function ($item) {

                $product =
                    Product::find(
                        $item->product_id
                    );

                return (object) [

                    'name' =>
                        $product
                            ? $product->name
                            : 'Unknown',

                    'total_sold' =>
                        $item->total_sold,

                    'total_revenue' =>
                        $item->total_revenue
                ];
            });


        // =========================================================
        // ORDER STATUS DISTRIBUTION
        // =========================================================

        $statusLabels = [
            'Pending',
            'Confirmed',
            'Shipped',
            'Delivered',
            'Cancelled',
            'Failed'
        ];

        $statusData = [

            Order::where(
                'order_status',
                'Pending'
            )->count(),

            Order::where(
                'order_status',
                'Confirmed'
            )->count(),

            Order::where(
                'order_status',
                'Shipped'
            )->count(),

            Order::where(
                'order_status',
                'Delivered'
            )->count(),

            Order::where(
                'order_status',
                'Cancelled'
            )->count(),

            Order::where(
                'order_status',
                'Failed'
            )->count()
        ];


        // =========================================================
        // ORDERS GROWTH
        // =========================================================

        $lastMonthOrders = Order::where(
            'order_status',
            '!=',
            'Cancelled'
        )
            ->whereMonth(
                'created_at',
                now()->subMonth()->month
            )
            ->whereYear(
                'created_at',
                now()->subMonth()->year
            )
            ->count();


        $ordersGrowth =
            $lastMonthOrders > 0
                ? round(
                    (
                        ($totalOrders - $lastMonthOrders)
                        / $lastMonthOrders
                    ) * 100,
                    1
                )
                : 0;


        // =========================================================
        // REVENUE GROWTH
        //
        // IMPORTANT:
        // Same Product Revenue calculation
        // No shipping
        // =========================================================

        $lastMonthRevenueOrders = Order::with('items')
            ->where(
                'payment_status',
                'SUCCESS'
            )
            ->where(
                'order_status',
                '!=',
                'Cancelled'
            )
            ->whereMonth(
                'created_at',
                now()->subMonth()->month
            )
            ->whereYear(
                'created_at',
                now()->subMonth()->year
            )
            ->get();


        $lastMonthRevenue = 0;


        foreach ($lastMonthRevenueOrders as $order) {

            $orderItemIds = $order->items
                ->pluck('id')
                ->toArray();

            $completedReturnQuantities = [];

            if (!empty($orderItemIds)) {

                $completedReturnQuantities =
                    ReturnExchange::whereIn(
                        'order_item_id',
                        $orderItemIds
                    )
                    ->where(
                        'request_type',
                        'return'
                    )
                    ->where(
                        'status',
                        'completed'
                    )
                    ->select(
                        'order_item_id',
                        DB::raw(
                            'SUM(COALESCE(return_quantity, 1)) as returned_quantity'
                        )
                    )
                    ->groupBy(
                        'order_item_id'
                    )
                    ->pluck(
                        'returned_quantity',
                        'order_item_id'
                    )
                    ->toArray();
            }


            $lastMonthRevenue += $order->items->sum(
                function ($item) use ($completedReturnQuantities) {

                    $orderedQuantity =
                        (int) ($item->quantity ?? 0);

                    $returnedQuantity =
                        (int) (
                            $completedReturnQuantities[
                                $item->id
                            ] ?? 0
                        );

                    $billableQuantity = max(
                        0,
                        $orderedQuantity - $returnedQuantity
                    );

                    return
                        (float) ($item->final_price ?? 0)
                        * $billableQuantity;
                }
            );
        }


        $revenueGrowth =
            $lastMonthRevenue > 0
                ? round(
                    (
                        ($totalRevenue - $lastMonthRevenue)
                        / $lastMonthRevenue
                    ) * 100,
                    1
                )
                : 0;


        // =========================================================
        // PRODUCTS GROWTH
        // =========================================================

        $lastMonthProducts = Product::whereMonth(
            'created_at',
            now()->subMonth()->month
        )
            ->whereYear(
                'created_at',
                now()->subMonth()->year
            )
            ->count();


        $productsGrowth =
            $lastMonthProducts > 0
                ? round(
                    (
                        ($totalProducts - $lastMonthProducts)
                        / $lastMonthProducts
                    ) * 100,
                    1
                )
                : 0;


        // =========================================================
        // MEMBERS GROWTH
        // =========================================================

        $lastMonthMembers = User::whereMonth(
            'created_at',
            now()->subMonth()->month
        )
            ->whereYear(
                'created_at',
                now()->subMonth()->year
            )
            ->count();


        $membersGrowth =
            $lastMonthMembers > 0
                ? round(
                    (
                        ($totalMembers - $lastMonthMembers)
                        / $lastMonthMembers
                    ) * 100,
                    1
                )
                : 0;


        // =========================================================
        // REVENUE BREAKDOWN
        // =========================================================

        $revenueByOrder = $monthlyRevenueOrders->map(
            function ($order) {

                $orderItemIds = $order->items
                    ->pluck('id')
                    ->toArray();

                $completedReturnQuantities = [];

                if (!empty($orderItemIds)) {

                    $completedReturnQuantities =
                        ReturnExchange::whereIn(
                            'order_item_id',
                            $orderItemIds
                        )
                        ->where(
                            'request_type',
                            'return'
                        )
                        ->where(
                            'status',
                            'completed'
                        )
                        ->select(
                            'order_item_id',
                            DB::raw(
                                'SUM(COALESCE(return_quantity, 1)) as returned_quantity'
                            )
                        )
                        ->groupBy(
                            'order_item_id'
                        )
                        ->pluck(
                            'returned_quantity',
                            'order_item_id'
                        )
                        ->toArray();
                }


                $productRevenue = $order->items->sum(
                    function ($item) use ($completedReturnQuantities) {

                        $orderedQuantity =
                            (int) ($item->quantity ?? 0);

                        $returnedQuantity =
                            (int) (
                                $completedReturnQuantities[
                                    $item->id
                                ] ?? 0
                            );

                        $billableQuantity = max(
                            0,
                            $orderedQuantity - $returnedQuantity
                        );

                        return
                            (float) ($item->final_price ?? 0)
                            * $billableQuantity;
                    }
                );


                return (object) [

                    'order_id' =>
                        $order->id,

                    'order_number' =>
                        $order->order_number,

                    'total_amount' =>
                        $order->total_amount,

                    'shipping_charge' =>
                        $order->shipping_charge ?? 0,

                    'product_revenue' =>
                        $productRevenue,

                    'total_revenue' =>
                        $productRevenue,

                    'items' =>
                        $order->items
                ];
            }
        );


        // =========================================================
        // MONTHLY REVENUE DETAILS
        // =========================================================

        $monthlyRevenueDetails = collect();


        // =========================================================
        // RETURN VIEW
        // =========================================================

        return view(
            'admin.dashboard',
            compact(

                'totalOrders',
                'totalRevenue',

                'totalProducts',
                'totalMembers',
                'pendingOrders',

                'monthlyRevenue',
                'monthlyProductRevenue',
                'monthlyShippingTotal',

                'recentOrders',
                'recentMembers',
                'recentMessages',

                'topProducts',

                'monthlyLabels',
                'monthlyRevenueData',

                'statusLabels',
                'statusData',

                'ordersGrowth',
                'revenueGrowth',
                'productsGrowth',
                'membersGrowth',

                'revenueByOrder',
                'monthlyRevenueDetails'
            )
        );
    }
}