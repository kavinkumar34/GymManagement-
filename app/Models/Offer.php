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
        'offer_description',
        'offer_type',
        'discount_type',
        'discount_value',
        'max_discount_amount',
        'min_order_amount',
        'buy_quantity',
        'get_quantity',
        'get_product_id',
        'get_category_id',
        'brand_id',
        'applicable_products',
        'applicable_categories',
        'applicable_brands',
        'excluded_products',
        'excluded_categories',
        'excluded_brands',
        'user_groups',
        'new_user_only',
        'first_order_only',
        'usage_limit_per_user',
        'usage_limit_total',
        'usage_count',
        'start_date',
        'end_date',
        'valid_days',
        'banner_image',
        'show_on_homepage',
        'priority',
        'status',
        'is_stackable',
        'auto_apply',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // FIX: Remove the casts that are converting to array automatically
    // This prevents the json_decode error

    /**
     * Get applicable products as array.
     */
    public function getApplicableProductsAttribute($value)
    {
        if (is_null($value)) return [];
        if (is_array($value)) return $value;
        return json_decode($value, true) ?? [];
    }

    /**
     * Get applicable categories as array.
     */
    public function getApplicableCategoriesAttribute($value)
    {
        if (is_null($value)) return [];
        if (is_array($value)) return $value;
        return json_decode($value, true) ?? [];
    }

    /**
     * Get applicable brands as array.
     */
    public function getApplicableBrandsAttribute($value)
    {
        if (is_null($value)) return [];
        if (is_array($value)) return $value;
        return json_decode($value, true) ?? [];
    }

    /**
     * Get excluded products as array.
     */
    public function getExcludedProductsAttribute($value)
    {
        if (is_null($value)) return [];
        if (is_array($value)) return $value;
        return json_decode($value, true) ?? [];
    }

    /**
     * Get excluded categories as array.
     */
    public function getExcludedCategoriesAttribute($value)
    {
        if (is_null($value)) return [];
        if (is_array($value)) return $value;
        return json_decode($value, true) ?? [];
    }

    /**
     * Get excluded brands as array.
     */
    public function getExcludedBrandsAttribute($value)
    {
        if (is_null($value)) return [];
        if (is_array($value)) return $value;
        return json_decode($value, true) ?? [];
    }

    /**
     * Get valid days as array.
     */
    public function getValidDaysAttribute($value)
    {
        if (is_null($value)) return [];
        if (is_array($value)) return $value;
        return json_decode($value, true) ?? [];
    }

    /**
     * Get the brand that belongs to this offer.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the products that belong to this offer.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'offer_products');
    }

    /**
     * Get the category that belongs to this offer.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'get_category_id');
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

        // Check valid days
        $validDays = $this->valid_days;
        if (!empty($validDays)) {
            $currentDay = $now->format('D');
            if (!in_array($currentDay, $validDays)) {
                return false;
            }
        }

        // Check usage limit
        if ($this->usage_limit_total && $this->usage_count >= $this->usage_limit_total) {
            return false;
        }

        return true;
    }

    /**
     * Check if the offer applies to a specific product.
     */
    public function appliesToProduct($productId)
    {
        if (!$this->isValid()) {
            return false;
        }

        $product = Product::find($productId);
        if (!$product) {
            return false;
        }

        // Product-based offer
        if ($this->offer_type === 'product') {
            $products = $this->applicable_products;
            if (empty($products)) {
                return false;
            }
            return in_array($productId, $products);
        }

        // Category-based offer
        if ($this->offer_type === 'category') {
            $categories = $this->applicable_categories;
            if (empty($categories)) {
                return false;
            }
            return in_array($product->category_id, $categories);
        }

        // Brand-based offer
        if ($this->offer_type === 'brand') {
            $brands = $this->applicable_brands;
            if (empty($brands)) {
                return false;
            }
            return in_array($product->brand_id, $brands);
        }

        // Check excluded products
        $excludedProducts = $this->excluded_products;
        if (!empty($excludedProducts) && in_array($productId, $excludedProducts)) {
            return false;
        }

        // Check excluded categories
        $excludedCategories = $this->excluded_categories;
        if (!empty($excludedCategories) && in_array($product->category_id, $excludedCategories)) {
            return false;
        }

        // Check excluded brands
        $excludedBrands = $this->excluded_brands;
        if (!empty($excludedBrands) && in_array($product->brand_id, $excludedBrands)) {
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

        // Apply max discount limit
        if ($this->max_discount_amount && $discount > $this->max_discount_amount) {
            $discount = $this->max_discount_amount;
        }

        return min($discount, $price);
    }

    /**
     * Get the final price after discount.
     */
    public function getFinalPrice($price)
    {
        $discount = $this->calculateDiscount($price);
        return $price - $discount;
    }

    /**
     * Get offer type label.
     */
    public function getTypeLabel()
    {
        $types = [
            'product' => 'Product Offer',
            'category' => 'Category Offer',
            'brand' => 'Brand Offer',
            'cart' => 'Cart Offer',
            'bogo' => 'BOGO Offer',
            'bundle' => 'Bundle Offer',
            'flash_sale' => 'Flash Sale',
            'new_user' => 'New User Offer',
            'festival' => 'Festival Offer'
        ];
        return $types[$this->offer_type] ?? ucfirst($this->offer_type);
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
        } elseif ($this->discount_type === 'buy_x_get_y') {
            return 'Buy ' . $this->buy_quantity . ' Get ' . $this->get_quantity . ' Free';
        } elseif ($this->discount_type === 'free_shipping') {
            return 'Free Shipping';
        }
        return 'Discount';
    }

    /**
     * Scope for active offers.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    /**
     * Scope for offers that apply to a specific product.
     */
    public function scopeForProduct($query, $productId)
    {
        $product = Product::find($productId);
        if (!$product) {
            return $query;
        }

        return $query->where(function($q) use ($productId, $product) {
            $q->where('offer_type', 'product')
              ->whereJsonContains('applicable_products', $productId)
              ->orWhere('offer_type', 'category')
              ->whereJsonContains('applicable_categories', $product->category_id)
              ->orWhere('offer_type', 'brand')
              ->whereJsonContains('applicable_brands', $product->brand_id)
              ->orWhere('offer_type', 'cart')
              ->orWhere('offer_type', 'bogo')
              ->orWhere('offer_type', 'bundle');
        });
    }
}