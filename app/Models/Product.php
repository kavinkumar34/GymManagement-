<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    protected $table = 'products';
    
    protected $fillable = [
        'name', 
        'top_category_id', 
        'brand_id',
        'category_id', 
        'sub_category_id', 
        'product_type_id', 
        'size_chart_id',
        'price',          // Cost Price
        'mrp',            // Selling Price (MRP)
        'final_price', // Final Price after discount + GST
        'discount_type',  // flat or percentage
        'discount_value', // discount value entered
        'discount_amount',// calculated discount amount
        'gst_percentage', // GST rate
        'gst_amount',     // calculated GST amount
        'total_price',    // price + gst (before discount)
        'stock',
        'description',
        'status',
        'return_days',
        'cod_available',
        'delivery_days',
        'created_by',
    ];
    
    protected $casts = [
        'price' => 'decimal:2',
        'mrp' => 'decimal:2',
        'final_price' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'gst_percentage' => 'decimal:2',
        'gst_amount' => 'decimal:2',
        'total_price' => 'decimal:2',
        'stock' => 'integer',
        'return_days' => 'integer',
        'cod_available' => 'boolean',
        'delivery_days' => 'integer',
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
        return $this->final_price ?? $this->mrp;
    }
    
    public function getDiscountedPrice()
    {
        return $this->final_price ?? $this->mrp;
    }
    
    public function getTotalStock()
    {
        $variantStock = $this->variants()->sum('stock');
        return $this->stock + $variantStock;
    }
}