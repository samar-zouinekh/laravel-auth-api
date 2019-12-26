<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    // The prefix used in all routes with this package
    'route_prefix' => 'api/v1',

    // Fully qualified namespace of the User model
    //'user_model_fqn' => App\Models\ApiUser::class,

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
];
