<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    // The prefix used in all routes with this package
    'route_prefix' => 'api/v1',

    // Fully qualified namespace of the User model
    'user_model_fqn' => MedianetDev\LaravelAuthApi\Models\ApiUser::class,

    // Fully qualified namespace of the Email verification notification template
    'email_notification' => \MedianetDev\LaravelAuthApi\Http\Controllers\Traits\Notifications\VerifyEmail::class,

    // Fully qualified namespace of the Password Reset notification template
    'password_notification' => \MedianetDev\LaravelAuthApi\Http\Controllers\Traits\Notifications\ResetPassword::class,

    // Uncomment the route to disabled it.
    'disabled_routes' => [
        // 'resend_verification_email',
        // 'verify_email',
        // 'send_reset_password_email',
        // 'reset_password',
        // 'change_password',
        // 'update_user',
        // 'login_with_social',
    ],

    // Extra columns with their validation or without
    'extra_columns' => [
        // 'phone' => 'required|number|min:8|max:12', // column with validation
        // 'is_active' => '', // column without validation
    ],

    // Extra columns validation messages
    'extra_columns_validation_message' => [
        // 'phone.number' => 'Use numbers in the phone number.',
    ],

    // Automatically send a verification email after a new registration or not.
    'auto_send_verify_email' => true,

    // Enable login
    'login' => env('LARAVEL_AUTH_API_LOGIN', true),

    // Enable registration
    'registration' => env('LARAVEL_AUTH_API_REGISTRATION', false),
];
