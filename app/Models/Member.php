<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';
    
    protected $fillable = [
        'member_id', 'name', 'gender', 'dob', 'age', 'phone', 'email', 'address',
        'height', 'weight', 'bmi', 'emergency_contact', 'join_date', 'membership_plan',
        'membership_duration', 'trainer_id', 'medical_issues', 'goal_type', 'photo', 'status'
    ];
    
    // Calculate BMI automatically
    public function calculateBMI()
    {
        if ($this->height > 0 && $this->weight > 0) {
            $heightInMeters = $this->height / 100;
            return round($this->weight / ($heightInMeters * $heightInMeters), 1);
        }
        return null;
    }
    
    // Get trainer details
    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }
      // Get trainer name
    public function getTrainerNameAttribute()
    {
        return $this->trainer ? $this->trainer->name : 'Not Assigned';
    }
}