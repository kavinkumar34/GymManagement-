<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';
    
    protected $fillable = [
        // Personal Information
        'member_id', 
        'register_date',    // NEW - First registration date (NEVER CHANGES)
        'name', 
        'gender', 
        'dob', 
        'age', 
        'phone', 
        'email', 
        'address',
        'emergency_contact',
        
        // Fitness Information
        'height', 
        'weight', 
        'bmi', 
        'medical_issues', 
        'goal_type',
        
        // Membership Information
        'join_date',        // Membership start date (CAN CHANGE on renewal)
        'expiry_date',
        'plan_type',
        'membership_plan',
        'membership_duration', 
        'final_price',
        
        // Monthly Plan Fields
        'monthly_month',
        'monthly_price',
        
        // Payment Fields
        'payment_type',
        'transaction_id',
        'payment_screenshot',
        'payment_date',     // NEW - Payment made date
        
        // Assignment
        'trainer_id',
        
        // Photo & Status
        'photo', 
        'status',
    ];
    
    // ============================================
    // RELATIONSHIPS
    // ============================================
    
    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }
    
    public function attendances()
    {
        return $this->hasMany(MemberAttendance::class, 'member_id');
    }
    
    public function paymentHistories()
    {
        return $this->hasMany(PaymentHistory::class, 'member_id');
    }
    
    // ============================================
    // ACCESSORS / MUTATORS
    // ============================================
    
    public function calculateBMI()
    {
        if ($this->height > 0 && $this->weight > 0) {
            $heightInMeters = $this->height / 100;
            return round($this->weight / ($heightInMeters * $heightInMeters), 1);
        }
        return null;
    }
    
    public function getTrainerNameAttribute()
    {
        return $this->trainer ? $this->trainer->name : 'Not Assigned';
    }
    
    public function getPaymentTypeLabelAttribute()
    {
        $labels = [
            'hand' => 'Hand Payment',
            'online' => 'Online Payment',
        ];
        return $labels[$this->payment_type] ?? 'Not specified';
    }
    
    public function getPlanTypeLabelAttribute()
    {
        $labels = [
            'membership' => 'Membership',
            'package' => 'Package',
            'monthly' => 'Monthly Plan',
        ];
        return $labels[$this->plan_type] ?? 'Not specified';
    }
    
    public function getStatusBadgeAttribute()
    {
        if ($this->status == 'Active') {
            return '<span class="status-badge active"><span class="dot"></span> Active</span>';
        }
        return '<span class="status-badge inactive"><span class="dot"></span> Inactive</span>';
    }
    
    public function isExpired()
    {
        if (!$this->expiry_date) {
            return false;
        }
        return now()->gt($this->expiry_date);
    }
    
    public function getDaysRemainingAttribute()
    {
        if (!$this->expiry_date) {
            return null;
        }
        if ($this->isExpired()) {
            return 0;
        }
        return floor(now()->diffInDays($this->expiry_date));
    }
    
    public function getExpiryStatusAttribute()
    {
        if (!$this->expiry_date) {
            return '<span class="badge badge-secondary">No Expiry</span>';
        }
        
        if ($this->isExpired()) {
            return '<span class="badge badge-danger">Expired</span>';
        }
        
        $daysLeft = $this->days_remaining;
        if ($daysLeft <= 7) {
            return '<span class="badge badge-warning">' . $daysLeft . ' days left</span>';
        }
        return '<span class="badge badge-success">' . $daysLeft . ' days left</span>';
    }
    
    // ============================================
    // SCOPES
    // ============================================
    
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }
    
    public function scopeInactive($query)
    {
        return $query->where('status', 'Inactive');
    }
    
    public function scopePlanType($query, $type)
    {
        return $query->where('plan_type', $type);
    }
    
    public function scopeExpired($query)
    {
        return $query->where('expiry_date', '<', now());
    }
    
    public function scopeNotExpired($query)
    {
        return $query->where(function($q) {
            $q->whereNull('expiry_date')
              ->orWhere('expiry_date', '>=', now());
        });
    }
}