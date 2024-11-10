<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckSuspend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_active == 0) {
            auth()->logout();
            return redirect()->route('login')->withMessage('Akun anda telah dinonaktifkan. Hubungi administrator untuk info lebih lanjut!');
        }
        return $next($request);
    }
}

/*
if (auth()->check() && auth()->user()->banned_until && now()->lessThan(auth()->user()->banned_until)) {
            $banned_days = now()->diffInDays(auth()->user()->banned_until);
            auth()->logout();

            if ($banned_days > 14) {
                $message = 'Your account has been suspended. Please contact administrator.';
            } else {
                $message = 'Your account has been suspended for '.$banned_days.' '.str_plural('day', $banned_days).'. Please contact administrator.';
            }

            return redirect()->route('login')->withMessage($message);
        }
*/