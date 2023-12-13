<?php

namespace App\Http\Livewire\UserManagement;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

class DataPolicyConfirmationComponent extends Component
{
    // public function acceptPolicy()
    // {
    //     auth()->user()->update(['declaration' => true]);

    //     $this->dispatchBrowserEvent('close-modal');
    //     $this->dispatchBrowserEvent('swal:modal', [
    //         'type' => 'success',
    //         'message' => 'Policy accepted!',
    //         'text' => 'Welcome to MERP - The ultimate resource planner !',
    //     ]);
    // }

    // public function declinePolicy()
    // {
    //     auth()->user()->update(['declaration' => false]);

    //     Auth::guard('web')->logout();
    //     session()->invalidate();
    //     session()->regenerateToken();

    //     return redirect('/');
    // }

    public function consent($consentState){
        auth()->user()->update([
            'information_share_consent'=>$consentState,
            // 'consent_date'=>now(),
        ]);

        if($consentState){
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Great!',
                'text' => '...You are good to go....',
            ]);
        return redirect(request()->header('Referer'));


        }else{
            $authenticatedSession = new AuthenticatedSessionController();
            $authenticatedSession->destroy(request());
        }

    }

    public function render()
    {
        return view('livewire.user-management.data-policy-confirmation-component');
    }
}
