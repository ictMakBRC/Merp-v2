<?php

namespace App\Http\Livewire\UserManagement;

use App\Exports\UsersExport;
use App\Models\Role;
use App\Models\User;
use App\Notifications\SendPasswordNotification;
use App\Services\GeneratorService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class UsersComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    //Filters

    public $user_category;

    public $from_date;

    public $to_date;

    public $user_status;

    public $userIds;

    public $perPage = 50;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    // public $title;

    public $name;

    public $category;

    public $email;
    public $signaturePath;
    public $signature;

    public $role_id;

    public $roles_array = [];

    public $is_active;

    public $password;

    public $delete_id;

    public $edit_id;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $generateToken;

    public $token = '';

    public $filter = false;

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    protected $validationAttributes = [
        'is_active' => 'status',
    ];

    public function updatedCategory()
    {
        if (! $this->toggleForm) {
            $this->password = GeneratorService::password();
        }
    }

    public function storeUser()
    {
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email:filter|unique:users',
            'category' => 'required|string',
            'is_active' => 'required|integer|max:3',
            'password' => ['required',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),],
        ]);

        $user = new User();
        DB::transaction(function () use ($user) {
            // $user->title = $this->title;
            $user->name = $this->name;
            $user->category = $this->category;
            $user->email = $this->email;
            $user->password = Hash::make($this->password);
            if ($this->signature != null) {
                $this->validate([
                    'signature' => ['image', 'mimes:jpg,png', 'max:100'],
                ]);
    
                $signatureName = date('YmdHis').$this->name.'.'.$this->signature->extension();
                $this->signaturePath = $this->signature->storeAs('signatures', $signatureName, 'public');
            } else {
                $this->signaturePath = null;
            }
    
            $user->signature = $this->signature;
            $user->save();

            if ($this->role_id) {
                $user->attachRole($this->role_id);
            }
            $this->role_id = null;

            // if (count($this->roles_array) > 0) {
            //     $user->syncRoles($this->roles_array);
            // }
            // $this->roles_array = [];

        });

        if ($this->category == 'External-Application') {
            if ($this->generateToken) {
                $this->token = $user->createToken('api_token')->plainTextToken;
                $this->dispatch('alert', ['type' => 'success',  'message' => 'External application details created successfully']);
                $this->dispatch('swal:modal', [
                    'type' => 'success',
                    'message' => 'Token Generated successfully',
                    'text' => 'Please copy and securely send the token to the respective institution for integration with MERP',
                ]);
            } else {
                $this->dispatch('alert', ['type' => 'success',  'message' => 'External application details created successfully']);
            }

        } else {

            $greeting = 'Hello'.' '.$this->name;
            $body = 'Your password is'.' '.$this->password;
            $actiontext = 'Click here to Login';
            $details = [
                'greeting' => $greeting,
                'body' => $body,
                'actiontext' => $actiontext,
                'actionurl' => url('/'),
            ];

            try {
                Notification::send($user, new SendPasswordNotification($details));
                $this->dispatch('alert', ['type' => 'success',  'message' => 'User created and password sent successfully']);
            } catch (\Exception $error) {
                $this->dispatch('swal:modal', [
                    'type' => 'error',
                    'message' => 'Oops! Email not Sent!',
                    'text' => 'Something went wrong and the password could not be sent to user email address',
                ]);
            }

        }

        $this->resetInputs();
    }

    public function editData($id)
    {
        $user = User::findOrFail($id);
        $this->edit_id = $user->id;
        $this->name = $user->name;
        $this->category = $user->category;
        $this->email = $user->email;
        $this->is_active = $user->is_active;

        $this->createNew = true;
        $this->toggleForm = true;
    }

    public function updateUser()
    {
        $this->validate([
            'category' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email:filter',
            'is_active' => 'required|integer|max:3',
        ]);

        $user = User::findOrFail($this->edit_id);

        try {
            DB::transaction(function () use ($user) {
                $user->name = $this->first_name;
                $user->email = $this->email;
                $user->is_active = $this->is_active;

                if ($this->signature != null) {
                    $this->validate([
                        'signature' => ['image', 'mimes:jpg,png', 'max:100'],
                    ]);
        
                    $signatureName = date('YmdHis').$this->name.'.'.$this->signature->extension();
                    $this->signaturePath = $this->signature->storeAs('signatures', $signatureName, 'public');
        
                    if (file_exists(storage_path().$user->signature)) {
                        @unlink(storage_path().$user->signature);
                    }
                } else {
                    $this->signaturePath = $user->signature;
                }
                $user->signature = $this->signaturePath;
        
                $user->update();;

                $this->resetInputs();
                $this->createNew = false;
                $this->toggleForm = false;
                $this->dispatch('alert', ['type' => 'success',  'message' => 'User updated successfully!']);
            });

        } catch (\Throwable $th) {
            $this->dispatch('swal:modal', [
                'type' => 'error',
                'message' => 'Operation failed!',
                'text' => 'Oops! Something went wrong and the operation could not be performed. Please try again',
            ]);
        }
    }

    public function resetInputs()
    {
        $this->reset(['edit_id', 'password','category', 'email','is_active', 'generateToken']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function resetToken()
    {
        $this->token = '';
    }



    public function export()
    {
        if (count($this->userIds) > 0) {
            return (new UsersExport($this->userIds))->download('Users_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatch('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No Users selected for export!',
            ]);
        }
    }

    public function filterUsers()
    {
        $users = User::search($this->search)
            ->when($this->user_status != '', function ($query) {
                $query->where('is_active', $this->user_status);
            }, function ($query) {
                return $query;
            })
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->userIds = $users->pluck('id')->toArray();

        return $users;
    }

    public function render()
    {
        $roles = Role::orderBy('name', 'asc')->get();

        $users = $this->filterUsers()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.user-management.users-component', compact('users','roles'))->layout('layouts.app');
    }
}
