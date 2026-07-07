<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    public function validateCoupon(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|string',
                'subtotal' => 'required|numeric|min:0'
            ]);

            $code = strtoupper($request->code);
            $coupon = Coupon::where('code', $code)->first();

            if (!$coupon) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid coupon code'
                ]);
            }

            // Check if coupon is valid
            $validity = $coupon->isValid();
            if (!$validity['valid']) {
                return response()->json([
                    'success' => false,
                    'message' => $validity['message']
                ]);
            }

            // Check if user has already used this coupon (Per User Limit)
            if (Auth::check()) {
                $userId = Auth::id();
                
                // Check in coupon_usage table
                $usedCount = DB::table('coupon_usage')
                    ->where('coupon_id', $coupon->id)
                    ->where('user_id', $userId)
                    ->count();
                
                if ($usedCount >= $coupon->per_user_limit) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You have already used this coupon'
                    ]);
                }
            }

            // Check minimum order amount
            $subtotal = $request->subtotal;
            if ($coupon->min_order_amount && $subtotal < $coupon->min_order_amount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Minimum order amount of ₹' . number_format($coupon->min_order_amount, 2) . ' required'
                ]);
            }

            // Calculate discount
            $discount = $coupon->applyDiscount($subtotal);

            return response()->json([
                'success' => true,
                'coupon' => [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                    'name' => $coupon->name,
                    'type' => $coupon->type,
                    'value' => $coupon->value
                ],
                'discount' => $discount
            ]);
            
        } catch (\Exception $e) {
            Log::error('Coupon validation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Record coupon usage after successful order
     */
    public function recordCouponUsage($couponId, $userId, $orderId, $discountAmount)
    {
        try {
            DB::table('coupon_usage')->insert([
                'coupon_id' => $couponId,
                'user_id' => $userId,
                'order_id' => $orderId,
                'discount_amount' => $discountAmount,
                'used_at' => now()
            ]);

            // Increment used count in coupons table
            Coupon::where('id', $couponId)->increment('used_count');
            
            Log::info('Coupon usage recorded: coupon_id=' . $couponId . ', user_id=' . $userId . ', order_id=' . $orderId);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to record coupon usage: ' . $e->getMessage());
            return false;
        }
    }
}