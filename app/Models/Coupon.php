<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'name',
        'type',
        'value',
        'min_order_amount',
        'max_discount',
        'usage_limit',
        'used_count',
        'per_user_limit',
        'start_date',
        'end_date',
        'is_active'
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean'
    ];

    /**
     * Check if coupon is valid
     */
    public function isValid()
    {
        if (!$this->is_active) {
            return ['valid' => false, 'message' => 'Coupon is inactive'];
        }

        $now = Carbon::now();

        if ($this->start_date && $now->lt($this->start_date)) {
            return ['valid' => false, 'message' => 'Coupon not yet started'];
        }

        if ($this->end_date && $now->gt($this->end_date)) {
            return ['valid' => false, 'message' => 'Coupon has expired'];
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return ['valid' => false, 'message' => 'Coupon usage limit reached'];
        }

        return ['valid' => true, 'message' => 'Valid coupon'];
    }

    /**
     * Apply discount to amount
     */
    public function applyDiscount($amount)
    {
        if (!$this->isValid()['valid']) {
            return 0;
        }

        if ($this->min_order_amount && $amount < $this->min_order_amount) {
            return 0;
        }

        $discount = 0;

        if ($this->type === 'percentage') {
            $discount = ($amount * $this->value) / 100;
            if ($this->max_discount && $discount > $this->max_discount) {
                $discount = $this->max_discount;
            }
        } else {
            // Fixed amount
            $discount = $this->value;
            if ($discount > $amount) {
                $discount = $amount;
            }
        }

        return $discount;
    }

    /**
     * Increment usage count
     */
    public function incrementUsage()
    {
        $this->increment('used_count');
    }
}