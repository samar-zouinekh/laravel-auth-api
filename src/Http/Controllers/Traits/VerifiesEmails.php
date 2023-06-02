<?php

namespace SamarZouinekh\LaravelAuthApi\Http\Controllers\Traits;

use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SamarZouinekh\LaravelAuthApi\Http\Helpers\ApiResponse;

trait VerifiesEmails
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        if (! hash_equals((string) $request->route('code'), (string) sprintf('%04d', hexdec(substr(sha1($request->user()->getKey().$request->user()->getEmailForVerification()), 0, 3))))) {
            return ApiResponse::send(['error' => trans('laravel-auth-api::translation.Bad.codes')], 0, 403, trans('laravel-auth-api::translation.Bad.codes'));
            
        }

        if ($request->user()->hasVerifiedEmail()) {
            return ApiResponse::send(['success' => trans('laravel-auth-api::translation.email.already.verified')], 1, 200, trans('laravel-auth-api::translation.email.already.verified'));

        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return ApiResponse::send(['success' => trans('laravel-auth-api::translation.email.verified.successfully')], 1, 200, trans('laravel-auth-api::translation.email.verified.successfully'));

    }

    /**
     * Resend the email verification notification.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if (Auth::guard('apiauth')->user()->hasVerifiedEmail()) {
           
            return ApiResponse::send(['success' => trans('laravel-auth-api::translation.email.already.verified')], 1, 200, trans('laravel-auth-api::translation.email.already.verified'));
        }

        Auth::guard('apiauth')->user()->sendEmailVerificationNotification();

        return ApiResponse::send(['success' => trans('laravel-auth-api::translation.email.resended.successfully')], 1, 200, trans('laravel-auth-api::translation.email.resended.successfully'));
    }
}
