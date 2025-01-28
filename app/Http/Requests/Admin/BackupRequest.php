<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BackupRequest extends FormRequest
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
            'backup_dir' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'backup_dir.required' => 'يجب ان يتم اضافة المجلد الباك اب',
            'backup_dir.string' => 'المجلد غير صحيح حال ان تضع مجلد مقلبول',
        ];
    }
}
