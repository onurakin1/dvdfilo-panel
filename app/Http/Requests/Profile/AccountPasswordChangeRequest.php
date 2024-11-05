<?php

namespace App\Http\Requests\Profile;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class AccountPasswordChangeRequest extends FormRequest
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
            'current_password'=>['required', new MatchOldPassword],
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|min:6'
        ];
    }
}
