<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Login extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8'
        ];

    }
    public function messages()
{
    return [
        'email.required'=> 'Введите e-mail',
        'email.email' => 'Введите корректный e-mail',
        'email.max' => 'Не более 255 символов',
        'password.required' => 'Введите пароль',
        'password.string' => 'Пароль должен содержать буквы',
        'password.min' => 'Минимум 8 символов',
    ];
}
}
