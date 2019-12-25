<?php

namespace MedianetDev\LaravelAuthApi\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use MedianetDev\LaravelAuthApi\Http\Helpers\ApiResponse;
use MedianetDev\LaravelAuthApi\Http\Requests\ChangePasswordRequest;

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

        return ApiResponse::send(['status' => 'Password changed successfully'], 1, 200, 'Password changed successfully');
    }
}
