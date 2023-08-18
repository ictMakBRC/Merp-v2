<?php

namespace App\Http\Livewire\HumanResource\Performance\Terminations;

use App\Models\HumanResource\Performance\Termination;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\HumanResource\Settings\Department;

class Create extends Component
{
    use WithFileUploads;

    public $department_id;

    public $employee_id;

    public $file_upload;

    public $departments;

    public $termination_date;

    public $reason;

    public $employees;

    protected $rules = [
        'department_id' => 'nullable',
        'employee_id' => 'nullable',
        'reason' => 'required',
        'termination_date' => 'required',
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

        $termination = Termination::create([
                'department_id' => $this->department_id,
                'employee_id' => $this->employee_id,
                'termination_date' => $this->termination_date,
                'reason' => $this->reason
           ]);

        $termination->addMedia($this->file_upload)->toMediaCollection();

        return redirect()->to(route('terminations'));
    }

    public function render()
    {
        return view('livewire.human-resource.performance.terminations.create');
    }
}
