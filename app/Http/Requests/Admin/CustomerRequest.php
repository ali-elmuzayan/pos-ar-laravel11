<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
            'name' => ['nullable', 'string'],
            'phone' => ['required', 'string',  Rule::unique('customers', 'phone')->ignore($this->customer),],
            'address' => ['nullable', 'string'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.string' => 'يجب ان يكون اسم العميل من نوع نص',
            'phone.required' => 'يجب ادخال الرقم المحمول',
            'phone.string' => 'يجب ان يكون الرقم المحمول من نوع نص',
            'phone.unique' => 'هذا الرقم مسجل باسم عميل اخر',
            'address.string' => 'يجب ان يكون العنوان من نوع نص',

        ];
    }
}
