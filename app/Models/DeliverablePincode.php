<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverablePincode extends Model
{
    use HasFactory;
    
    protected $table = 'deliverable_pincodes';
    
    protected $fillable = [
        'state', 'shipping_charge', 'is_active'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'shipping_charge' => 'decimal:2'
    ];
    
    public static function getShippingCharge($state)
    {
        $pincode = self::where('state', $state)
            ->where('is_active', 1)
            ->first();
        
        return $pincode ? $pincode->shipping_charge : 0;
    }
    
    public static function isDeliverable($state)
    {
        return self::where('state', $state)
            ->where('is_active', 1)
            ->exists();
    }
    
    public static function getDeliveryInfo($state)
    {
        return self::where('state', $state)
            ->where('is_active', 1)
            ->first();
    }
}