<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use App\Models\ReturnExchange;
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

        // Build query for orders - Exclude cancelled from revenue calculations
        $ordersQuery = Order::with('user');

        // Apply filters
        if ($startDate && $endDate) {
            $ordersQuery->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($filterType == 'daily') {
            $ordersQuery->whereDate('created_at', today());
        } elseif ($filterType == 'weekly') {
            $ordersQuery->whereBetween(
                'created_at',
                [now()->startOfWeek(), now()->endOfWeek()]
            );
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
        $orders = $ordersQuery
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // ==========================================
        // CALCULATE FOR EACH ORDER
        // ==========================================
        foreach ($orders as $order) {

            // Get order items with product and variant details
            $order->items = OrderItem::where(
                    'order_id',
                    $order->id
                )
                ->leftJoin(
                    'products',
                    'order_items.product_id',
                    '=',
                    'products.id'
                )
                ->leftJoin(
                    'product_variants',
                    'order_items.variant_id',
                    '=',
                    'product_variants.id'
                )
                ->select(
                    'order_items.*',
                    'products.price as product_price',
                    'product_variants.price as variant_price',
                    'product_variants.cost_price as variant_cost_price',
                    DB::raw('
                        COALESCE(products.price, order_items.price, 0)
                        as base_actual_price_per_unit
                    ')
                )
                ->get();

            // IMPORTANT:
            // Variant products must use product_variants.cost_price.
            // Resolve the variant directly by order_items.variant_id
            // instead of depending on the SQL join for the report value.
            foreach ($order->items as $item) {
                if (!empty($item->variant_id)) {
                    $variant = ProductVariant::find($item->variant_id);

                    $item->actual_price_per_unit = $variant
                        ? (float) $variant->cost_price
                        : (float) ($item->base_actual_price_per_unit ?? $item->price ?? 0);
                } else {
                    $item->actual_price_per_unit =
                        (float) ($item->base_actual_price_per_unit ?? $item->price ?? 0);
                }
            }

            // ==========================================
            // GET COMPLETED RETURN QUANTITY
            // ==========================================
            $orderItemIds = $order->items->pluck('id')->toArray();

            $completedReturnQuantities = [];

            if (!empty($orderItemIds)) {

                $completedReturnQuantities = ReturnExchange::whereIn(
                        'order_item_id',
                        $orderItemIds
                    )
                    ->where('request_type', 'return')
                    ->where('status', 'completed')
                    ->select(
                        'order_item_id',
                        DB::raw(
                            'SUM(COALESCE(return_quantity, 1)) as returned_quantity'
                        )
                    )
                    ->groupBy('order_item_id')
                    ->pluck(
                        'returned_quantity',
                        'order_item_id'
                    )
                    ->toArray();
            }

            // ==========================================
// RETURN LABEL FOR ITEMS COLUMN
// ==========================================

foreach ($order->items as $item) {
    $returnedQuantity = (int) (
        $completedReturnQuantities[$item->id] ?? 0
    );

    $item->report_product_name = $item->product_name;

    if ($returnedQuantity > 0) {
        $item->report_product_name .= ' - Return';
    }
}

            // ==========================================
            // CALCULATE TOTALS FOR THIS ORDER
            // COMPLETED RETURN QUANTITY IS EXCLUDED
            // ==========================================

            $order->product_revenue = $order->items->sum(
                function ($item) use ($completedReturnQuantities) {

                    $orderedQuantity = (int) $item->quantity;

                    $returnedQuantity = (int) (
                        $completedReturnQuantities[$item->id] ?? 0
                    );

                    // Never allow negative quantity
                    $billableQuantity = max(
                        0,
                        $orderedQuantity - $returnedQuantity
                    );

                    return $item->final_price * $billableQuantity;
                }
            );

            $order->actual_price = $order->items->sum(
                function ($item) use ($completedReturnQuantities) {

                    $orderedQuantity = (int) $item->quantity;

                    $returnedQuantity = (int) (
                        $completedReturnQuantities[$item->id] ?? 0
                    );

                    // Never allow negative quantity
                    $billableQuantity = max(
                        0,
                        $orderedQuantity - $returnedQuantity
                    );

                    return $item->actual_price_per_unit
                        * $billableQuantity;
                }
            );

            $order->profit =
                $order->product_revenue -
                $order->actual_price;

          // ==========================================
// SHIPPING
// FULL ORDER RETURN COMPLETED = NO SHIPPING
// ==========================================

$totalOrderedQuantity = $order->items->sum(function ($item) {
    return (int) $item->quantity;
});

$totalReturnedQuantity = $order->items->sum(function ($item) use ($completedReturnQuantities) {
    return (int) ($completedReturnQuantities[$item->id] ?? 0);
});

// If the complete order has been returned and completed,
// shipping charge should also become 0.
// ==========================================
// SHIPPING
// Keep original shipping for display
// ==========================================

$originalShippingCharge = (float) ($order->shipping_charge ?? 0);

$order->report_shipping_charge = $originalShippingCharge;

// Existing calculation logic
if (
    $totalOrderedQuantity > 0 &&
    $totalReturnedQuantity >= $totalOrderedQuantity
) {
    $order->shipping_charge = 0;
} else {
    $order->shipping_charge = $originalShippingCharge;
}

$order->total_with_shipping =
    $order->product_revenue +
    $order->shipping_charge;
        }

        // ==========================================
        // TOTAL STATISTICS (EXCLUDING CANCELLED)
        // ==========================================

        // Total Orders Count (excluding cancelled)
        $totalOrdersCount = Order::where(
            'order_status',
            '!=',
            'Cancelled'
        )->count();

        // ==========================================
        // TOTAL PRODUCT REVENUE
        // EXCLUDE COMPLETED RETURN QUANTITY
        // ==========================================

        $totalProductRevenue = OrderItem::join(
                'orders',
                'order_items.order_id',
                '=',
                'orders.id'
            )
            ->leftJoin(
                DB::raw('(
                    SELECT
                        order_item_id,
                        SUM(COALESCE(return_quantity, 1))
                            AS returned_quantity
                    FROM return_exchange_requests
                    WHERE request_type = "return"
                      AND status = "completed"
                    GROUP BY order_item_id
                ) as completed_returns'),
                'completed_returns.order_item_id',
                '=',
                'order_items.id'
            )
            ->where(
                'orders.order_status',
                '!=',
                'Cancelled'
            )
            ->where(
                'orders.payment_status',
                'SUCCESS'
            )
            ->select(
                DB::raw('
                    SUM(
                        order_items.final_price *
                        GREATEST(
                            order_items.quantity -
                            COALESCE(
                                completed_returns.returned_quantity,
                                0
                            ),
                            0
                        )
                    ) as total_revenue
                ')
            )
            ->first()
            ->total_revenue ?? 0;

        // ==========================================
        // TOTAL ACTUAL PRICE
        // EXCLUDE COMPLETED RETURN QUANTITY
        // ==========================================

        $totalActualPrice = OrderItem::join(
                'orders',
                'order_items.order_id',
                '=',
                'orders.id'
            )
            ->leftJoin(
                'products',
                'order_items.product_id',
                '=',
                'products.id'
            )
            ->leftJoin(
                'product_variants',
                'order_items.variant_id',
                '=',
                'product_variants.id'
            )
            ->leftJoin(
                DB::raw('(
                    SELECT
                        order_item_id,
                        SUM(COALESCE(return_quantity, 1))
                            AS returned_quantity
                    FROM return_exchange_requests
                    WHERE request_type = "return"
                      AND status = "completed"
                    GROUP BY order_item_id
                ) as completed_returns'),
                'completed_returns.order_item_id',
                '=',
                'order_items.id'
            )
            ->where(
                'orders.order_status',
                '!=',
                'Cancelled'
            )
            ->where(
                'orders.payment_status',
                'SUCCESS'
            )
            ->select(
                DB::raw('
                    SUM(
                        (
                            CASE
                                WHEN product_variants.id IS NOT NULL
                                    THEN COALESCE(product_variants.cost_price, 0)
                                ELSE COALESCE(products.price, order_items.price, 0)
                            END
                        )
                        *
                        GREATEST(
                            order_items.quantity -
                            COALESCE(
                                completed_returns.returned_quantity,
                                0
                            ),
                            0
                        )
                    ) as total_actual_price
                ')
            )
            ->first()
            ->total_actual_price ?? 0;

        // ==========================================
        // TOTAL PROFIT
        // ==========================================

        $totalProfit =
            $totalProductRevenue -
            $totalActualPrice;

        // ==========================================
        // TOTAL SHIPPING (excluding cancelled)
        // ==========================================

     // ==========================================
// TOTAL SHIPPING
// FULLY RETURNED + COMPLETED ORDERS
// ARE EXCLUDED
// ==========================================

$fullyReturnedOrderIds = DB::table('order_items')
    ->join(
        'return_exchange_requests',
        'return_exchange_requests.order_item_id',
        '=',
        'order_items.id'
    )
    ->where(
        'return_exchange_requests.request_type',
        'return'
    )
    ->where(
        'return_exchange_requests.status',
        'completed'
    )
    ->groupBy('order_items.order_id')
    ->havingRaw(
        'SUM(COALESCE(return_exchange_requests.return_quantity, 1)) >= SUM(order_items.quantity)'
    )
    ->pluck('order_items.order_id')
    ->toArray();

$totalShippingQuery = Order::where(
        'order_status',
        '!=',
        'Cancelled'
    )
    ->where(
        'payment_status',
        'SUCCESS'
    );

if (!empty($fullyReturnedOrderIds)) {
    $totalShippingQuery->whereNotIn(
        'id',
        $fullyReturnedOrderIds
    );
}

$totalShipping =
    $totalShippingQuery->sum('shipping_charge') ?? 0;

        // ==========================================
        // TOTAL WITH SHIPPING
        // ==========================================

        $totalWithShipping =
            $totalProfit +
            $totalShipping;

        // ==========================================
        // MONTHLY REVENUE DATA
        // EXCLUDING CANCELLED + COMPLETED RETURNS
        // ==========================================

        $monthlyLabels = [];
        $monthlyRevenueData = [];
        $monthlyProfitData = [];

        for ($i = 11; $i >= 0; $i--) {

            $month = now()->subMonths($i);

            $monthlyLabels[] =
                $month->format('M Y');

            // ==========================================
            // MONTHLY PRODUCT REVENUE
            // ==========================================

            $revenue = OrderItem::join(
                    'orders',
                    'order_items.order_id',
                    '=',
                    'orders.id'
                )
                ->leftJoin(
                    DB::raw('(
                        SELECT
                            order_item_id,
                            SUM(COALESCE(return_quantity, 1))
                                AS returned_quantity
                        FROM return_exchange_requests
                        WHERE request_type = "return"
                          AND status = "completed"
                        GROUP BY order_item_id
                    ) as completed_returns'),
                    'completed_returns.order_item_id',
                    '=',
                    'order_items.id'
                )
                ->where(
                    'orders.order_status',
                    '!=',
                    'Cancelled'
                )
                ->where(
                    'orders.payment_status',
                    'SUCCESS'
                )
                ->whereYear(
                    'orders.created_at',
                    $month->year
                )
                ->whereMonth(
                    'orders.created_at',
                    $month->month
                )
                ->select(
                    DB::raw('
                        SUM(
                            order_items.final_price *
                            GREATEST(
                                order_items.quantity -
                                COALESCE(
                                    completed_returns.returned_quantity,
                                    0
                                ),
                                0
                            )
                        ) as total_revenue
                    ')
                )
                ->first()
                ->total_revenue ?? 0;

            $monthlyRevenueData[] =
                $revenue;

            // ==========================================
            // MONTHLY ACTUAL PRICE
            // ==========================================

            $actualPrice = OrderItem::join(
                    'orders',
                    'order_items.order_id',
                    '=',
                    'orders.id'
                )
                ->leftJoin(
                    'products',
                    'order_items.product_id',
                    '=',
                    'products.id'
                )
                ->leftJoin(
                    'product_variants',
                    'order_items.variant_id',
                    '=',
                    'product_variants.id'
                )
                ->leftJoin(
                    DB::raw('(
                        SELECT
                            order_item_id,
                            SUM(COALESCE(return_quantity, 1))
                                AS returned_quantity
                        FROM return_exchange_requests
                        WHERE request_type = "return"
                          AND status = "completed"
                        GROUP BY order_item_id
                    ) as completed_returns'),
                    'completed_returns.order_item_id',
                    '=',
                    'order_items.id'
                )
                ->where(
                    'orders.order_status',
                    '!=',
                    'Cancelled'
                )
                ->where(
                    'orders.payment_status',
                    'SUCCESS'
                )
                ->whereYear(
                    'orders.created_at',
                    $month->year
                )
                ->whereMonth(
                    'orders.created_at',
                    $month->month
                )
                ->select(
                    DB::raw('
                        SUM(
                            (
                                CASE
                                    WHEN product_variants.id IS NOT NULL
                                        THEN COALESCE(product_variants.cost_price, 0)
                                    ELSE COALESCE(products.price, order_items.price, 0)
                                END
                            )
                            *
                            GREATEST(
                                order_items.quantity -
                                COALESCE(
                                    completed_returns.returned_quantity,
                                    0
                                ),
                                0
                            )
                        ) as total_actual_price
                    ')
                )
                ->first()
                ->total_actual_price ?? 0;

            // ==========================================
            // MONTHLY PROFIT
            // ==========================================

            $monthlyProfitData[] =
                $revenue -
                $actualPrice;
        }

        // ==========================================
        // STATUS COUNTS
        // INCLUDING CANCELLED SEPARATELY
        // ==========================================

        $statusCounts = [
            'Pending' => Order::where(
                'order_status',
                'Pending'
            )->count(),

            'Confirmed' => Order::where(
                'order_status',
                'Confirmed'
            )->count(),

            'Shipped' => Order::where(
                'order_status',
                'Shipped'
            )->count(),

            'Delivered' => Order::where(
                'order_status',
                'Delivered'
            )->count(),

            'Cancelled' => Order::where(
                'order_status',
                'Cancelled'
            )->count(),

            'Failed' => Order::where(
                'order_status',
                'Failed'
            )->count(),
        ];

        // ==========================================
        // TOP SELLING PRODUCTS
        // EXCLUDE COMPLETED RETURN QUANTITY
        // ==========================================

        $topProducts = OrderItem::select(
                'order_items.product_id',
                DB::raw('
                    SUM(
                        GREATEST(
                            order_items.quantity -
                            COALESCE(
                                completed_returns.returned_quantity,
                                0
                            ),
                            0
                        )
                    ) as total_sold
                '),
                DB::raw('
                    SUM(
                        order_items.final_price *
                        GREATEST(
                            order_items.quantity -
                            COALESCE(
                                completed_returns.returned_quantity,
                                0
                            ),
                            0
                        )
                    ) as total_revenue
                ')
            )
            ->join(
                'orders',
                'order_items.order_id',
                '=',
                'orders.id'
            )
            ->leftJoin(
                DB::raw('(
                    SELECT
                        order_item_id,
                        SUM(COALESCE(return_quantity, 1))
                            AS returned_quantity
                    FROM return_exchange_requests
                    WHERE request_type = "return"
                      AND status = "completed"
                    GROUP BY order_item_id
                ) as completed_returns'),
                'completed_returns.order_item_id',
                '=',
                'order_items.id'
            )
            ->where(
                'orders.order_status',
                '!=',
                'Cancelled'
            )
            ->where(
                'orders.payment_status',
                'SUCCESS'
            )
            ->groupBy(
                'order_items.product_id'
            )
            ->orderBy(
                'total_sold',
                'desc'
            )
            ->limit(10)
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
                        $item->total_revenue,
                ];
            });

        // ==========================================
        // RETURN REPORT DATA
        // ==========================================

        return view(
            'admin.reports.orders',
            compact(
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
            )
        );
    }

    /**
     * Export Orders Report to CSV
     */
    public function export(Request $request)
    {
        // Get filter values
        $filterType = $request->get(
            'filter_type',
            'monthly'
        );

        $startDate =
            $request->get('start_date');

        $endDate =
            $request->get('end_date');

        $status =
            $request->get('status');

        // Build query for orders
        $ordersQuery =
            Order::with('user');

        // Apply filters
        if ($startDate && $endDate) {

            $ordersQuery->whereBetween(
                'created_at',
                [$startDate, $endDate]
            );

        } elseif ($filterType == 'daily') {

            $ordersQuery->whereDate(
                'created_at',
                today()
            );

        } elseif ($filterType == 'weekly') {

            $ordersQuery->whereBetween(
                'created_at',
                [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ]
            );

        } elseif ($filterType == 'monthly') {

            $ordersQuery
                ->whereMonth(
                    'created_at',
                    now()->month
                )
                ->whereYear(
                    'created_at',
                    now()->year
                );

        } elseif ($filterType == 'yearly') {

            $ordersQuery->whereYear(
                'created_at',
                now()->year
            );
        }

        if ($status) {

            $ordersQuery->where(
                'order_status',
                $status
            );
        }

        // Get all orders (no pagination)
        $orders = $ordersQuery
            ->orderBy(
                'created_at',
                'desc'
            )
            ->get();

        // ==========================================
        // CALCULATE FOR EACH ORDER
        // ==========================================

        foreach ($orders as $order) {

            $order->items = OrderItem::where(
                    'order_id',
                    $order->id
                )
                ->leftJoin(
                    'products',
                    'order_items.product_id',
                    '=',
                    'products.id'
                )
                ->leftJoin(
                    'product_variants',
                    'order_items.variant_id',
                    '=',
                    'product_variants.id'
                )
                ->select(
                    'order_items.*',
                    'products.price as product_price',
                    'product_variants.price as variant_price',
                    'product_variants.cost_price as variant_cost_price',
                    DB::raw('
                        COALESCE(products.price, order_items.price, 0)
                        as base_actual_price_per_unit
                    ')
                )
                ->get();

            // Resolve variant actual price directly from product_variants.
            foreach ($order->items as $item) {
                if (!empty($item->variant_id)) {
                    $variant = ProductVariant::find($item->variant_id);

                    $item->actual_price_per_unit = $variant
                        ? (float) $variant->cost_price
                        : (float) ($item->base_actual_price_per_unit ?? $item->price ?? 0);
                } else {
                    $item->actual_price_per_unit =
                        (float) ($item->base_actual_price_per_unit ?? $item->price ?? 0);
                }
            }

            // ==========================================
            // GET COMPLETED RETURN QUANTITY
            // ==========================================

            $orderItemIds =
                $order->items
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

            // ==========================================
            // PRODUCT REVENUE
            // ==========================================

            $order->product_revenue =
                $order->items->sum(
                    function ($item)
                    use ($completedReturnQuantities) {

                        $orderedQuantity =
                            (int) $item->quantity;

                        $returnedQuantity =
                            (int) (
                                $completedReturnQuantities[
                                    $item->id
                                ] ?? 0
                            );

                        $billableQuantity =
                            max(
                                0,
                                $orderedQuantity -
                                $returnedQuantity
                            );

                        return
                            $item->final_price *
                            $billableQuantity;
                    }
                );

            // ==========================================
            // ACTUAL PRICE
            // ==========================================

            $order->actual_price =
                $order->items->sum(
                    function ($item)
                    use ($completedReturnQuantities) {

                        $orderedQuantity =
                            (int) $item->quantity;

                        $returnedQuantity =
                            (int) (
                                $completedReturnQuantities[
                                    $item->id
                                ] ?? 0
                            );

                        $billableQuantity =
                            max(
                                0,
                                $orderedQuantity -
                                $returnedQuantity
                            );

                        return
                            $item->actual_price_per_unit *
                            $billableQuantity;
                    }
                );

            // ==========================================
            // PROFIT
            // ==========================================

            $order->profit =
                $order->product_revenue -
                $order->actual_price;

            // ==========================================
            // SHIPPING
            // ==========================================

           // ==========================================
// SHIPPING
// FULL ORDER RETURN COMPLETED = NO SHIPPING
// ==========================================

$totalOrderedQuantity = $order->items->sum(function ($item) {
    return (int) $item->quantity;
});

$totalReturnedQuantity = $order->items->sum(function ($item) use ($completedReturnQuantities) {
    return (int) ($completedReturnQuantities[$item->id] ?? 0);
});

// ==========================================
// SHIPPING
// Keep original shipping for display
// ==========================================

$originalShippingCharge = (float) ($order->shipping_charge ?? 0);

$order->report_shipping_charge = $originalShippingCharge;

// Existing calculation logic
if (
    $totalOrderedQuantity > 0 &&
    $totalReturnedQuantity >= $totalOrderedQuantity
) {
    $order->shipping_charge = 0;
} else {
    $order->shipping_charge = $originalShippingCharge;
}

            // ==========================================
            // TOTAL WITH SHIPPING
            // ==========================================

            $order->total_with_shipping =
                $order->product_revenue +
                $order->shipping_charge;

            // ==========================================
            // PREPARE ITEMS STRING
            // ==========================================

            $order->items_string =
                $order->items
                    ->map(function ($item) use ($completedReturnQuantities) {

                        $returnedQuantity = (int) (
                            $completedReturnQuantities[$item->id] ?? 0
                        );

                        $productName = $item->product_name ?? 'Product';

                        if ($returnedQuantity > 0) {
                            $productName .= ' - Return';
                        }

                        return
                            $productName .
                            ' (x' .
                            $item->quantity .
                            ')';

                    })
                    ->implode(', ');

            // Store the return status on the order itself so the
            // CSV streaming callback does not need the foreach-local
            // $completedReturnQuantities variable.
            $order->return_status =
                $order->items->contains(function ($item) use ($completedReturnQuantities) {
                    return (int) (
                        $completedReturnQuantities[$item->id] ?? 0
                    ) > 0;
                })
                    ? 'Return'
                    : '';

            // ==========================================
            // EXPORT VALUES - SAME AS ORDERS TABLE
            // ==========================================

            $displayActualPrice = (float) ($order->actual_price ?? 0);

            if ($displayActualPrice <= 0 && $order->items->count() > 0) {
                $displayActualPrice = 0;

                foreach ($order->items as $reportItem) {
                    $itemQuantity = (int) ($reportItem->quantity ?? 0);

                    if (!empty($reportItem->variant_id)) {
                        $unitActualPrice = (float) (
                            $reportItem->variant_cost_price ?? 0
                        );
                    } else {
                        $unitActualPrice = (float) (
                            $reportItem->product_price
                            ?? $reportItem->price
                            ?? 0
                        );
                    }

                    $displayActualPrice +=
                        $unitActualPrice * $itemQuantity;
                }
            }

            $order->export_product_revenue = (float) (
                $order->product_revenue ?? 0
            );

            $order->export_actual_price = $displayActualPrice;

            $order->export_profit =
                $order->export_product_revenue -
                $order->export_actual_price;

            $order->export_shipping = (float) (
                $order->report_shipping_charge
                ?? $order->shipping_charge
                ?? 0
            );

            $order->export_total =
                $order->export_product_revenue +
                $order->export_shipping;
        }

        // ==========================================
        // CREATE CSV CONTENT
        // ==========================================

        $filename =
            'orders_report_' .
            date('Y-m-d_H-i-s') .
            '.csv';

        $headers = [

            'Content-Type' =>
                'text/csv; charset=UTF-8',

            'Content-Disposition' =>
                'attachment; filename="' .
                $filename .
                '"',

            'Pragma' =>
                'no-cache',

            'Cache-Control' =>
                'must-revalidate, post-check=0, pre-check=0',

            'Expires' =>
                '0'
        ];

        $callback =
            function () use ($orders) {

                $handle =
                    fopen(
                        'php://output',
                        'w'
                    );

                // Add UTF-8 BOM for Excel compatibility
                fputs(
                    $handle,
                    "\xEF\xBB\xBF"
                );

                // ==========================================
                // CSV HEADERS
                // ==========================================

                fputcsv(
                    $handle,
                    [
                        'S.No',
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
                    ]
                );

                // ==========================================
                // CSV DATA
                // ==========================================

                foreach ($orders as $loopIndex => $order) {

                    // Format date as text
                    // to prevent Excel conversion
                    $dateFormatted = '';

                    if ($order->created_at) {

                        $dateFormatted =
                            '="' .
                            date(
                                'd-m-Y',
                                strtotime(
                                    $order->created_at
                                )
                            ) .
                            '"';
                    }

                    // Return status was calculated while preparing each
                    // order above. Do not reference the foreach-local
                    // $completedReturnQuantities here.
                    $returnStatus = $order->return_status ?? '';

                    fputcsv(
                        $handle,
                        [
                            $loopIndex + 1,

                            $order->order_number,

                            $order->user->name
                                ?? 'N/A',

                            $order->items_string,

                            number_format(
                                $order->export_product_revenue
                                    ?? 0,
                                2
                            ),

                            number_format(
                                $order->export_actual_price
                                    ?? 0,
                                2
                            ),

                            number_format(
                                $order->export_profit
                                    ?? 0,
                                2
                            ),

                            number_format(
                                $order->export_shipping
                                    ?? 0,
                                2
                            ),

                            number_format(
                                $order->export_total
                                    ?? 0,
                                2
                            ),

                            $order->order_status,

                            $dateFormatted
                        ]
                    );
                }

                fclose($handle);
            };

        return response()->streamDownload(
            $callback,
            $filename,
            [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]
        );
    }
}