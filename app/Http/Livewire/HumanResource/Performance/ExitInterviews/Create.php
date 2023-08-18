<?php

namespace App\Http\Livewire\HumanResource\Performance\ExitInterviews;

use App\Models\HumanResource\Performance\ExitInterview;
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

    public $employees;

    protected $rules = [
        'department_id' => 'nullable',
        'employee_id' => 'nullable',
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

        $warning = ExitInterview::create([
                'department_id' => $this->department_id,
                'employee_id' => $this->employee_id,
           ]);

        $warning->addMedia($this->file_upload)->toMediaCollection();

        return redirect()->to(route('exit-interviews'));
    }

    public function render()
    {
        return view('livewire.human-resource.performance.exit-interviews.create');
    }
}
