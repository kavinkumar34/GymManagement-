<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainerSalary extends Model
{
    protected $table = 'trainer_salaries';

    protected $fillable = [
        'trainer_id',
        'salary_month',
        'salary_amount',
        'payment_date',
        'payment_type',
        'reference_number',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'salary_month' => 'date',
        'payment_date' => 'date',
        'salary_amount' => 'decimal:2',
    ];

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    // ==========================================
    // ACCESSORS
    // ==========================================

    public function getMonthYearAttribute()
    {
        return $this->salary_month ? $this->salary_month->format('M Y') : '-';
    }

    public function getFormattedAmountAttribute()
    {
        return '₹ ' . number_format($this->salary_amount, 2);
    }

    public function getFormattedDateAttribute()
    {
        return $this->payment_date ? $this->payment_date->format('d-m-Y') : '-';
    }

    public function getFormattedMonthAttribute()
    {
        return $this->salary_month ? $this->salary_month->format('d-m-Y') : '-';
    }

    public function getPaymentTypeLabelAttribute()
    {
        $labels = [
            'cash' => 'Cash',
            'bank' => 'Bank Transfer',
            'online' => 'Online',
        ];
        return $labels[$this->payment_type] ?? 'N/A';
    }

    public function getPaymentTypeIconAttribute()
    {
        $icons = [
            'cash' => 'fa-hand-holding-usd',
            'bank' => 'fa-university',
            'online' => 'fa-wifi',
        ];
        return $icons[$this->payment_type] ?? 'fa-credit-card';
    }
}