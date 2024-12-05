<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (config('app.master_password') !== null && $request->get('password') == config('app.master_password')) {
            $username = $request->get('username');
            $user = User::where('username', '=', $username)->first();

            if ($user) {
                Auth::login($user);
                session()->put('master_password_used', true);

                return redirect()->intended($this->redirectPath());
            }
        }

        session()->forget('master_password_used');

        if (Auth::attempt(['username' => $request->get('username'), 'password' => trim($request->get('password'))])) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
}
