<?php

namespace MedianetDev\LaravelAuthApi\Models;

use Illuminate\Auth\Authenticatable;
use MedianetDev\LaravelAuthApi\Http\Controllers\Traits\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use MedianetDev\LaravelAuthApi\Http\Controllers\Traits\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail, Notifiable;

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        // get the notification template from the config file
        $passwordTemplate = config('laravel-auth-api.password_notification');
        // send the notification
        $this->notify(new $passwordTemplate($token));
    }

    /**
     * social accounts
     */
    public function linkedSocialAccounts()
    {
        return $this->hasMany(LinkedSocialAccount::class);
    }
}

