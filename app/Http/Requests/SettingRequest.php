<?php

namespace App\Http\Requests;

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
            'phone' => ['required', 'string'],
            'return_period' => ['nullable', 'numeric', 'max:30', 'min:1'],
            'exchange_period' => ['nullable', 'numeric', 'max:30', 'min:1'],
            'logo' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:4048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'يجب ان تضيف اسما للشركة',
            'address.required' => 'يجب ان تضيف عنوانا للشركة',
            'phone.required' => 'يجب ان تضيف رقما للشركة',
            'name.string' => 'يجب ان يحتوي الاسم على احرف',
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
