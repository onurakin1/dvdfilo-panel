<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Gamer;
use App\Models\User;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{


    public function create()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        try {
            $check_user = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
            if (!$check_user) {
                throw new Exception('Kullanıcı Bilgileri Hatalı.');
            }

            $user = User::where('email', $request->email)->whereIn('level', [4])->first();
            if (!$user) {
                throw new Exception('Kullanıcı Bilgileri Hatalı.');
            }

            Auth::login($user);

            return response()->json(['status' => true, 'redirect' => route('frontend.dashboard')]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('frontend.homepage.'. app()->getLocale());
    }

    public function register(RegisterRequest $request)
    {
        try {
            \DB::beginTransaction();

            Gamer::query()->create([
                'username' => $request->username,
                'display_name' => $request->username,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'level' => 4
            ]);


            \DB::commit();
            return response()->json(['status' => true, 'redirect' => route('frontend.homepage.'. app()->getLocale())]);
        } catch (Exception $e) {
            \DB::rollBack();
            return $e;
        }
    }
}
