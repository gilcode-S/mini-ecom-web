<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SubadminRequest extends FormRequest
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
            'mobile' => 'required|numeric',
            'image' => 'image',
            'email' => 'required|email'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'mobile.required' => 'Mobile number is required',
            'mobile.numeric' => 'Mobile number must be numeric',
            'image.image' => "Profile image must be on image format",
            'email.required' => "Email is required",
            'email.email' => "Email must be a valid email address"
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if($this->input('id') == "")
                {
                    $subadmindata = Admin::where('email', $this->input('email'))->count();
                    if($subadmindata > 0) 
                        {
                            $validator->errors()->add('email', "Email already exists");
                        }
                }
        });
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()->withErrors($validator)->withInput()
        );
    }
}
