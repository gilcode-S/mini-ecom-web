<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DetailRequest extends FormRequest
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
            //
            'name' => 'required|string|max:255',
            'mobile' => 'required|numeric|digits:11',
            'image' => 'image'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.regex' => 'Valid Name is required',
            'name.max' => 'Name must not exceed 255 characters',
            'mobile.required' => 'Mobile number is required',
            'mobile.numeric' => 'Mobile number must be numeric',
            'mobile.digits' => 'Mobile number must be 11 digits',
            'image.image' => 'Valid image file is required'
        ];
    }
}
