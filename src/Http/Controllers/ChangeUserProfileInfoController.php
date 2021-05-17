<?php

namespace MedianetDev\LaravelAuthApi\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use MedianetDev\LaravelAuthApi\Http\Helpers\ApiResponse;
use MedianetDev\LaravelAuthApi\Http\Requests\ChangeUserProfileInfoRequest;

class ChangeUserProfileInfoController extends Controller
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

    public function update(ChangeUserProfileInfoRequest $request)
    {
        $user = Auth::guard('apiauth')->user();
        $oldEmail = $user->email;

        $user->update($request->only(
            array_merge(['name', 'email'],
            array_keys(config('laravel-auth-api.extra_columns'))
        )));
        if ($user->email !== $oldEmail) {
            $user->email_verified_at = null;
            $user->save();
            if (config('laravel-auth-api.auto_send_verify_email', false)) {
                try {
                    $user->sendEmailVerificationNotification();
                } catch (\Throwable $th) {
                    app('log')->warning(
                        'Cannot send verification email to this address: '.$user->email.'; '.$th->getMessage()
                    );
                }
            }
        }

        return ApiResponse::send(['status' => 'Account updated successfully'], 1, 200, 'Account updated successfully');
    }
}
