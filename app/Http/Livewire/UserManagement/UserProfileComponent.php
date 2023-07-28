<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserProfileComponent extends Component
{
    use WithFileUploads;

    // public $title;

    public $surname;

    public $first_name;

    public $other_name;

    public $name;

    public $email;

    public $phone_code;

    public $contact;

    public $avatar;

    public $avatarPath = '';

    public $current_password;

    public $password;

    public $password_confirmation;

    public $edit_id;

    public $no_edit = false;

    public $allow_update = false;

    public $theme;

    public $sidebar_color;

    public $header_color;

    public function updated($fields)
    {
        $this->allow_update = true;

        $this->validateOnly($fields, [
            // 'title' => 'required|string',
            'surname' => 'required|string',
            'first_name' => 'required|string',
            'email' => 'required|email:filter',
            'phone_code' => 'required|string',
            'contact' => 'required|string',
            'avatar' => ['image', 'mimes:jpg,png', 'max:1024'],
            'current_password' => 'required|string',
        ]);

    }

    public function updatedTheme()
    {
        Auth::user()->update(['color_scheme' => $this->theme,
            'header_color' => null,
            'sidebar_color' => null]);
        $this->dispatchBrowserEvent('switch-theme', ['theme' => $this->theme]);
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Color theme updated successfully!']);
    }

    public function updateHeaderColor($color)
    {
        Auth::user()->update(['header_color' => $color]);
        $this->dispatchBrowserEvent('switch-header-color', ['color' => $color]);
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Color theme updated successfully!']);
    }

    public function updateSidebarColor($color)
    {
        Auth::user()->update(['sidebar_color' => $color]);
        $this->dispatchBrowserEvent('switch-sidebar-color', ['color' => $color]);
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Color theme updated successfully!']);
    }

    public function mount()
    {
        $currentUser = User::with('institution', 'trainer', 'nominee')->where('id', auth()->user()->id)->first();
        $this->edit_id = $currentUser->id;
        // $this->title = $currentUser->title;
        $this->surname = $currentUser->surname;
        $this->first_name = $currentUser->first_name;
        $this->other_name = $currentUser->other_name;
        $this->name = $currentUser->name;

        if (Str::contains($currentUser->contact, '-')) {

            $this->contact = explode('-', $currentUser->contact)[1];
            $this->phone_code = explode('-', $currentUser->contact)[0];
        } else {
            $this->contact = $currentUser->contact;
        }

        $this->email = $currentUser->email;

        if ($currentUser->trainer || $currentUser->nominee) {
            $this->no_edit = true;
        }

        $this->theme = auth()->user()->color_scheme;
    }

    public function updateUser()
    {
        $this->validate([
            // 'title' => 'required|string',
            'surname' => 'required|string',
            'first_name' => 'required|string',
            'phone_code' => 'required|string',
            'contact' => 'required|string',
            'email' => 'required|email:filter',
            'current_password' => 'required|string',
        ]);
        $user = auth()->user();
        if (Hash::check($this->current_password, auth()->user()->password)) {
            if ($this->avatar != null) {
                $this->validate([
                    'avatar' => ['image', 'mimes:jpg,png', 'max:1024'],
                ]);

                $avatarName = date('YmdHis').$this->surname.'.'.$this->avatar->extension();

                // Resize the photo to a width and height 150 pixels using intervention lib
                $resizedPhoto = Image::make($this->avatar)->resize(150, 150, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $resizedPhoto->save(storage_path('app/public/photos/'.$avatarName));
                $this->avatarPath = 'photos/'.$avatarName;

                if (file_exists(storage_path('app/public/').$user->avatar)) {
                    @unlink(storage_path('app/public/').$user->avatar);
                }
            } else {
                $this->avatarPath = $user->avatar;
            }

            // if ($this->avatar != null) {
            //     $this->validate([
            //         'avatar' => ['image', 'mimes:jpg,png', 'max:100'],
            //     ]);

            //     $avatarName = date('YmdHis').$this->surname.'.'.$this->avatar->extension();
            //     $this->avatarPath = $this->avatar->storeAs('photos', $avatarName, 'public');

            //     if (file_exists(storage_path('app/public/').$user->avatar)) {
            //         @unlink(storage_path('app/public/').$user->avatar);
            //     }
            // } else {
            //     $this->avatarPath = $user->avatar;
            // }

            if ($this->no_edit) {
                $user->avatar = $this->avatarPath;
            } else {
                // $user->title = $this->title;
                $user->surname = $this->surname;
                $user->first_name = $this->first_name;
                $user->other_name = $this->other_name;
                $user->name = $this->first_name;
                $user->contact = $this->phone_code.'-'.$this->contact;
                $user->email = $this->email;
                $user->avatar = $this->avatarPath;
            }

            $user->update();
            $this->current_password = null;
            $this->allow_update = false;
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
                    'password_updated_at' => now(),
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
        $user = User::with('institution')->where('id', auth()->user()->id)->first();

        return view('livewire.user-management.user-profile-component', compact('user'))->layout('layouts.app');

    }
}
