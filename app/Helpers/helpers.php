<?php

use App\Models\Setting;

if (!function_exists('getSetting')) {
    function getSetting($key, $default = null) {
        try {
            return Setting::get($key, $default);
        } catch (\Exception $e) {
            return $default;
        }
    }
}

if (!function_exists('getDashboardUrl')) {
    function getDashboardUrl() {
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->role == 'trainer') {
                return route('trainer.dashboard');
            } else {
                return route('member.dashboard');
            }
        }
        return route('member.register');
    }
}