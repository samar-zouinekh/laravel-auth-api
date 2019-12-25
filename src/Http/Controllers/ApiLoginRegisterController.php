<?php

namespace MedianetDev\LaravelAuthApi\Http\Controllers;

use Illuminate\Http\Request;
use MedianetDev\LaravelAuthApi\Http\Controllers\Controller;
use MedianetDev\LaravelAuthApi\Models\ApiUser as User;
use Illuminate\Support\Facades\Auth;
use MedianetDev\LaravelAuthApi\Http\Helpers\ApiResponse;
use MedianetDev\LaravelAuthApi\Http\Requests\ApiUserLoginRequest as LoginRequest;
use MedianetDev\LaravelAuthApi\Http\Requests\ApiUserRegisterRequest as RegisterRequest;
use Validator;

class ApiLoginRegisterController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api')->only('getUser');
    }

    public $successStatus = 200;

    public function register(RegisterRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $user->sendEmailVerificationNotification();
        $success = [];
        $success['access_token'] = $user->createToken('AppName')->accessToken;
        $success['user'] = $user->toArray();
        return  ApiResponse::send($success, 1, 201, "Account created successfully");
    }


    public function login(LoginRequest $request)
    {
        if (Auth::guard('apiauthweb')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::guard('apiauthweb')->user();
            $success = [];
            $success['access_token'] = $user->createToken('AppName')->accessToken;
            $success['user'] = $user->toArray();
            return ApiResponse::send($success, 1, 200);
        } else {
            return ApiResponse::send(['error' => 'Unauthorised'], 0, 401, 'Password or incorrect identity');
        }
    }

    public function getUser()
    {
        $user = Auth::guard('apiauth')->user();
        return ApiResponse::send($user, 1, 200);
    }
}
