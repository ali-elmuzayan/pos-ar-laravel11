<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'code' => ['required', 'unique:products,code'],
            'stock' => ['required', 'numeric'],
            'buying_price' => ['required', 'numeric'],
            'selling_price' => ['required', 'numeric', 'gt:buying_price'],
            'category_id' => ['required', 'exists:categories,id'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'image' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:4096'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'يجب ان تضيف اسما للمنتج',
            'name.string' => 'يجب ان يحتوي الاسم على احرف',
            'code.required' => 'يجب ان تضيف قيمة او رقم صحيح',
            'code.unique' => 'هذا الباركود موجود على منتج اخر',
            'stock.required' => 'يجب ان تضيف قيمة او رقم صحيح',
            'stock.numeric' => 'يجب ان تضيف قيمة او رقم صحيح',
            'buying_price.required' => 'يجب ان تضيف قيمة او رقم صحيح',
            'buying_price.numeric' => 'يجب ان تكون القيمة رقم صحيح',
            'selling_price.numeric' => 'يجب ان تكون القيمة رقم صحيح',
            'selling_price.required' => 'يجب ان تضيف قيمة او رقم صحيح',
            'selling_price.gt' => 'يجب ان يكون سعر البيع اكبر من سعر الشراء',
            'category_id.required' => 'يجب ان تضيف قيمة او رقم صحيح',
            'category_id.exists' => 'هذه الفئة غير موجودة',
            'supplier_id.exists' => 'هذا الموزع غير موجود',
            'image.image' => 'يجب ان يكون الملف من نوع صور ',
            'image.mimes' => 'يجب ان يكون الملف jpg, png, jpeg',
            'image.max' => 'يجب ان يكون حجم الصورة اصغر من 4096',

        ];
    }
}
