<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ShouldResetPassword
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
        if (Auth::check()) {
            if (Auth::user()->should_change_password) {
                return redirect('/force_password_reset')
                    ->with('response', [
                        'error'   => 0,
                        'message' => 'You need to change your password to a new one.'
                    ]);
            }
        }

        return $next($request);
    }
}
