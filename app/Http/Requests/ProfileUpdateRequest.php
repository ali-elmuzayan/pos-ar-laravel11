<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($this->user()->id)],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:4096'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'اسم الموظف مطلوب',
            'name.string' => 'اسم الموظف غير صحيح',
            'name.max' => 'يجب ان يكون اسم الموظف اقل من 255 حرف',
            'username.required' => 'اسم المستخدم مطلوب',
            'username.string' => 'اسم المستخدم غير صحيح',
            'username.max' => 'يجب ان يكون اسم المستخدم اقل من 255 حرف',
            'username.unique' => 'اسم المستخدم موجود يجب استخدام اسم اخر',
            'email.required' => 'الايميل مطلوب',
            'email.unique' => 'الايميل موجود يجب استخدام ايميل اخر',
            'image.image' => 'يجب ان تكون الصورة من نوع صورة',
            'image.mimes' => 'يجب ان تكون الصورة منن نوع jpeg, png, jpg, gif, svg',
            'image.max' => 'يجب ان تكون الصورة اقل من 4096byte'
        ];
    }
}
