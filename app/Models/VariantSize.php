<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantSize extends Model
{
    protected $table = 'variant_sizes';
    public $timestamps = false;
    
    protected $fillable = [
        'variant_id', 'size', 'stock', 'price', 'discount_type', 'discount_value'
    ];
    
    protected $casts = [
        'price' => 'decimal:2',
        'discount_value' => 'decimal:2'
    ];
    
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}