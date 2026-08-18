<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReturnExchange;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminReturnExchangeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = ReturnExchange::with([
            'order',
            'orderItem',
            'orderItem.product',
            'user',
            'exchangeProduct',
            'exchangeVariant'
        ]);

        if ($request->status) {
            $query->where(
                'status',
                $request->status
            );
        }

        if ($request->request_type) {
            $query->where(
                'request_type',
                $request->request_type
            );
        }

        if ($request->search) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->whereHas('order', function ($oq) use ($search) {

                    $oq->where(
                        'order_number',
                        'LIKE',
                        "%{$search}%"
                    );

                })->orWhereHas('user', function ($uq) use ($search) {

                    $uq->where(
                        'name',
                        'LIKE',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'email',
                        'LIKE',
                        "%{$search}%"
                    );

                });

            });
        }

        $requests = $query
            ->orderBy('created_at', 'desc')
            ->paginate(15);


        /*
        |--------------------------------------------------------------------------
        | TOTAL REFUND
        |--------------------------------------------------------------------------
        */

        foreach ($requests as $req) {

            $req->total_refund =
                ($req->refund_amount ?? 0)
                + ($req->order->shipping_charge ?? 0);
        }


        /*
        |--------------------------------------------------------------------------
        | ONLY THREE STATUSES
        |--------------------------------------------------------------------------
        */

        $counts = [

            'total' =>
                ReturnExchange::count(),

            'pending' =>
                ReturnExchange::where(
                    'status',
                    'pending'
                )->count(),

            'processing' =>
                ReturnExchange::where(
                    'status',
                    'processing'
                )->count(),

            'completed' =>
                ReturnExchange::where(
                    'status',
                    'completed'
                )->count(),
        ];


        return view(
            'admin.returns.index',
            compact(
                'requests',
                'counts'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GET DETAILS
    |--------------------------------------------------------------------------
    */

    public function getDetails($id)
    {
        try {

            $returnRequest =
                ReturnExchange::with([
                    'order',
                    'orderItem',
                    'orderItem.product',
                    'user',
                    'exchangeProduct',
                    'exchangeVariant'
                ])->findOrFail($id);


            $requestData =
                $returnRequest->toArray();


            $requestData['request_type_label'] =
                $returnRequest->request_type_label;


            $requestData['status_label'] =
                $returnRequest->status_label;


            $requestData['total_refund'] =
                ($returnRequest->refund_amount ?? 0)
                + ($returnRequest->order->shipping_charge ?? 0);


            $requestData['product_name'] =
                $returnRequest->orderItem->product_name
                ?? 'N/A';


            return response()->json([
                'success' => true,
                'request' => $requestData
            ]);


        } catch (\Exception $e) {

            Log::error(
                'Return details error: '
                . $e->getMessage()
            );


            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE SINGLE REQUEST STATUS
    |--------------------------------------------------------------------------
    */

    public function updateStatus(
        Request $request,
        $id
    ) {

        $request->validate([

            'status' =>
                'required|in:pending,processing,completed',

            'admin_comment' =>
                'nullable|string',

            'refund_amount' =>
                'nullable|numeric|min:0',
        ]);


        $returnRequest =
            ReturnExchange::findOrFail($id);


        try {

            DB::beginTransaction();


            /*
            |--------------------------------------------------------------------------
            | OLD / NEW STATUS
            |--------------------------------------------------------------------------
            */

            $oldStatus =
                $returnRequest->status;

            $newStatus =
                $request->status;


            /*
            |--------------------------------------------------------------------------
            | UPDATE REQUEST STATUS
            |--------------------------------------------------------------------------
            */

            $returnRequest->status =
                $newStatus;


            if ($request->filled('admin_comment')) {

                $returnRequest->admin_comment =
                    $request->admin_comment;
            }


            if ($request->filled('refund_amount')) {

                $returnRequest->refund_amount =
                    $request->refund_amount;
            }


            /*
            |--------------------------------------------------------------------------
            | PROCESSED DATE
            |--------------------------------------------------------------------------
            */

            if ($newStatus === 'completed') {

                $returnRequest->processed_at =
                    now();
            }


            $returnRequest->save();


            /*
            |--------------------------------------------------------------------------
            | UPDATE ORDER ITEM STATUS
            |--------------------------------------------------------------------------
            */

            if ($returnRequest->order_item_id) {

                $orderItem =
                    OrderItem::find(
                        $returnRequest->order_item_id
                    );


                if ($orderItem) {

                    $orderItem->return_status =
                        $newStatus;

                    $orderItem->save();
                }
            }


            /*
            |--------------------------------------------------------------------------
            | RETURN STOCK
            |--------------------------------------------------------------------------
            |
            | Return completed:
            |
            | Product stock + quantity
            | Variant stock + quantity
            |
            | Only execute once.
            |--------------------------------------------------------------------------
            */

            if (
                $newStatus === 'completed'
                && $oldStatus !== 'completed'
                && $returnRequest->request_type === 'return'
            ) {

                $orderItem =
                    OrderItem::find(
                        $returnRequest->order_item_id
                    );


                if ($orderItem) {

                    $quantity =
                        $returnRequest->return_quantity
                        ?? $orderItem->quantity
                        ?? 1;


                    /*
                    |--------------------------------------------------------------------------
                    | PRODUCT STOCK
                    |--------------------------------------------------------------------------
                    */

                    $product =
                        Product::find(
                            $orderItem->product_id
                        );


                    if ($product) {

                        $product->increment(
                            'stock',
                            $quantity
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | VARIANT STOCK
                    |--------------------------------------------------------------------------
                    */

                    if ($orderItem->variant_id) {

                        $variant =
                            ProductVariant::find(
                                $orderItem->variant_id
                            );


                        if ($variant) {

                            $variant->increment(
                                'stock',
                                $quantity
                            );
                        }
                    }
                }
            }


            /*
            |--------------------------------------------------------------------------
            | EXCHANGE STOCK
            |--------------------------------------------------------------------------
            |
            | Example:
            |
            | Purchased:
            | L = 5
            |
            | Exchange:
            | M = 10
            |
            | When Admin completes:
            |
            | L = 6
            | M = 9
            |
            | IMPORTANT:
            | This runs only once when status changes to completed.
            |--------------------------------------------------------------------------
            */

            if (
                $newStatus === 'completed'
                && $oldStatus !== 'completed'
                && $returnRequest->request_type === 'exchange'
            ) {

                $orderItem =
                    OrderItem::find(
                        $returnRequest->order_item_id
                    );


                if (!$orderItem) {

                    throw new \Exception(
                        'Order item not found for exchange.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | EXCHANGE QUANTITY
                |--------------------------------------------------------------------------
                */

                $quantity =
                    $returnRequest->exchange_quantity
                    ?? 1;


                /*
                |--------------------------------------------------------------------------
                | RETURN PURCHASED VARIANT
                |--------------------------------------------------------------------------
                |
                | Customer originally purchased L.
                |
                | L stock +1
                |--------------------------------------------------------------------------
                */

                if ($orderItem->variant_id) {

                    $purchasedVariant =
                        ProductVariant::lockForUpdate()
                            ->find(
                                $orderItem->variant_id
                            );


                    if (!$purchasedVariant) {

                        throw new \Exception(
                            'Purchased variant not found.'
                        );
                    }


                    $purchasedVariant->increment(
                        'stock',
                        $quantity
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | REDUCE EXCHANGE VARIANT
                |--------------------------------------------------------------------------
                |
                | Customer requested M.
                |
                | M stock -1
                |--------------------------------------------------------------------------
                */

                if ($returnRequest->exchange_variant_id) {

                    $exchangeVariant =
                        ProductVariant::lockForUpdate()
                            ->find(
                                $returnRequest->exchange_variant_id
                            );


                    if (!$exchangeVariant) {

                        throw new \Exception(
                            'Exchange variant not found.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | CHECK EXCHANGE STOCK
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $exchangeVariant->stock
                        < $quantity
                    ) {

                        throw new \Exception(
                            'Exchange variant stock is no longer available.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | REDUCE EXCHANGE STOCK
                    |--------------------------------------------------------------------------
                    */

                    $exchangeVariant->decrement(
                        'stock',
                        $quantity
                    );
                }
            }


            /*
            |--------------------------------------------------------------------------
            | COMMIT
            |--------------------------------------------------------------------------
            */

            DB::commit();


            return response()->json([

                'success' => true,

                'message' =>
                    'Status updated successfully!'
            ]);


        } catch (\Exception $e) {

            DB::rollBack();


            Log::error(
                'Return/Exchange status update error: '
                . $e->getMessage(),
                [
                    'return_exchange_id' =>
                        $id,

                    'request_type' =>
                        $returnRequest->request_type ?? null,

                    'old_status' =>
                        $oldStatus ?? null,

                    'new_status' =>
                        $newStatus ?? null,
                ]
            );


            return response()->json([

                'success' => false,

                'message' =>
                    'Error: '
                    . $e->getMessage()

            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | BULK UPDATE
    |--------------------------------------------------------------------------
    */

    public function bulkUpdate(Request $request)
    {

        $request->validate([

            'ids' =>
                'required|array',

            'ids.*' =>
                'exists:return_exchange_requests,id',

            'status' =>
                'required|in:pending,processing,completed',
        ]);


        try {

            DB::beginTransaction();


            foreach ($request->ids as $id) {

                $returnRequest =
                    ReturnExchange::find($id);


                if (!$returnRequest) {
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | OLD / NEW STATUS
                |--------------------------------------------------------------------------
                */

                $oldStatus =
                    $returnRequest->status;

                $newStatus =
                    $request->status;


                /*
                |--------------------------------------------------------------------------
                | UPDATE STATUS
                |--------------------------------------------------------------------------
                */

                $returnRequest->status =
                    $newStatus;


                if ($newStatus === 'completed') {

                    $returnRequest->processed_at =
                        now();
                }


                $returnRequest->save();


                /*
                |--------------------------------------------------------------------------
                | UPDATE ORDER ITEM
                |--------------------------------------------------------------------------
                */

                if ($returnRequest->order_item_id) {

                    $orderItem =
                        OrderItem::find(
                            $returnRequest->order_item_id
                        );


                    if ($orderItem) {

                        $orderItem->return_status =
                            $newStatus;

                        $orderItem->save();
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | RETURN STOCK
                |--------------------------------------------------------------------------
                */

                if (
                    $newStatus === 'completed'
                    && $oldStatus !== 'completed'
                    && $returnRequest->request_type === 'return'
                ) {

                    $orderItem =
                        OrderItem::find(
                            $returnRequest->order_item_id
                        );


                    if ($orderItem) {

                        $quantity =
                            $returnRequest->return_quantity
                            ?? $orderItem->quantity
                            ?? 1;


                        /*
                        |--------------------------------------------------------------------------
                        | PRODUCT STOCK
                        |--------------------------------------------------------------------------
                        */

                        $product =
                            Product::find(
                                $orderItem->product_id
                            );


                        if ($product) {

                            $product->increment(
                                'stock',
                                $quantity
                            );
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | VARIANT STOCK
                        |--------------------------------------------------------------------------
                        */

                        if ($orderItem->variant_id) {

                            $variant =
                                ProductVariant::find(
                                    $orderItem->variant_id
                                );


                            if ($variant) {

                                $variant->increment(
                                    'stock',
                                    $quantity
                                );
                            }
                        }
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | EXCHANGE STOCK
                |--------------------------------------------------------------------------
                |
                | Purchased L = +1
                | Exchange M  = -1
                |
                |--------------------------------------------------------------------------
                */

                if (
                    $newStatus === 'completed'
                    && $oldStatus !== 'completed'
                    && $returnRequest->request_type === 'exchange'
                ) {

                    $orderItem =
                        OrderItem::find(
                            $returnRequest->order_item_id
                        );


                    if (!$orderItem) {

                        throw new \Exception(
                            'Order item not found for exchange request ID '
                            . $returnRequest->id
                        );
                    }


                    $quantity =
                        $returnRequest->exchange_quantity
                        ?? 1;


                    /*
                    |--------------------------------------------------------------------------
                    | RETURN PURCHASED VARIANT
                    |--------------------------------------------------------------------------
                    */

                    if ($orderItem->variant_id) {

                        $purchasedVariant =
                            ProductVariant::lockForUpdate()
                                ->find(
                                    $orderItem->variant_id
                                );


                        if (!$purchasedVariant) {

                            throw new \Exception(
                                'Purchased variant not found for exchange request ID '
                                . $returnRequest->id
                            );
                        }


                        $purchasedVariant->increment(
                            'stock',
                            $quantity
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | REDUCE EXCHANGE VARIANT
                    |--------------------------------------------------------------------------
                    */

                    if ($returnRequest->exchange_variant_id) {

                        $exchangeVariant =
                            ProductVariant::lockForUpdate()
                                ->find(
                                    $returnRequest->exchange_variant_id
                                );


                        if (!$exchangeVariant) {

                            throw new \Exception(
                                'Exchange variant not found for exchange request ID '
                                . $returnRequest->id
                            );
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | CHECK STOCK
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $exchangeVariant->stock
                            < $quantity
                        ) {

                            throw new \Exception(
                                'Exchange variant stock is no longer available for request ID '
                                . $returnRequest->id
                            );
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | REDUCE STOCK
                        |--------------------------------------------------------------------------
                        */

                        $exchangeVariant->decrement(
                            'stock',
                            $quantity
                        );
                    }
                }
            }


            /*
            |--------------------------------------------------------------------------
            | COMMIT
            |--------------------------------------------------------------------------
            */

            DB::commit();


            return response()->json([

                'success' => true,

                'message' =>
                    count($request->ids)
                    . ' requests updated!'
            ]);


        } catch (\Exception $e) {

            DB::rollBack();


            Log::error(
                'Bulk return/exchange status update error: '
                . $e->getMessage()
            );


            return response()->json([

                'success' => false,

                'message' =>
                    'Error: '
                    . $e->getMessage()

            ], 500);
        }
    }
}