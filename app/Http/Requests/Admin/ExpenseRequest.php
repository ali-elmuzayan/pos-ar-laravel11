<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
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
            'amount' => 'required|numeric|min:1',
            'details' => 'required',
        ];
    }


    public function messages(): array
    {
        return [
            'amount.required' => 'يجب ان تضيف قيمة او مبلغ صحيح',
            'amount.numeric' => 'يجب ان تكون القيمة رقم صحيح',
            'amount.min' => 'يجب ان تكون القيمة اكبر من 0',
            'details.required' => 'يجب ان تضيف تفاصيل للنفقة',
        ];
    }
}
