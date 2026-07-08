<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'offers';

    protected $fillable = [
        'offer_code',
        'offer_name',
        'offer_type',
        'combo_type',
        'discount_type',
        'discount_value',
        'max_discount_amount',
        'min_order_amount',
        'applicable_products',
        'usage_limit_per_user',
        'usage_limit_total',
        'usage_count',
        'start_date',
        'end_date',
        'status',
        'created_by',
    ];

    protected $casts = [
        'applicable_products' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'usage_limit_per_user' => 'integer',
        'usage_limit_total' => 'integer',
        'usage_count' => 'integer',
        'discount_value' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
    ];

    /**
     * Get applicable products as array - FIXED
     */
    public function getApplicableProductsAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }
        if (is_array($value)) {
            return $value;
        }
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    }

    /**
     * Set applicable products - FIXED
     */
/**
 * Set applicable products.
 */
public function setApplicableProductsAttribute($value)
{
    if (is_array($value)) {
        $this->attributes['applicable_products'] = json_encode(array_values($value));
    } elseif (is_string($value)) {
        $this->attributes['applicable_products'] = $value;
    } else {
        $this->attributes['applicable_products'] = null;
    }
}

    /**
     * Get offer type label.
     */
    public function getTypeLabel()
    {
        $types = [
            'combo' => 'Combo Offer',
            'bogo' => 'BOGO Offer',
            'flash_sale' => 'Flash Sale',
            'seasonal' => 'Seasonal Offer',
        ];
        return $types[$this->offer_type] ?? ucfirst($this->offer_type);
    }

    /**
     * Get combo type label.
     */
    public function getComboTypeLabel()
    {
        $types = [
            'single_product' => 'Single Product',
            'multiple_products' => 'Multiple Products',
            'price_based' => 'Price-Based Offers',
        ];
        return $types[$this->combo_type] ?? ucfirst($this->combo_type);
    }

    /**
     * Get formatted discount text.
     */
    public function getDiscountText()
    {
        if ($this->discount_type === 'percentage') {
            return $this->discount_value . '% OFF';
        } elseif ($this->discount_type === 'fixed') {
            return '₹' . number_format($this->discount_value, 2) . ' OFF';
        }
        return 'Discount';
    }

    /**
     * Check if the offer is active and valid.
     */
    public function isValid()
    {
        if ($this->status !== 'active') {
            return false;
        }

        $now = now();
        if ($now < $this->start_date || $now > $this->end_date) {
            return false;
        }

        if ($this->usage_limit_total && $this->usage_count >= $this->usage_limit_total) {
            return false;
        }

        return true;
    }

    /**
     * Calculate discount amount for a given price.
     */
    public function calculateDiscount($price)
    {
        if (!$this->isValid()) {
            return 0;
        }

        $discount = 0;

        if ($this->discount_type === 'percentage') {
            $discount = ($price * $this->discount_value) / 100;
        } elseif ($this->discount_type === 'fixed') {
            $discount = $this->discount_value;
        }

        if ($this->max_discount_amount && $discount > $this->max_discount_amount) {
            $discount = $this->max_discount_amount;
        }

        return min($discount, $price);
    }

    /**
     * Get product names as HTML list - FIXED
     */
    public function getProductNamesHtml()
    {
        // Get products as array - ensure it's always an array
        $products = $this->applicable_products;
        
        // If products is null or empty, return default message
        if (empty($products) || !is_array($products)) {
            return '<span class="text-muted">No products</span>';
        }

        $names = [];
        foreach ($products as $productId) {
            $product = Product::find($productId);
            if ($product) {
                $names[] = $product->name . ' (₹' . number_format($product->price, 2) . ')';
            }
        }

        if (empty($names)) {
            return '<span class="text-muted">Products not found</span>';
        }

        $html = '<ul class="mb-0 ps-3" style="font-size:12px;">';
        foreach ($names as $name) {
            $html .= '<li>' . htmlspecialchars($name) . '</li>';
        }
        $html .= '</ul>';
        return $html;
    }

    /**
     * Increment usage count.
     */
    public function incrementUsage()
    {
        $this->increment('usage_count');
    }
}