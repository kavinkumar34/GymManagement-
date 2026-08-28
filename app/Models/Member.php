<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';
    
    protected $fillable = [
        // Personal Information
        'member_id', 
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
        'join_date',
        'expiry_date',  // ✅ NEW
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
        
        // Assignment
        'trainer_id',
        
        // Photo & Status
        'photo', 
        'status',
    ];
    
    // ============================================
    // RELATIONSHIPS
    // ============================================
    
    /**
     * Get the trainer associated with the member.
     */
    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }
    
    /**
     * Get the attendances for the member.
     */
    public function attendances()
    {
        return $this->hasMany(MemberAttendance::class, 'member_id');
    }
    
    // ============================================
    // ACCESSORS / MUTATORS
    // ============================================
    
    /**
     * Calculate BMI automatically.
     */
    public function calculateBMI()
    {
        if ($this->height > 0 && $this->weight > 0) {
            $heightInMeters = $this->height / 100;
            return round($this->weight / ($heightInMeters * $heightInMeters), 1);
        }
        return null;
    }
    
    /**
     * Get trainer name attribute.
     */
    public function getTrainerNameAttribute()
    {
        return $this->trainer ? $this->trainer->name : 'Not Assigned';
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
        return $labels[$this->payment_type] ?? 'Not specified';
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
        return $labels[$this->plan_type] ?? 'Not specified';
    }
    
    /**
     * Get status label with badge class.
     */
    public function getStatusBadgeAttribute()
    {
        if ($this->status == 'Active') {
            return '<span class="status-badge active"><span class="dot"></span> Active</span>';
        }
        return '<span class="status-badge inactive"><span class="dot"></span> Inactive</span>';
    }
    
    /**
     * Check if member is expired.
     */
    public function isExpired()
    {
        if (!$this->expiry_date) {
            return false;
        }
        return now()->gt($this->expiry_date);
    }
    
    /**
     * Get days remaining until expiry.
     */
    public function getDaysRemainingAttribute()
    {
        if (!$this->expiry_date) {
            return null;
        }
        if ($this->isExpired()) {
            return 0;
        }
        return now()->diffInDays($this->expiry_date);
    }
    
    /**
     * Get expiry status with badge.
     */
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
    
    /**
     * Scope a query to only include active members.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }
    
    /**
     * Scope a query to only include inactive members.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'Inactive');
    }
    
    /**
     * Scope a query to only include members with a specific plan type.
     */
    public function scopePlanType($query, $type)
    {
        return $query->where('plan_type', $type);
    }
    
    /**
     * Scope a query to only include expired members.
     */
    public function scopeExpired($query)
    {
        return $query->where('expiry_date', '<', now());
    }
    
    /**
     * Scope a query to only include non-expired members.
     */
    public function scopeNotExpired($query)
    {
        return $query->where(function($q) {
            $q->whereNull('expiry_date')
              ->orWhere('expiry_date', '>=', now());
        });
    }
}