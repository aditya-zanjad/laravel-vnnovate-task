<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id'       =>  'required|numeric|integer|exists:users,id',
            'name'          =>  'required|string|min:3',
            'gender'        =>  'required|string|size:1|in:m,f,o',
            'city_id'       =>  'required|numeric|integer|exists:cities,id',
            'new_password'  =>  ['nullable', 'confirmed', Password::min(8)],

            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->user_id, 'id')
            ],

            'old_password' => [
                'exclude_if:new_password,null',
                'required_unless:new_password,null',
                Password::min(8),

                // Check if the old password is correct or not
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->getAuthPassword())) {
                        $fail('The Provided ' . ucwords(str_replace('_', ' ', $attribute)) . ' Is Wrong');
                    }
                }
            ],
        ];
    }

    /**
     * Custom validation error messages
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'old_password.required_unless' => 'The old password is required when providing a new password'
        ];
    }
}
