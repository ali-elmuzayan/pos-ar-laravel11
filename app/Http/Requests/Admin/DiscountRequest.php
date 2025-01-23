<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
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
            'percent' => ['required', 'numeric', 'min:0', 'max:100'],
            'status' => ['required', 'in:0,1'],
            'end_date' => ['nullable', 'date', 'after:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'percent.required' => 'يجب ادخال قيمة صحيحة',
            'percent.numeric' => 'يجب ان تكون القيمة رقم صحيح',
            'percent.min' => 'بحد ادنى 1%',
            'percent.max' => 'بحد اقصى 100%',
            'status.required' => 'يجب ادخال قيمة للحالة ',
            'status.in' => 'يجب ان تكون قيمة بين 0 او 1',
            'end_date.date' => 'التاريخ الذي ادخلته غير صالح',
        ];
    }
}
