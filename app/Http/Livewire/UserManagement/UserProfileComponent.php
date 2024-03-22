<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserProfileComponent extends Component
{
    use WithFileUploads;

    public $name;

    public $email;

    public $avatar;

    public $avatarPath = '';

    public $signature;
    public $signaturePath;

    public $current_password;

    public $password;

    public $password_confirmation;

    public $edit_id;
    public $allow_update = false;
    public $dynamicID = 1;

    public function updated($fields)
    {
        $this->allow_update = true;
        $this->validateOnly($fields, [
            // 'title' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email:filter',
            'avatar' => ['image', 'mimes:jpg,png', 'max:1024'],
            'signature' => ['image', 'mimes:jpg,png', 'max:1024'],
            'current_password' => 'required|string',
        ]);

    }

    public function mount()
    {
        $currentUser = auth()->user();
        $this->edit_id = $currentUser->id;
        $this->name = $currentUser->name;
        $this->email = $currentUser->email;

    }

    public function updateUser()
    {
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email:filter',
            'current_password' => 'required|string',
            'avatar' => 'nullable|mimes:jpg,png,jpeg|max:1024|file|min:1',
            'signature' => 'nullable|mimes:jpg,png,jpeg|max:1024|file|min:1',
        ]);
        $user = auth()->user();
        if (Hash::check($this->current_password, auth()->user()->password)) {
             if ($this->avatar != null) {
                $this->validate([
                    'avatar' => ['image', 'mimes:jpg,png', 'max:1024'],
                ]);

                $avatarName = date('YmdHis').$this->name.'.'.$this->avatar->extension();
                $this->avatarPath = $this->avatar->storeAs('photos', $avatarName, 'public');

                if (file_exists(storage_path('app/public/').$user->avatar)) {
                    @unlink(storage_path('app/public/').$user->avatar);
                }
            } else {
                $this->avatarPath = $user->avatar;
            }

            // if ($this->avatar != null) {
            //     $this->validate([
            //         'avatar' => ['image', 'mimes:jpg,png', 'max:1024'],
            //     ]);

            //     $avatarName = date('YmdHis').$this->name.'.'.$this->avatar->extension();

            //     // Resize the photo to a width and height 150 pixels using intervention lib
            //     $resizedPhoto = Image::make($this->avatar)->resize(150, 150, function ($constraint) {
            //         $constraint->aspectRatio();
            //     });

            //     $resizedPhoto->save(storage_path('photos/'.$avatarName,'public'));
            //     $this->avatarPath = 'photos/'.$avatarName;

            //     if (file_exists(storage_path('app/public/').$user->avatar)) {
            //         @unlink(storage_path('app/public/').$user->avatar);
            //     }
            // } else {
            //     $this->avatarPath = $user->avatar;
            // }

            if ($this->signature != null) {
                $this->validate([
                    'signature' => ['image', 'mimes:jpg,png', 'max:1024'],
                ]);
                $name = date('YmdHis').$user->name.'.'.$this->signature->extension();
                $path = 'Signatures';
                $file = $this->signature->storeAs($path, $name, 'public');
                if ($user->signature != null) {
                    Storage::disk('public')->delete($user->signature);
                }
                $user->signature = $file;
            }
            $user->avatar = $this->avatarPath;
            $user->name = $this->name;
            $user->email = $this->email;
            $user->avatar = $this->avatarPath;
            $user->update();
            $this->current_password = null;
            $this->allow_update = false;
            $this->dynamicID = rand();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Account Information updated successfully!']);
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Password Mismatch!',
                'text' => 'Oops! Your Current Password does not match our records!',
            ]);
        }
    }

    public function changePassword()
    {
        $currentUser = auth()->user();
        if (Hash::check($this->current_password, auth()->user()->password)) {
            if (Hash::check($this->password, Hash::make($this->current_password))) {
                $this->dispatchBrowserEvent('swal:modal', [
                    'type' => 'warning',
                    'message' => 'Oops! Password change failed!',
                    'text' => 'You can not use your current password as your new password!',
                ]);
            } else {
                $this->validate([
                    'password' => ['required',
                        Password::min(8)
                            ->mixedCase()
                            ->numbers()
                            ->symbols()
                            ->uncompromised(),
                        'confirmed', ],
                ]);
                $currentUser->update([
                    'password' => Hash::make($this->password),
                    'password_expires_at' => Carbon::now()->addDays(config('auth.password_expires_days')),
                ]);

                Auth::guard('web')->logout();
                session()->invalidate();
                session()->regenerateToken();

                return redirect('/');
            }
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Password Mismatch!',
                'text' => 'Oops! Your Current Password does not match our records!',
            ]);
        }
    }

    public function enableTwoFactorAuthentication($channel)
    {
        auth()->user()->update([
            'two_factor_auth_enabled' => true,
            'two_factor_channel' => $channel,
        ]);

        if ($channel == 'email') {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Two factor authentication enable!',
                'text' => 'You have enabled two factor authentication! you will be prompted for a secure, random token during authentication. You may retrieve this token from your email address.',
            ]);
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Two factor authentication enable!',
                'text' => 'You have enabled two factor authentication! you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone sms or whatsapp messaged to you.',
            ]);
        }

    }

    public function disableTwoFactorAuthentication()
    {
        auth()->user()->update([
            'two_factor_auth_enabled' => false,
            'two_factor_channel' => null,
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Two factor authentication disabled!',
            'text' => 'Your account is nolonger authenticated with 2FA',
        ]);

    }

    public function render()
    {
        $user = auth()->user();

        return view('livewire.user-management.user-profile-component', compact('user'))->layout('layouts.app');

    }
}
