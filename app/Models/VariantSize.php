<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantSize extends Model
{
    protected $table = 'variant_sizes';
    
    protected $fillable = [
        'variant_id', 'size', 'price', 'stock'
    ];
    
    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];
    
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}