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
        //TODO: encapsulate all the responses with ApiRequest
        $user = Auth::guard('apiauth')->user();

        $user->name = $request->name;
        $user->email = $request->email;
        

        if ($user->isDirty('email')) {
            // mark the email as not verified yet
            $user->email_verified_at = null;
            // send a verification email
            $user->sendEmailVerificationNotification();
        }

        $user->save();

        return ApiResponse::send(['status' => 'Account updated successfully'], 1, 200, 'Account updated successfully');
    }
}
