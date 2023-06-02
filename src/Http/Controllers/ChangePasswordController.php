<?php

namespace SamarZouinekh\LaravelAuthApi\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use SamarZouinekh\LaravelAuthApi\Http\Helpers\ApiResponse;
use SamarZouinekh\LaravelAuthApi\Http\Requests\ChangePasswordRequest;

class ChangePasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::guard('apiauth')->user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return ApiResponse::send(['status' => trans('laravel-auth-api::translation.password.changed.successfully')], 1, 200, trans('laravel-auth-api::translation.password.changed.successfully'));

    }
}
