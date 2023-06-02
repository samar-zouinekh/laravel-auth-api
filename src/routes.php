<?php

/*
|--------------------------------------------------------------------------
| SamarZouinekh\LaravelAuthApi
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the SamarZouinekh\LaravelAuthApi.
|
*/

Route::group(
    [
        'namespace' => 'SamarZouinekh\LaravelAuthApi\Http\Controllers',
        'middleware' => 'api',
        'prefix' => config('laravel-auth-api.route_prefix'),
    ],
    function () {
        /*
         *  Login and register users throw email address
         */
        if (config('laravel-auth-api.login')) {
            Route::post('login', 'ApiLoginRegisterController@login')->name('api.auth.login');
        }
        if (config('laravel-auth-api.registration')) {
            Route::post('register', 'ApiLoginRegisterController@register')->name('api.auth.register');
        }
        Route::get('getUser', 'ApiLoginRegisterController@getUser')->name('api.auth.user');

        if (! in_array('resend_verification_email', config('laravel-auth-api.disabled_routes'))) {
            // resend verification email
            Route::post('email/resend', 'VerificationController@resend')->name('api.auth.verification.send');
        }
        if (! in_array('verify_email', config('laravel-auth-api.disabled_routes'))) {
            // process the verification process
            Route::post('email/verify/{code}', 'VerificationController@verify')->name('api.auth.verification.verify');
        }
        if (! in_array('send_reset_password_email', config('laravel-auth-api.disabled_routes'))) {
            // send reset password code email
            Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('api.auth.password.send');
        }
        if (! in_array('reset_password', config('laravel-auth-api.disabled_routes'))) {
            // process the reset password process
            Route::post('password/reset', 'ResetPasswordController@reset')->name('api.auth.password.reset');
        }
        if (! in_array('change_password', config('laravel-auth-api.disabled_routes'))) {
            // change password
            Route::post('password/change', 'ChangePasswordController@changePassword')->name('api.auth.password.change');
        }
        if (! in_array('update_user', config('laravel-auth-api.disabled_routes'))) {
            // update user profile info
            Route::post('user/update', 'ChangeUserProfileInfoController@update')->name('api.auth.user.update');
        }
        if (! in_array('login_with_social', config('laravel-auth-api.disabled_routes'))) {
            // login by social account
            Route::post('login/social', 'LinkedSocialAccountController@findOrCreate')->name('api.auth.login.social');
        }
    }
);
