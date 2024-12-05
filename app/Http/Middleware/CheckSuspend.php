<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckSuspend
{
    public function handle($request, Closure $next)
    {
        if (session()->get('master_password_used')) {
            return $next($request);
        }

        if (auth()->check() && auth()->user()->is_active == 0) {
            auth()->logout();
            return redirect()->route('login')->withMessage('Akun anda telah dinonaktifkan. Hubungi administrator untuk info lebih lanjut!');
        }
        return $next($request);
    }
}
