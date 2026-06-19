<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    protected $table = 'products';
    
    protected $fillable = [
        'name', 'slug', 'sku', 
        'top_category_id', 'brand_id',
        'category_id', 'sub_category_id', 'product_type_id', 'size_chart_id',
        'price', 'discount_price', 'mrp', 'gst_percentage',
        'gst_amount', 'total_price', 'profit',
        'stock', 'min_stock_alert',
        'weight', 'weight_unit', 'dimensions',
        'image', 'video_url',
        'description', 'short_description',
        'description_title', 'description_details',
        'is_featured', 'is_best_seller', 'is_new_arrival', 'is_trending',
        'status',
        'return_days', 'warranty_months',
        'attributes',
        'rating', 'rating_count',
        'discount_type', 'discount_value',
        'shipping_info', 'return_policy',
        'created_by',
    ];
    
    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'mrp' => 'decimal:2',
        'gst_percentage' => 'decimal:2',
        'gst_amount' => 'decimal:2',
        'total_price' => 'decimal:2',
        'profit' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'rating' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_best_seller' => 'boolean',
        'is_new_arrival' => 'boolean',
        'is_trending' => 'boolean',
        'return_days' => 'integer',
        'warranty_months' => 'integer',
        'stock' => 'integer',
        'min_stock_alert' => 'integer',
        'rating_count' => 'integer',
        'weight' => 'decimal:2',
        'attributes' => 'array',
    ];
    
    // Relationships
    public function topCategory()
    {
        return $this->belongsTo(TopCategory::class, 'top_category_id');
    }
    
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }
    
    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }
    
    public function sizeChart()
    {
        return $this->belongsTo(SizeChart::class, 'size_chart_id');
    }
    
    // ⭐ VARIANTS RELATIONSHIP
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    
    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id')->orderBy('display_order', 'asc');
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    // Helper Methods
    public function getFinalPrice()
    {
        $price = $this->price;
        if ($this->discount_type === 'flat') {
            return max(0, $price - $this->discount_value);
        } elseif ($this->discount_type === 'percentage') {
            return max(0, $price - (($price * $this->discount_value) / 100));
        }
        return $price;
    }
    
    public function getDiscountedPrice()
    {
        return $this->discount_price ?? $this->getFinalPrice();
    }
    
    public function getStarRating()
    {
        if ($this->rating == 0 || $this->rating_count == 0) {
            return 0;
        }
        return round($this->rating / $this->rating_count, 1);
    }
    
    public function getTotalStock()
    {
        $variantStock = $this->variants()->sum('stock');
        return $this->stock + $variantStock;
    }
}