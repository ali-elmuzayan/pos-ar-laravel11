<?php

namespace App\Http\Requests\Admin;

use App\Models\Supplier;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class updateSupplierRequest extends FormRequest
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
        $supplier = $this->route('supplier');
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50', Rule::unique(Supplier::class)->ignore($supplier->id)],
            'email' => ['nullable', 'email'],
            'address' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:4096'],

        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم الموزع مطلوب',
            'name.string' => 'اسم الموزع غير صحيح',
            'name.max' => 'يجب ان يكون اسم الموزع اقل من 255 حرف',
            'phone.unique' => 'رقم الهاتف موجود يجب استخدام رقم اخر',
            'phone.string' => 'يجب اضافى رقم الهاتف',
            'phone.max' => 'يجب ان يكون رقم هاتف الموزع اقل من 50 حرف',
            'email.email' => 'الايميل يجب ان يكون من نوع ايميل',
            'address.string' => 'العنوان يجب ان يكون نص ',
            'address.max' => 'يجب ان يكون عنوان الموزع اقل من 255 حرف',
            'image.image' => 'يجب ان يكون الملف من نوع صور ',
            'image.mimes' => 'يجب ان يكون الملف jpg, png, jpeg',
            'image.max' => 'يجب ان يكون حجم الصورة اصغر من 4096',
        ];
    }
}
