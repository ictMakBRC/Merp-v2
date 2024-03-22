<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserConsent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        if (!$user->information_share_consent) {
            return redirect()->route('home')->with('user_consent', 'Dear '.$user->name.', You must consent to the Privacy and Data Sharing Agreement in order to use MERP');
        }

        return $next($request);
    }
}
