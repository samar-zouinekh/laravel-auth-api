<?php

namespace MedianetDev\LaravelAuthApi\Models;

use MedianetDev\LaravelAuthApi\Http\Controllers\Interfaces\MustVerifyEmail;
use MedianetDev\LaravelAuthApi\Models\User as Authenticatable;
use MedianetDev\LaravelAuthApi\Models\Traits\InheritsRelationsFromParentModel;
use Laravel\Passport\HasApiTokens;

class ApiUser extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use InheritsRelationsFromParentModel;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

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
     * lslsls
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
