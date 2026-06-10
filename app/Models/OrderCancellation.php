<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCancellation extends Model
{
    protected $table = 'order_cancellations';
    
    protected $fillable = [
        'order_id', 'user_id', 'cancellation_reason', 'cancellation_comment'
    ];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}