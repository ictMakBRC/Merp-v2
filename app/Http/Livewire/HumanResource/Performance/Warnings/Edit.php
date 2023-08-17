<?php

namespace App\Http\Livewire\HumanResource\Performance\Warnings;

use App\Models\HumanResource\Performance\Warning;
use App\Models\User;
use Livewire\Component;

use Livewire\WithFileUploads;
use App\Models\HumanResource\Settings\Department;

class Edit extends Component
{
    use WithFileUploads;

    public $department_id;

    public $employee_id;

    public $reason;

    public $file_upload;

    public $departments;

    public $employees;

    public $warning;

    protected $rules = [
        'department_id' => 'nullable',
        'employee_id' => 'nullable',
        'reason' => 'required',
        'file_upload' => 'file|nullable',
    ];

    public function mount(Warning $warning)
    {
        $this->departments = Department::all();
        $this->employees = User::all();
        $this->warning = $warning;
        $this->department_id = $warning->department_id;
        $this->employee_id = $warning->employee_id;
        $this->reason = $warning->reason;
    }


    public function update()
    {
        $this->validate();

        $this->warning->update([
                 'department_id' => $this->department_id,
                 'employee_id' => $this->employee_id,
                 'reason' => $this->description
            ]);

        $this->warning->addMedia($this->file_upload)->toMediaCollection();

        return redirect()->to(route('warnings'));
    }

    public function render()
    {
        return view('livewire.human-resource.performance.warnings.edit');
    }
}
