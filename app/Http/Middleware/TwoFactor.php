<?php

namespace App\Http\Middleware;

use Closure;

class TwoFactor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if (auth()->check() && $user->two_factor_code) {
            if ($user->two_factor_expires_at < now()) { //expired
                $user->resetTwoFactorCode();
                auth()->logout();

                return redirect()->route('login')
                    ->withErrors(['status' => 'The two factor code has expired. Please login again.']);
            }

            if (! $request->is('2fa*')) { //prevent enless loop, otherwise send to verify
                return redirect()->route('two-factor-auth');
            }
        }

        return $next($request);
    }
}
