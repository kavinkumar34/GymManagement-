<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expenses';

    protected $fillable = [
        'expense_date',
        'description',
        'amount',
        'payment_type',
        'receipt_image',
        'created_by',
    ];

    protected $casts = [
        'expense_date' => 'date',
        'amount' => 'decimal:2',
    ];

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

    /**
     * Get the admin who created this expense.
     */
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    // ==========================================
    // ACCESSORS
    // ==========================================

    /**
     * Get payment type label.
     */
    public function getPaymentTypeLabelAttribute()
    {
        $labels = [
            'cash' => 'Cash',
            'online' => 'Online',
        ];
        return $labels[$this->payment_type] ?? 'N/A';
    }

    /**
     * Get formatted amount.
     */
    public function getFormattedAmountAttribute()
    {
        return '₹ ' . number_format($this->amount, 2);
    }

    /**
     * Get formatted expense date.
     */
    public function getFormattedDateAttribute()
    {
        return $this->expense_date ? $this->expense_date->format('d-m-Y') : '-';
    }

    /**
     * Get month name.
     */
    public function getMonthYearAttribute()
    {
        return $this->expense_date ? $this->expense_date->format('M Y') : '-';
    }
}