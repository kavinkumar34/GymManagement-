<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'otp',
        'otp_expires_at',
        'is_verified',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'otp_expires_at' => 'datetime',
            'is_verified' => 'boolean',
        ];
    }

    public function generateOTP()
    {
        $this->otp = rand(100000, 999999);
        $this->otp_expires_at = now()->addMinutes(5);
        $this->save();
        return $this->otp;
    }

    public function verifyOTP($otp)
    {
        if ($this->otp == $otp && now()->lessThan($this->otp_expires_at)) {
            $this->is_verified = true;
            $this->otp = null;
            $this->otp_expires_at = null;
            $this->save();
            return true;
        }
        return false;
    }
}