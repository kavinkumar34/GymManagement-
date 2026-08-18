<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnExchange extends Model
{
    protected $table = 'return_exchange_requests';

    protected $fillable = [
        'order_id',
        'order_item_id',
        'user_id',
        'request_type',
        'reason',
        'comment',
        'status',
        'admin_comment',
        'refund_amount',

        'exchange_product_id',
        'exchange_variant_id',
        'exchange_size',
        'exchange_color',
        'exchange_quantity',

        'return_quantity',
        'images',

        'bank_name',
        'account_number',
        'ifsc_code',

        'processed_at',
    ];

    protected $casts = [
        'images' => 'array',
        'processed_at' => 'datetime',
        'refund_amount' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exchangeProduct()
    {
        return $this->belongsTo(
            Product::class,
            'exchange_product_id'
        );
    }

    public function exchangeVariant()
    {
        return $this->belongsTo(
            ProductVariant::class,
            'exchange_variant_id'
        );
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Pending',
            'processing' => 'Processing',
            'completed' => 'Completed',
        ];

        return $labels[$this->status]
            ?? ucfirst($this->status);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'processing' => 'info',
            'completed' => 'success',
        ];

        return $badges[$this->status]
            ?? 'secondary';
    }

    public function getRequestTypeLabelAttribute()
    {
        return $this->request_type === 'return'
            ? 'Return'
            : 'Exchange';
    }

    public function getRequestTypeBadgeAttribute()
    {
        return $this->request_type === 'return'
            ? 'danger'
            : 'info';
    }
}