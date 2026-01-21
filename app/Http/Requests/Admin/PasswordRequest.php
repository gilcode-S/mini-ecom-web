<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         return [
        'current_pwd' => 'required|string|min:6',
        'new_pwd' => 'required|string|min:6',
        'confirm_pwd' => 'required|string|same:new_pwd',
    ];
    }

    public function messages()
    {
        return [
        'current_pwd.required' => 'current password is required',
        'current_pwd.min' => 'current password must be at least 6 characters',
        'new_pwd.required' => 'new password is required',
        'new_pwd.min' => 'new password must be at least 6 characters',
        'confirm_pwd.required' => 'confirm password is required',
        'confirm_pwd.same' => 'confirm password must match to new password',
        ];
    }
}
