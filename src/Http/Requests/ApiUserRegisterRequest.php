<?php

namespace SamarZouinekh\LaravelAuthApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiUserRegisterRequest extends FormRequest
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
            'name' => 'required|min:4|max:20',
            'email' => 'required|unique:'.(new $user)->getTable().',email',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password',
        ], config('laravel-auth-api.extra_columns'));
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return array_merge([
            //
        ], config('laravel-auth-api.extra_columns_validation_message'));
    }
}
