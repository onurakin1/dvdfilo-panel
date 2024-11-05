<?php

namespace App\Http\Requests\User;

use App\Repositories\Eloquent\Interfaces\UserRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user()->can('create', [auth()->user(), $this->userRepository->getModelClass()]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|min:3|max:190|unique:users|alpha_dash',
            'first_name' => 'nullable|string|max:190|',
            'last_name' => 'nullable|string|max:190|unique:users',
            'email' => 'required|email|max:190|unique:users',
            'password' => 'required|min:6|max:190',
            'level' => 'required|integer|in:2,3,4',
        ];
    }
}
