<?php

namespace App\Http\Livewire\HumanResource\Performance\Resignations;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\HumanResource\Grievance;
use App\Models\HumanResource\GrievanceType;
use App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\Performance\Resignation;

class Edit extends Component
{
    use WithFileUploads;

    public $department_id;

    public $employee_id;

    public $file_upload;

    public $hand_over_date;

    public $comment;

    public $departments;

    public $employees;

    public $resignation;

    protected $rules = [
        'department_id' => 'nullable',
        'employee_id' => 'nullable',
        'comment' => 'nullable',
        'hand_over_date' => 'required',
        'file_upload' => 'file|nullable',
    ];

    public function mount(Resignation $resignation)
    {
        $this->departments = Department::all();
        $this->employees = User::all();
        $this->resignation = $resignation;
        $this->department_id = $resignation->department_id;
        $this->hand_over_date = $resignation->hand_over_date;
        $this->comment = $resignation->comment;
    }

    public function download()
    {
        $file = $this->resignation->getFirstMedia();
        return response()->download(
            $file->getPath(),
            "{$file->file_name}"
        );
    }


    public function update()
    {
        $this->validate();

        $this->resignation->update([
            'department_id' => $this->department_id,
            'employee_id' => $this->employee_id,
            'comment' => $this->comment,
            'hand_over_date' => $this->hand_over_date
           ]);

        if($this->file_upload) {
            $this->resignation->getFirstMedia()?->delete();
            $this->resignation->addMedia($this->file_upload)->toMediaCollection();
        }
        return redirect()->to(route('resignations'));
    }

    public function render()
    {
        return view('livewire.human-resource.performance.resignations.edit');
    }
}
