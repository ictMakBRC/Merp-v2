<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use App\Data\User\UserData;
use App\Exports\UsersExport;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Services\GeneratorService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Grants\Project\Project;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendPasswordNotification;
use App\Models\HumanResource\EmployeeData\Employee;

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

    public $user_roles = [];
    public $funder_projects = [];

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

    protected $user;
    public $employee_number;
    public $employee_matched=false;
    public $employee_id;

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
        if (! $this->toggleForm && $this->category!='') {
            $this->password = GeneratorService::password();
        }

        $this->user_roles = [];
        $this->funder_projects = [];
    }

    public function updatedEmployeeNumber()
    {
        $employee = Employee::where('employee_number',$this->employee_number)->first();
        if($employee){
            $this->employee_id=$employee->id;
            $this->name = $employee->first_name;
            $this->email = $employee->email;
            $this->employee_matched=true;
        }else{
            $this->employee_id=null;
            $this->name = null;
            $this->email = null;
            $this->employee_matched=false;
        }
    }

    public function storeUser()
    {
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email:filter|unique:users',
            'category' => 'required|string',
            'employee_number'=>'required_if:category,Normal-User',
            'is_active' => 'required|integer|max:3',
            'password' => ['required',
                Password::min(8)
                    // ->mixedCase()
                    // ->numbers()
                    ->symbols()
                    ->uncompromised(),],
        ]);

        DB::transaction(function (){

            if ($this->signature != null) {
                $this->validate([
                    'signature' => ['image', 'mimes:jpg,png', 'max:100'],
                ]);
    
                $signatureName = date('YmdHis').$this->name.'.'.$this->signature->extension();
                $this->signaturePath = $this->signature->storeAs('signatures', $signatureName, 'public');
            } else {
                $this->signaturePath = null;
            }

            $userDTO = UserData::from([
                'employee_id'=>$this->employee_id??null,
                'name'=>$this->name,
                'category'=>$this->category,
                'email'=>$this->email,
                'password'=>Hash::make($this->password),
                'is_active'=>$this->is_active,
                'signature'=>$this->signaturePath,]
            );

            $userService = new UserService();

            $this->user = $userService->createUser($userDTO);
            if ($this->role_id) {
                $this->user->attachRole($this->role_id);
            }
            $this->role_id = null;
        });

        if ($this->category == 'External-Application') {
            if ($this->generateToken) {
                $this->token = $this->user->createToken('api_token')->plainTextToken;
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'External application details created successfully']);
                $this->dispatchBrowserEvent('swal:modal', [
                    'type' => 'success',
                    'message' => 'Token Generated successfully',
                    'text' => 'Please copy and securely send the token to the respective institution for integration with MERP',
                ]);
            } else {
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'External application details created successfully']);
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
                Notification::send($this->user, new SendPasswordNotification($details));
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'User created and password sent successfully']);
            } catch (\Exception $error) {
                $this->dispatchBrowserEvent('swal:modal', [
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
        // dd($user);
        try {
            DB::transaction(function () use ($user) {
                $user->name = $this->name;
                $user->category = $this->category;
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
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'User updated successfully!']);
            });

        } catch (\Throwable $th) {

            dd($th);
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Operation failed!',
                'text' => 'Oops! Something went wrong and the operation could not be performed. Please try again',
            ]);
        }
    }

    public function resetInputs()
    {
        $this->reset(['employee_id','edit_id', 'password','category', 'email','is_active', 'generateToken','name','signature']);
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
            $this->dispatchBrowserEvent('swal:modal', [
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
            ->when($this->user_category != '', function ($query) {
                $query->where('category', $this->user_category);
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
        $data['roles'] = Role::orderBy('name', 'asc')->get();
        $data['projects'] = Project::orderBy('project_code', 'asc')->get();

        $data['users'] = $this->filterUsers()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.user-management.users-component', $data)->layout('layouts.app');
    }
}
