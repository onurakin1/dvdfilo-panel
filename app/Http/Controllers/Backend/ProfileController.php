<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\AccountPasswordChangeRequest;
use App\Http\Requests\Profile\AccountUpdateRequest;
use App\Repositories\Eloquent\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{

    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function edit(): Response
    {
        $user = $this->userRepository->getAuthUser();

        return Inertia::render('Admin/Profile/Profile', ['user' => $user]);
    }

    public function accountUpdate(AccountUpdateRequest $request): RedirectResponse
    {
        $user = $this->userRepository->getAuthUser();

        if (isset($request['photo'])) {
            $user->updateProfilePhoto($request['photo']);
        }

        $attributes = [
            'name' => $request['name'],
            'email' => $request['email'],
        ];

        $this->userRepository->updateAuthUser($attributes);

        session()->flash('success', 'Hesap bilgileriniz başarıyla güncellendi.');

        return redirect()->back();
    }

    public function passwordChange(AccountPasswordChangeRequest $request)
    {

        $this->userRepository->updateAuthUser(['password' => $request->password]);

        session()->flash('success', 'Parola güncellemesi başarıyla yapıldı.');

        return redirect()->back();
    }
}
