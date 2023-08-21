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

    public $employee_id;

    public $reason;

    public $file_upload;

    public $employees;

    public $warning;

    protected $rules = [
        'employee_id' => 'nullable',
        'reason' => 'required',
        'file_upload' => 'file|nullable',
    ];

    public function mount(Warning $warning)
    {
        $this->employees = User::all();
        $this->warning = $warning;
        $this->employee_id = $warning->employee_id;
        $this->reason = $warning->reason;
    }


    public function update()
    {
        $this->validate();

        $this->warning->update([
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
