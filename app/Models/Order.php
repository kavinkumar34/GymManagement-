<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    
    protected $fillable = [
        'order_number', 'user_id', 'total_amount', 'payment_status', 
        'order_status', 'payment_method', 'transaction_id', 'payment_id',
        'payment_details', 'order_date'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}