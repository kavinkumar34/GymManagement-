<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    protected $table = 'products';
    
    protected $fillable = [
        'name', 'slug', 'sku', 'top_category_id', 'brand_id',
        'category_id', 'sub_category_id', 'product_type_id', 'size_chart_id',
        'price', 'discount_price', 'mrp', 'gst_percentage', 'stock', 'min_stock_alert',
        'weight', 'weight_unit', 'dimensions', 'image', 'video_url',
        'description', 'short_description', 'attributes', 'shipping_info', 'return_policy',
        'is_featured', 'is_best_seller', 'is_new_arrival', 'is_trending',
        'status', 'return_days', 'warranty_months',
        'meta_title', 'meta_description', 'meta_keywords',
        'description_title', 'description_details'
    ];
    
    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'mrp' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_best_seller' => 'boolean',
        'is_new_arrival' => 'boolean',
        'is_trending' => 'boolean'
    ];
    
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
    
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}