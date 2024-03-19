<?php

namespace App\Http\Livewire\UserManagement;

use App\Notifications\TwoFactorCode;
use Livewire\Component;

class TwoFactorAuthenticationComponent extends Component
{
    public $token;

    public function verifyToken()
    {
        $this->validate([
            'token' => 'integer|required',
        ]);

        $user = auth()->user();

        if ($this->token == $user->two_factor_code && $user->two_factor_expires_at > now()) {
            $user->resetTwoFactorCode();
// dd('okkkk');
            redirect()->route('home');

        } else {

            $this->reset();
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Invalid token!',
                'text' => 'The Two Factor Code/Token you have entered does not match/is invalid or expired',
            ]);
        }
    }

    public function resendToken()
    {
        // dd('OK)');
        $user = auth()->user();
        $user->generateTwoFactorCode();

        if ($user->two_factor_channel == 'email') {

            // $user->notify(new TwoFactorCode());

        } else {
            // code...
        }

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Token resent',
            'text' => 'The Two Factor Code/Token has been resent successfully',
        ]);
    }

    public function render()
    {
        return view('livewire.user-management.two-factor-authentication-component');
    }
}
