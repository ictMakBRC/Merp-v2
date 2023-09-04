<?php

namespace App\Http\Livewire\HumanResource\Performance\Warnings;

use App\Models\HumanResource\Performance\Warning;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\HumanResource\Settings\Department;

class Create extends Component
{
    use WithFileUploads;

    public $employee_id;

    public $file_upload;

    public $employees;

    public $reason;

    protected $rules = [
        'employee_id' => 'nullable',
        'reason' => 'required',
        'file_upload' => 'file|nullable',
    ];

    public function mount()
    {
        $this->employees = User::all();
    }


    public function store()
    {
        $this->validate();

        $warning = Warning::create([
                'employee_id' => $this->employee_id,
                'reason' => $this->reason
           ]);

        $warning->addMedia($this->file_upload)->toMediaCollection();

        return redirect()->to(route('warnings'));
    }

    public function render()
    {
        return view('livewire.human-resource.performance.warnings.create');
    }
}