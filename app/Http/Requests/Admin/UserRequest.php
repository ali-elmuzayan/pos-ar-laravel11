<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class UserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string',  'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:4096'],
            'role' => ['required', 'in:admin,user'],
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
            'password.required' => 'كلمة المرور مطلوبة',
            'password.confirmed' => 'كلمة المرور غير مطابقة',
            'password.min' => 'يجب ان يكون عدد الحروف اكبر من 6 احرف',
            'password.max' => 'يجب ان يكون عدد الحروف اقل من 30 احرف',
            'role.required' => 'دور المستخدم مطلوبة',
            'role.in' => 'يجب ان يكون دور المستخدم اما مستخدم او ادمن',
            'image.image' => 'يجب ان يكون الملف من نوع صور ',
            'image.mimes' => 'يجب ان يكون الملف jpg, png, jpeg',
            'image.max' => 'يجب ان يكون حجم الصورة اصغر من 4096',
        ];
    }
}
