<?php

namespace App\Http\Livewire\HumanResource\Performance\Terminations;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\Performance\Termination;

class Edit extends Component
{
    use WithFileUploads;

    public $department_id;

    public $employee_id;

    public $file_upload;

    public $termination_date;

    public $reason;

    public $departments;

    public $employees;

    public $termination;

    protected $rules = [
        'department_id' => 'nullable',
        'employee_id' => 'nullable',
        'reason' => 'nullable',
        'termination_date' => 'required',
        'file_upload' => 'file|nullable',
    ];

    public function mount(Termination $termination)
    {
        $this->departments = Department::all();
        $this->employees = User::all();
        $this->termination = $termination;
        $this->department_id = $termination->department_id;
        $this->termination_date = $termination->termination_date;
        $this->reason = $termination->reason;
    }

    public function download()
    {
        $file = $this->termination->getFirstMedia();
        return response()->download(
            $file->getPath(),
            "{$file->file_name}"
        );
    }


    public function update()
    {
        $this->validate();

        $this->termination->update([
            'department_id' => $this->department_id,
            'employee_id' => $this->employee_id,
            'reason' => $this->reason,
            'termination_date' => $this->termination_date
           ]);

        if($this->file_upload) {
            $this->termination->getFirstMedia()?->delete();
            $this->termination->addMedia($this->file_upload)->toMediaCollection();
        }
        return redirect()->to(route('terminations'));
    }

    public function render()
    {
        return view('livewire.human-resource.performance.terminations.edit');
    }
}
