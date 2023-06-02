<?php

namespace SamarZouinekh\LaravelAuthApi\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use SamarZouinekh\LaravelAuthApi\Http\Helpers\ApiResponse;
use SamarZouinekh\LaravelAuthApi\Models\ApiUser;

trait SendsPasswordResetEmails
{
    /**
     * Send a reset link to the given user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.

        // find the user
        $user = ApiUser::where('email', $this->credentials($request))->first();

        // sent user not found response
        if (! $user) {
            return $this->sendResetLinkFailedResponse($request, Password::INVALID_USER);
        }

        // generate the token
        $token = $this->generateToken($user);

        // send the mail
        $user->sendPasswordResetNotification($token);

        // send email sent successfully response
        return $this->sendResetLinkResponse($request, Password::RESET_LINK_SENT);
    }

    private function generateToken($user)
    {
        $token = mt_rand(1000, 9999);
        \DB::table('password_resets')->where('email', $user->email)->delete();
        \DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => \Hash::make($token), //change 60 to any length you want
            'created_at' => \Carbon\Carbon::now(),
        ]);

        return $token;
    }

    /**
     * Validate the email for the given request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }

    /**
     * Get the needed authentication credentials from the request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('email');
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $response
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return ApiResponse::send(['status' => trans($response)], 1, 200, trans($response));
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $response
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return ApiResponse::send(['status' => trans($response)], 0, 422, trans($response));
    }
}
