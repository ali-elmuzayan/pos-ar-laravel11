<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:20', 'min:1'],
            'return_period' => ['nullable', 'numeric', 'max:30', 'min:1'],
            'wallet_password' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:4048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'يجب ان تضيف اسما للشركة',
            'address.required' => 'يجب ان تضيف عنوانا للشركة',
            'phone.required' => 'يجب ان تضيف رقما للشركة',
            'phone.max' => 'يجب ان يكون رقم الشركة اقل من 20 رقم',
            'phone.min' => 'يجب ان يكون رقم الشركة اكبر من 1 رقم',
            'name.string' => 'يجب ان يحتوي الاسم على احرف',
            'wallet_password.string' => 'يجب ان تحتوي كلمة المرور على احرف او ارقام',
            'logo.image' => 'يجب ان يكون الملف من نوع صور ',
            'logo.mimes' => 'يجب ان يكون الملف jpg, png, jpeg',
            'logo.max' => 'يجب ان يكون حجم الصورة اصغر من 4096',
            'return_period.required' => 'يجب ان تضيف قيمة او رقم صحيح',
            'return_period.numeric' => 'يجب ان تضيف قيمة او رقم صحيح',
            'return_period.max' => 'يجب ان تكون القيمة اقل من 30 يوم',
            'return_period.min' => 'يجب ان تكون القيمة اكبرر من 1',
            'exchange_period.required' => 'يجب ان تضيف قيمة او رقم صحيح',
            'exchange_period.numeric' => 'يجب ان تضيف قيمة او رقم صحيح',
            'exchange_period.max' => 'يجب ان تكون القيمة اقل من 30 يوم',
            'exchange_period.min' => 'يجب ان تكون القيمة اكبرر من1 يوم',

        ];
    }
}
