<?php

namespace MedianetDev\LaravelAuthApi\Http\Controllers;

use MedianetDev\LaravelAuthApi\Http\Helpers\ApiResponse;
use MedianetDev\LaravelAuthApi\Http\Requests\SocialAccountRequest;
use MedianetDev\LaravelAuthApi\Models\ApiUser;
use MedianetDev\LaravelAuthApi\Models\LinkedSocialAccount;

class LinkedSocialAccountController extends Controller
{
    public function findOrCreate(SocialAccountRequest $request)
    {
        // see if any social account with the given data exists
        $socialAccount = $this->getSocialAccount($request);

        // if there is a social account return the associated user and the access token
        if ($socialAccount) {
            return ApiResponse::send([
                'flag' => 0,
                'user' => $socialAccount->user,
                'access_token' => $socialAccount->user->createToken('AppName')->accessToken,
            ], 1, 200, "find an associated user account with this $request->provider_name account");
        }

        // try to get a user with the given email address
        $user = ApiUser::where('email', $request->email)->first();

        // if there is no user with that email address create one
        $newUser = false;
        if (! $user) {
            $user = ApiUser::create($request->only(['name', 'email']));
            $newUser = true;
        }

        // create and link a social account
        $user->linkedSocialAccounts()->create($request->only(['provider_name', 'provider_id', 'email']));

        // return the new created user and the access token
        if ($newUser) {
            return ApiResponse::send([
                'flag' => 1,
                'user' => $user,
                'access_token' => $user->createToken('AppName')->accessToken,
            ], 1, 201, 'new user account and social account has been created.');
        }

        return ApiResponse::send([
            'flag' => 0,
            'user' => $user,
            'access_token' => $user->createToken('AppName')->accessToken,
        ], 1, 201, "new social account has been created for $request->name.");
    }

    private function getSocialAccount(SocialAccountRequest $request)
    {
        return LinkedSocialAccount::where('provider_name', $request->provider_name)
            ->where('provider_id', $request->provider_id)
            ->first();
    }
}
