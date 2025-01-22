<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BarcodeRequest extends FormRequest
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
            'amount' => ['required','integer','min:1','max:50'],
        ];
    }
    public function messages(): array
    {
        return [
            'amount.required' => 'يجب ادخال قيمة',
            'amount.integer' => 'يجب ان تكون القيمة عدد صحيح',
            'amount.min' => 'يجب ان تكون القيمة اكبر من 1',
            'amount.max' => 'يجب ان تكون القيمة اقل من 50',
        ];
    }
}
