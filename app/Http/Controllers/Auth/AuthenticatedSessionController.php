<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Notifications\TwoFactorCode;
use App\Providers\RouteServiceProvider;
use App\Services\LoginActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = auth()->user();

        if ($user->two_factor_auth_enabled) {
            $user->generateTwoFactorCode();

            if ($user->two_factor_channel == 'email') {

                $user->notify(new TwoFactorCode());

            } else {
                // code...
            }

            return redirect()->route('two-factor-auth');

        } else {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

    }

    /**
     * Display the home view.
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {
        return view('home');
    }

    /**
     * Display the two factor auth form.
     *
     * @return \Illuminate\View\View
     */
    public function twoFactorAuthentication()
    {
        return view('livewire.user-management.access.two-factor-authentication');
    }

    /**
     * Destroy an authenticated session.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        LoginActivityService::addToLog('logged Out', Auth::user()->email, $request->ip());

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
