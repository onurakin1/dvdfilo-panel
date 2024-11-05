<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'username' => 'string',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'agreement' => 'required|accepted'
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'username' => "Kullanıcı Adı",
            'email' => "E-Posta Adresi",
            'password' => "Parola",
            'agreement' => 'Üyelik sözleşmesi'
        ];
    }
}
