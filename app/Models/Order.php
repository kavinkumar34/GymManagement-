<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $table = 'orders';
    
    protected $fillable = [
        'order_number', 
        'user_id', 
        'total_amount', 
        'shipping_charge',
        'payment_status', 
        'order_status',
        'refund_status',
        'refund_amount',
        'payment_method', 
        'transaction_id', 
        'payment_id',
        'payment_details', 
        'order_date'
    ];
    
    protected $casts = [
        'payment_details' => 'array',
        'order_date' => 'datetime',
        'refund_amount' => 'decimal:2'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function cancellation()
    {
        return $this->hasOne(OrderCancellation::class);
    }
    
    public function isCanceled()
    {
        return in_array($this->order_status, ['Cancelled', 'Failed']);
    }
    
    // Get Product Revenue (final_price * quantity)
    public function getProductRevenueAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }
    
    // Get Actual Price (product's original price * quantity)
    public function getActualPriceAttribute()
    {
        return $this->items->sum(function ($item) {
            $product = Product::find($item->product_id);
            return ($product->price ?? 0) * $item->quantity;
        });
    }
    
    // Get Profit
    public function getProfitAttribute()
    {
        return $this->product_revenue - $this->actual_price;
    }
    
    // Get Total with Shipping
    public function getTotalWithShippingAttribute()
    {
        return $this->profit + ($this->shipping_charge ?? 0);
    }
    
    // Get Refund Status Label
    public function getRefundStatusLabelAttribute()
    {
        $statuses = [
            'pending' => 'Pending',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'none' => 'N/A'
        ];
        return $statuses[$this->refund_status] ?? 'N/A';
    }
    
    // Get Refund Status Badge Class
    public function getRefundStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'payment-pending',
            'processing' => 'payment-pending',
            'completed' => 'payment-paid',
            'none' => ''
        ];
        return $badges[$this->refund_status] ?? '';
    }
    public function returnRequests()
{
    return $this->hasMany(ReturnExchange::class);
}
}   