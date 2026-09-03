<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // ===== MEMBER GUARD =====
        'member' => [
            'driver' => 'session',
            'provider' => 'members',
        ],

        // ===== TRAINER GUARD =====
        'trainer' => [
            'driver' => 'session',
            'provider' => 'trainers',
        ],

        // ===== ADMIN GUARD =====
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // ===== MEMBER PROVIDER =====
        'members' => [
            'driver' => 'eloquent',
            'model' => App\Models\Member::class,
        ],

        // ===== TRAINER PROVIDER =====
        'trainers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Trainer::class,
        ],

        // ===== ADMIN PROVIDER =====
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'members' => [
            'provider' => 'members',
            'table' => 'member_password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'trainers' => [
            'provider' => 'trainers',
            'table' => 'trainer_password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'admins' => [
            'provider' => 'admins',
            'table' => 'admin_password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];