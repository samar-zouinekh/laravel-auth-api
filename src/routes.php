<?php

/*
|--------------------------------------------------------------------------
| MedianetDev\LaravelAuthApi
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the MedianetDev\LaravelAuthApi.
|
*/

Route::group(
    [
        'namespace'  => 'MedianetDev\LaravelAuthApi\Http\Controllers',
        'middleware' => 'api',
        'prefix'     => config('laravel-auth-api.route_prefix'),
    ],
    function () {
        /**
         *  Login and register users throw email address
         */
        Route::post('login', 'ApiLoginRegisterController@login')->name('api.auth.login');
        Route::post('register', 'ApiLoginRegisterController@register')->name('api.auth.register');
        Route::get('getUser', 'ApiLoginRegisterController@getUser')->name('api.auth.user');

        // resend verification email
        Route::post('email/resend', 'VerificationController@resend')->name('api.auth.verification.send');
        // process the verification process
        Route::post('email/verify/{code}', 'VerificationController@verify')->name('api.auth.verification.verify');
        // send reset password code email
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('api.auth.password.send');
        // process the reset password process
        Route::post('password/reset', 'ResetPasswordController@reset')->name('api.auth.password.reset');

        // update user profile info
        Route::post('user/update', 'ChangeUserProfileInfoController@update')->name('api.auth.user.update');
        // login by social account
        Route::post('login/social', 'LinkedSocialAccountController@findOrCreate')->name('api.auth.login.social');
    }
);
