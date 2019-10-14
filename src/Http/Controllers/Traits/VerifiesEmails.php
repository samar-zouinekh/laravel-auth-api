<?php

namespace MedianetDev\LaravelAuthApi\Http\Controllers\Traits;

use MedianetDev\LaravelAuthApi\Http\Helpers\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

trait VerifiesEmails
{

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        if (! hash_equals((string) $request->route('code'), (string) hexdec( substr(sha1($request->user()->getKey() . $request->user()->getEmailForVerification()), 0, 3) ))) {
            return ApiResponse::send([['error' => 'Bad codes.']], 0, 403);
        }

        if ($request->user()->hasVerifiedEmail()) {
            return ApiResponse::send([['success' => 'email already verified.....']], 1, 200);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return ApiResponse::send([['success' => 'email verified successfully']], 1, 200);
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if (Auth::guard('apiauth')->user()->hasVerifiedEmail()) {
            return response()->json(['success' => 'email already verified'], 200);
        }

        Auth::guard('apiauth')->user()->sendEmailVerificationNotification();

        return response()->json(['success' => 'email resended successfully'], 200);
    }
}
