<?php

namespace SamarZouinekh\LaravelAuthApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChangeUserProfileInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = config('laravel-auth-api.user_model_fqn');

        return array_merge([
            'name'     => 'required|min:6',
            'email'    => 'required|email|unique:'.(new $user)->getTable().',email,'.Auth::id(),
        ], config('laravel-auth-api.extra_columns'));
    }
}
