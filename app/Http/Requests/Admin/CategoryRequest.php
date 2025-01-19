<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => ['required', 'min:1', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم الفئة مطلوب',
            'name.min' => 'اسم الفئة يجب ان يزيد عن حرف واحد على الاقل',
            'name.max' => 'اسم الفئة يجب ان يقل عن 255 حرف',
        ];
    }


}
