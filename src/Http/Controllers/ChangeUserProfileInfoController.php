<?php

namespace MedianetDev\LaravelAuthApi\Http\Controllers;

use MedianetDev\LaravelAuthApi\Http\Controllers\Controller;
use MedianetDev\LaravelAuthApi\Http\Requests\ChangeUserProfileInfoRequest;
use Illuminate\Support\Facades\Auth;

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
        $user->save();

        return response()->json(['status' => 'Account updated successfully'], 200);
    }
}
