<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Registration extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'name' => 'required|string|min:3|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ];

    }
    public function messages()
{
    return [
        'name.required' => 'Введите имя',
        'name.string' => 'Имя должно собержать буквы',
        'name.min' => 'Миниимум 3 символа',
        'name.max' => 'Не более 255 символов',
        'name.unique' => 'Пользователь с таким именем уже зарегистрирован',
        'email.required'=> 'Введите e-mail',
        'email.email' => 'Введите корректный e-mail',
        'email.max' => 'Не более 255 символов',
        'email.unique' => 'Данный e-mail уже зарегистрирован в системе',
        'password.required' => 'Введите пароль',
        'password.string' => 'Пароль должен содержать буквы',
        'password.min' => 'Минимум 8 символов',
        'password.confirmed' => 'Пароли не совпадают',
    ];
}
}
