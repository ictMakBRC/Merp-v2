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

    public $employee_id;

    public $file_upload;

    public $termination_date;

    public $reason;

    public $letter;

    public $employees;

    protected $rules = [
        'employee_id' => 'nullable',
        'reason' => 'required',
        'letter' => 'required',
        'termination_date' => 'required',
        'file_upload' => 'file|nullable',
    ];

    public function mount()
    {
        $this->employees = User::all();
    }


    public function store()
    {
        $this->validate();

        $termination = Termination::create([
                'employee_id' => $this->employee_id,
                'termination_date' => $this->termination_date,
                'letter' => $this->letter,
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
