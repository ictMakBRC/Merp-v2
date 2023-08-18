<?php

namespace App\Http\Livewire\HumanResource\Performance\Resignations;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\Performance\Resignation;

class Create extends Component
{
    use WithFileUploads;

    public $department_id;

    public $employee_id;

    public $file_upload;

    public $departments;

    public $employees;

    protected $rules = [
        'department_id' => 'nullable',
        'employee_id' => 'nullable',
        'reason' => 'required',
        'file_upload' => 'file|nullable',
    ];

    public function mount()
    {
        $this->departments = Department::all();
        $this->employees = User::all();
    }


    public function store()
    {
        $this->validate();

        $resignation = Resignation::create([
                'department_id' => $this->department_id,
                'employee_id' => $this->employee_id,
                'reason' => $this->description
           ]);

        $resignation->addMedia($this->file_upload)->toMediaCollection();

        return redirect()->to(route('resignations'));
    }

    public function render()
    {
        return view('livewire.human-resource.performance.resignations.create');
    }
}
