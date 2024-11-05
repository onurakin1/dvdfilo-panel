<?php

namespace App\Responses;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        if (in_array(auth()->user()->level,[4])) {
            //return redirect()->intended(config('fortify.home'));
            return redirect()->route('frontend.home');
        }

        //return redirect()->intended(config('fortify.admin.home'));
        return redirect()->route('backend.dashboard');
    }
}
