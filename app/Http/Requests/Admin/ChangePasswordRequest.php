<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'يجب ادخال كلمة المرور',
            'password.min' => 'يجب ان تكون كلمة المرور اكبر من 6 ارقام',
            'password.confirmed' => 'يجب ان تكون كلمة المرور مطابقة في الخانتين',
            'password.string' => 'يجب ان تكون كلمة المرور نصية',
        ];
    }
}
