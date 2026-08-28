<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $table = 'payment_history';
    
    protected $fillable = [
        'member_id',
        'plan_type',
        'plan_name',
        'duration',
        'amount',
        'payment_type',
        'transaction_id',
        'payment_date',
        'old_expiry_date',
        'new_expiry_date',
    ];
    
    /**
     * Get the member that owns the payment history.
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    
    /**
     * Get plan type label.
     */
    public function getPlanTypeLabelAttribute()
    {
        $labels = [
            'membership' => 'Membership',
            'package' => 'Package',
            'monthly' => 'Monthly Plan',
        ];
        return $labels[$this->plan_type] ?? 'N/A';
    }
    
    /**
     * Get payment type label.
     */
    public function getPaymentTypeLabelAttribute()
    {
        $labels = [
            'hand' => 'Hand Payment',
            'online' => 'Online Payment',
        ];
        return $labels[$this->payment_type] ?? 'N/A';
    }
}