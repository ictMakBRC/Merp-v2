<?php

namespace App\Http\Livewire\HumanResource\Performance\Appraisals;

use App\Models\HumanResource\Performance\Appraisal;
use App\Models\HumanResource\Settings\Department;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public $department_id;

    public $employee_id;

    public $start_date;

    public $end_date;

    public $file_upload;

    public $departments;

    public $employees;

    public $appraisal;

    protected $rules = [
        'department_id' => 'nullable',
        'employee_id' => 'nullable',
        'start_date' => 'required',
        'end_date' => 'required',
        'file_upload' => 'file|nullable',
    ];

    public function mount(Appraisal $appraisal)
    {
        $this->appraisal = $appraisal;
        $this->department_id = $appraisal->department_id;
        $this->employee_id = $appraisal->employee_id;
        $this->start_date = $appraisal->start_date;
        $this->end_date = $appraisal->end_date;
        $this->departments = Department::all();
        $this->employees = User::all();
    }

    public function update()
    {
        $this->validate();

        $this->appraisal->update([
            'department_id' => $this->department_id,
            'employee_id' => $this->employee_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        $this->appraisal->addMedia($this->file_upload)->toMediaCollection();

        return redirect()->to(route('appraisals'));
    }

    public function render()
    {
        $this->authorize('update', Appraisal::class);

        return view('livewire.human-resource.performance.appraisals.edit');
    }
}
