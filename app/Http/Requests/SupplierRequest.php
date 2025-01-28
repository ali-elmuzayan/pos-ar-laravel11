<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'unique:suppliers,phone', 'max:20'],
            'email' => ['nullable', 'email'],
            'address' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:4096'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'اسم الموزع مطلوب',
            'name.string' => 'اسم الموزع غير صحيح',
            'name.max' => 'يجب ان يكون اسم الموزع اقل من 100 حرف',
            'phone.max' => 'يجب ان يكون رقم الموزع اقل من 20 رقم',
            'phone.unique' => 'رقم الهاتف موجود يجب استخدام رقم اخر',
            'phone.string' => 'يجب اضافى رقم الهاتف',
            'email.email' => 'الايميل يجب ان يكون من نوع ايميل',
            'address.string' => 'العنوان يجب ان يكون نص ',
            'image.image' => 'يجب ان يكون الملف من نوع صور ',
            'image.mimes' => 'يجب ان يكون الملف jpg, png, jpeg',
            'image.max' => 'يجب ان يكون حجم الصورة اصغر من 4096',
        ];
    }
}
