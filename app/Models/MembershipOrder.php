<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipOrder extends Model
{
    protected $table = 'membership_orders';

    protected $fillable = [
        'user_id',
        'member_id',
        'membership_id',
        'plan_name',
        'duration',
        'duration_type',
        'amount',
        'transaction_id',
        'payment_id',
        'payment_status',
        'payer_name',
        'payer_email',
        'payer_phone',
        'payment_response',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
}