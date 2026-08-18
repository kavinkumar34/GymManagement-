<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ReturnExchange;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReturnExchangeController extends Controller
{
    /**
     * ============================================================
     * CHECK RETURN / EXCHANGE ELIGIBILITY
     * ============================================================
     */
    public function checkEligibility($orderId)
    {
        try {
            $order = Order::with([
                'items.product'
            ])->findOrFail($orderId);

            // User ownership check
            if ($order->user_id != Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            // Only delivered orders are eligible
            if ($order->order_status != 'Delivered') {
                return response()->json([
                    'success' => false,
                    'message' => 'Return/Exchange only for delivered orders.'
                ]);
            }

            $deliveredAt = $order->order_date ?? $order->created_at;

            $daysSinceDelivery = \Carbon\Carbon::parse($deliveredAt)
                ->diffInDays(now(), true);
            /*
             * Only active requests block another request.
             *
             * New flow:
             * pending
             * processing
             * completed
             *
             * completed is intentionally NOT included here because
             * the frontend will hide the Return/Exchange button
             * after completion.
             */
        
            $items = [];
            $isEligible = false;

         foreach ($order->items as $item) {

    $returnDays =
        $item->product->return_days ?? 30;


    // Check completed request for THIS item
    $hasCompletedRequest =
        ReturnExchange::where(
            'order_item_id',
            $item->id
        )
        ->where('status', 'completed')
        ->exists();


    // Check active request for THIS item
    $hasItemActiveRequest =
        ReturnExchange::where(
            'order_item_id',
            $item->id
        )
        ->whereIn('status', [
            'pending',
            'processing'
        ])
        ->exists();


    // Eligibility is PER ITEM
    $itemEligible =
        $daysSinceDelivery <= $returnDays
        && !$hasCompletedRequest
        && !$hasItemActiveRequest;


    $items[] = [
        'id' => $item->id,
        'product_id' => $item->product_id,
        'product_name' => $item->product_name,
        'quantity' => $item->quantity,
        'price' => $item->price,

        'size' =>
            $item->variant_id
                ? $item->size
                : null,

        'color' =>
            $item->variant_id
                ? $item->color
                : null,

        'variant_id' =>
            $item->variant_id,

        'has_variant' =>
            !empty($item->variant_id),

        'return_days' =>
            $returnDays,

        'days_since_delivery' =>
            $daysSinceDelivery,

        'is_eligible' =>
            $itemEligible,

        'has_request' =>
            $hasItemActiveRequest,

        'has_completed_request' =>
            $hasCompletedRequest
    ];
}
            /*
             * Only show the Return/Exchange option if at least
             * one individual item is eligible.
             */
            $finalEligible = false;

            foreach ($items as $item) {
                if ($item['is_eligible']) {
                    $finalEligible = true;
                    break;
                }
            }

            return response()->json([
                'success' => true,

                'order_id' => $orderId,

                'is_eligible' => $finalEligible,

                'days_since_delivery' => $daysSinceDelivery,

                'items' => $items,

           'message' => $finalEligible
    ? 'You can request return/exchange'
    : 'No eligible products available for return/exchange'
            ]);
        } catch (\Exception $e) {

            Log::error(
                'Return eligibility check error: ' .
                    $e->getMessage()
            );

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * ============================================================
     * STORE RETURN / EXCHANGE REQUEST
     * ============================================================
     */
  public function store(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | BASIC VALIDATION
    |--------------------------------------------------------------------------
    */

    $request->validate([
        'order_id' => 'required|exists:orders,id',
        'order_item_id' => 'required|exists:order_items,id',
        'request_type' => 'required|in:return,exchange',
        'reason' => 'required|string|max:255',
        'comment' => 'nullable|string',
        'return_quantity' => 'nullable|integer|min:1|max:1',

        'exchange_product_id' =>
            'nullable|exists:products,id',

        'exchange_size' =>
            'nullable|string|max:50',
    ]);


    /*
    |--------------------------------------------------------------------------
    | FIND ORDER
    |--------------------------------------------------------------------------
    */

    $order = Order::findOrFail($request->order_id);

    $orderItem = OrderItem::with('product')
        ->findOrFail($request->order_item_id);


    /*
    |--------------------------------------------------------------------------
    | SECURITY
    |--------------------------------------------------------------------------
    */

    if ($order->user_id != Auth::id()) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 403);
    }


    if ($orderItem->order_id != $order->id) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid order item selected.'
        ], 422);
    }


    /*
    |--------------------------------------------------------------------------
    | ORDER STATUS
    |--------------------------------------------------------------------------
    */

    if ($order->order_status != 'Delivered') {
        return response()->json([
            'success' => false,
            'message' =>
                'Only delivered orders can be returned/exchanged.'
        ], 422);
    }


    /*
    |--------------------------------------------------------------------------
    | RETURN PERIOD
    |--------------------------------------------------------------------------
    */

    $returnDays =
        $orderItem->product->return_days ?? 30;

    $deliveredAt =
        $order->order_date ?? $order->created_at;

    if (now()->diffInDays($deliveredAt) > $returnDays) {
        return response()->json([
            'success' => false,
            'message' =>
                "Return period expired. You can return within {$returnDays} days."
        ], 422);
    }


    /*
    |--------------------------------------------------------------------------
    | EXISTING ACTIVE REQUEST
    |--------------------------------------------------------------------------
    */

    $existing = ReturnExchange::where(
        'order_id',
        $request->order_id
    )
        ->where(
            'order_item_id',
            $request->order_item_id
        )
        ->whereIn('status', [
            'pending',
            'processing'
        ])
        ->exists();


    if ($existing) {
        return response()->json([
            'success' => false,
            'message' =>
                'Request already exists for this product.'
        ], 422);
    }


    /*
    |--------------------------------------------------------------------------
    | COMPLETED REQUEST
    |--------------------------------------------------------------------------
    */

    $completedRequest = ReturnExchange::where(
        'order_id',
        $request->order_id
    )
        ->where(
            'order_item_id',
            $request->order_item_id
        )
        ->where('status', 'completed')
        ->exists();


    if ($completedRequest) {
        return response()->json([
            'success' => false,
            'message' =>
                'Return/Exchange has already been completed for this product.'
        ], 422);
    }


    /*
    |--------------------------------------------------------------------------
    | DETERMINE WHETHER PURCHASED PRODUCT IS VARIANT BASED
    |--------------------------------------------------------------------------
    */

    $isVariantProduct =
        !empty($orderItem->variant_id);


    /*
    |--------------------------------------------------------------------------
    | RETURN VALIDATION
    |--------------------------------------------------------------------------
    */

    if ($request->request_type === 'return') {

        $request->validate([
            'bank_name' =>
                'required|string|max:255',

            'account_number' =>
                'required|string|max:100',

            'ifsc_code' =>
                'required|string|max:50',
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | EXCHANGE
    |--------------------------------------------------------------------------
    */

    $exchangeVariant = null;
    $exchangeProduct = null;


    if ($request->request_type === 'exchange') {

        /*
        |--------------------------------------------------------------------------
        | NORMAL PRODUCT
        |--------------------------------------------------------------------------
        |
        | Normal product does NOT require:
        | - size
        | - variant
        |
        */

        if (!$isVariantProduct) {

            /*
            | If no exchange product was supplied from frontend,
            | use the purchased product.
            */

            $exchangeProductId =
                $request->exchange_product_id
                ?: $orderItem->product_id;

            $exchangeProduct =
                Product::find($exchangeProductId);

            if (!$exchangeProduct) {
                return response()->json([
                    'success' => false,
                    'message' =>
                        'Exchange product not found.'
                ], 422);
            }

        }

        /*
        |--------------------------------------------------------------------------
        | VARIANT PRODUCT
        |--------------------------------------------------------------------------
        */

        else {

            $request->validate([
                'exchange_product_id' =>
                    'required|exists:products,id',

                'exchange_size' =>
                    'required|string|max:50',
            ]);


            $exchangeProduct =
                Product::find(
                    $request->exchange_product_id
                );


            if (!$exchangeProduct) {
                return response()->json([
                    'success' => false,
                    'message' =>
                        'Exchange product not found.'
                ], 422);
            }


            /*
            |--------------------------------------------------------------------------
            | FIND AVAILABLE EXCHANGE VARIANT
            |--------------------------------------------------------------------------
            */

            $exchangeVariant =
                ProductVariant::where(
                    'product_id',
                    $request->exchange_product_id
                )
                    ->where(
                        'size',
                        $request->exchange_size
                    )
                    ->where('stock', '>', 0)
                    ->first();


            if (!$exchangeVariant) {
                return response()->json([
                    'success' => false,
                    'message' =>
                        'Selected size is not available. Please select another available size.'
                ], 422);
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE REQUEST
    |--------------------------------------------------------------------------
    */

    try {

        DB::beginTransaction();


        $returnQuantity = 1;


        $refundAmount =
            ($orderItem->price ??
                $orderItem->final_price ??
                0)
            * $returnQuantity;


        /*
        |--------------------------------------------------------------------------
        | REQUEST DATA
        |--------------------------------------------------------------------------
        */

        $requestData = [

            'order_id' =>
                $request->order_id,

            'order_item_id' =>
                $request->order_item_id,

            'user_id' =>
                Auth::id(),

            'request_type' =>
                $request->request_type,

            'reason' =>
                $request->reason,

            'comment' =>
                $request->comment,

            'status' =>
                'pending',

            'refund_amount' =>
                $refundAmount,

            'return_quantity' =>
                $returnQuantity,

            'exchange_quantity' =>
                1,
        ];


        /*
        |--------------------------------------------------------------------------
        | RETURN DATA
        |--------------------------------------------------------------------------
        */

        if ($request->request_type === 'return') {

            $requestData['bank_name'] =
                trim($request->bank_name);

            $requestData['account_number'] =
                trim($request->account_number);

            $requestData['ifsc_code'] =
                strtoupper(
                    trim($request->ifsc_code)
                );
        }


        /*
        |--------------------------------------------------------------------------
        | EXCHANGE DATA
        |--------------------------------------------------------------------------
        */

        if ($request->request_type === 'exchange') {

            $requestData['exchange_product_id'] =
                $exchangeProduct->id;

            /*
            | Variant product
            */

            if ($isVariantProduct && $exchangeVariant) {

                $requestData['exchange_variant_id'] =
                    $exchangeVariant->id;

                $requestData['exchange_size'] =
                    $exchangeVariant->size;

                $requestData['exchange_color'] =
                    $exchangeVariant->color;

            }

            /*
            | Normal product
            |
            | No variant ID
            | No size
            | No color
            */

            else {

                $requestData['exchange_variant_id'] =
                    null;

                $requestData['exchange_size'] =
                    null;

                $requestData['exchange_color'] =
                    null;
            }

            $requestData['exchange_quantity'] = 1;
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE RETURN / EXCHANGE REQUEST
        |--------------------------------------------------------------------------
        */

        $returnExchange =
            ReturnExchange::create(
                $requestData
            );


        /*
        |--------------------------------------------------------------------------
        | UPDATE ORDER ITEM REQUEST STATUS
        |--------------------------------------------------------------------------
        */

        $orderItem->return_status = 'pending';

        $orderItem->save();


        DB::commit();


        return response()->json([
            'success' => true,

            'message' =>
                $request->request_type === 'return'
                    ? 'Return request submitted successfully!'
                    : 'Exchange request submitted successfully!',

            'request_id' =>
                $returnExchange->id,

            'status' =>
                'pending'
        ]);


    } catch (\Exception $e) {

        DB::rollBack();


        Log::error(
            'Return/Exchange store error: ' .
            $e->getMessage(),
            [
                'order_id' =>
                    $request->order_id,

                'order_item_id' =>
                    $request->order_item_id,

                'user_id' =>
                    Auth::id(),

                'request_type' =>
                    $request->request_type
            ]
        );


        return response()->json([
            'success' => false,
            'message' =>
                'Error: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * ============================================================
 * COMPLETE RETURN / EXCHANGE REQUEST
 * ============================================================
 */
public function complete($id)
{
    try {

        DB::beginTransaction();

        /*
        |--------------------------------------------------------------------------
        | FIND REQUEST
        |--------------------------------------------------------------------------
        */

        $returnExchange = ReturnExchange::lockForUpdate()
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | ALREADY COMPLETED
        |--------------------------------------------------------------------------
        */

        if ($returnExchange->status === 'completed') {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'This request is already completed.'
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | ONLY EXCHANGE REQUEST
        |--------------------------------------------------------------------------
        */

        if ($returnExchange->request_type !== 'exchange') {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'This request is not an exchange request.'
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | FIND ORDER ITEM
        |--------------------------------------------------------------------------
        */

        $orderItem = OrderItem::lockForUpdate()
            ->findOrFail($returnExchange->order_item_id);


        /*
        |--------------------------------------------------------------------------
        | CHECK PURCHASED VARIANT
        |--------------------------------------------------------------------------
        */

        $purchasedVariant = null;

        if ($orderItem->variant_id) {

            $purchasedVariant = ProductVariant::lockForUpdate()
                ->find($orderItem->variant_id);
        }


        /*
        |--------------------------------------------------------------------------
        | CHECK EXCHANGE VARIANT
        |--------------------------------------------------------------------------
        */

        $exchangeVariant = null;

        if ($returnExchange->exchange_variant_id) {

            $exchangeVariant = ProductVariant::lockForUpdate()
                ->find($returnExchange->exchange_variant_id);
        }


        /*
        |--------------------------------------------------------------------------
        | VARIANT EXCHANGE STOCK UPDATE
        |--------------------------------------------------------------------------
        */

        if ($purchasedVariant && $exchangeVariant) {

            /*
            |--------------------------------------------------------------------------
            | IMPORTANT:
            | Do not add stock to the exchange variant before completion.
            |
            | At completion:
            |
            | Purchased L -> +1
            | Exchange M  -> -1
            |--------------------------------------------------------------------------
            */

            // Returned purchased size
            $purchasedVariant->stock =
                $purchasedVariant->stock + 1;

            $purchasedVariant->save();


            // Given exchange size
            if ($exchangeVariant->stock <= 0) {

                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' =>
                        'Exchange size is no longer available.'
                ], 422);
            }

            $exchangeVariant->stock =
                $exchangeVariant->stock - 1;

            $exchangeVariant->save();
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE REQUEST STATUS
        |--------------------------------------------------------------------------
        */

        $returnExchange->status = 'completed';

        $returnExchange->save();


        /*
        |--------------------------------------------------------------------------
        | UPDATE ORDER ITEM
        |--------------------------------------------------------------------------
        |
        | Keep the original order item linked to the original purchase.
        | We only update its return/exchange status here.
        |
        */

        $orderItem->return_status = 'completed';

        $orderItem->save();


        /*
        |--------------------------------------------------------------------------
        | COMMIT
        |--------------------------------------------------------------------------
        */

        DB::commit();


        return response()->json([
            'success' => true,
            'message' =>
                'Exchange completed successfully.'
        ]);


    } catch (\Exception $e) {

        DB::rollBack();

        Log::error(
            'Return/Exchange completion error: ' .
            $e->getMessage(),
            [
                'return_exchange_id' => $id
            ]
        );


        return response()->json([
            'success' => false,
            'message' =>
                'Error completing exchange: ' .
                $e->getMessage()
        ], 500);
    }
}
}
