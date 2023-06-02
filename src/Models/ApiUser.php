<?php

namespace SamarZouinekh\LaravelAuthApi\Models;

use Laravel\Passport\HasApiTokens;
use SamarZouinekh\LaravelAuthApi\Http\Controllers\Interfaces\MustVerifyEmail;
use SamarZouinekh\LaravelAuthApi\Models\Traits\InheritsRelationsFromParentModel;
use SamarZouinekh\LaravelAuthApi\Models\User as Authenticatable;

class ApiUser extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use InheritsRelationsFromParentModel;

    protected $table = 'users';
    protected $guarded = ['c_password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     * lslsls.
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
