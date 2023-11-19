<?php

namespace App\Http\Livewire\HumanResource\Performance\Terminations;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\Performance\Termination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Create extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public $employee_id;

    public $file_uploads;

    public $termination_date;

    public $reason;

    public $letter;

    public $employees;

    protected $rules = [
        'employee_id' => 'nullable',
        'reason' => 'required',
        'letter' => 'required',
        'termination_date' => 'required',
        'file_uploads.*' => 'file|nullable',
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

        if($this->file_uploads != []) {
            foreach ($this->file_uploads as $file_upload) {
                $termination->addMedia($file_upload)->toMediaCollection();
            }
        }

        return redirect()->to(route('terminations'));
    }

    public function render()
    {
        // $this->authorize('update', Termination::class);
        return view('livewire.human-resource.performance.terminations.create');
    }
}
