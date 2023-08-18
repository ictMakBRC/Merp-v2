<?php

namespace App\Http\Livewire\HumanResource\Performance\ExitInterviews;

use App\Models\HumanResource\Performance\ExitInterview;
use App\Models\User;
use Livewire\Component;

use Livewire\WithFileUploads;
use App\Models\HumanResource\Settings\Department;

class Edit extends Component
{
    use WithFileUploads;

    public $department_id;

    public $employee_id;

    public $file_upload;

    public $departments;

    public $employees;

    public $exitInterview;

    protected $rules = [
        'department_id' => 'nullable',
        'employee_id' => 'nullable',
        'file_upload' => 'file|nullable',
    ];

    public function mount(ExitInterview $exitInterview)
    {
        $this->departments = Department::all();
        $this->employees = User::all();
        $this->exitInterview = $exitInterview;
        $this->department_id = $exitInterview->department_id;
        $this->employee_id = $exitInterview->employee_id;
    }


    public function download()
    {
        $file = $this->exitInterview->getFirstMedia();
        return response()->download(
            $file->getPath(),
            "{$file->file_name}"
        );
    }


    public function update()
    {

        $this->validate();

        $this->exitInterview->update([
                 'department_id' => $this->department_id,
                 'employee_id' => $this->employee_id,
            ]);
        if($this->file_upload) {
            $this->exitInterview->getFirstMedia()?->delete();
            $this->exitInterview->addMedia($this->file_upload)->toMediaCollection();
        }

        return redirect()->to(route('exit-interviews'));
    }

    public function render()
    {
        return view('livewire.human-resource.performance.exit-interviews.edit');
    }
}
