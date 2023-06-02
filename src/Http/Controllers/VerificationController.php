<?php

namespace SamarZouinekh\LaravelAuthApi\Http\Controllers;

use SamarZouinekh\LaravelAuthApi\Http\Controllers\Traits\VerifiesEmails;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:apiauth');
        // $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
