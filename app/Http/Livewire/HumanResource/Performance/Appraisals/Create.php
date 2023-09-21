<?php

namespace App\Http\Livewire\HumanResource\Performance\Appraisals;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\Performance\Appraisal;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Create extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public $employee_id;

    public $start_date;

    public $end_date;

    public $file_upload;

    public $employees;

    protected $rules = [
        'employee_id' => 'nullable',
        'start_date' => 'required',
        'end_date' => 'required',
        'file_upload' => 'file|nullable',
    ];

    public function mount()
    {
        $this->employees = User::all();
    }


    public function store()
    {
        $this->validate();

        $appraisal = Appraisal::create([
               'employee_id' => $this->employee_id,
               'start_date' => $this->start_date,
               'end_date' => $this->end_date,
           ]);

        $appraisal->addMedia($this->file_upload)->toMediaCollection();

        return redirect()->to(route('appraisals'));
    }

    public function render()
    {
        $this->authorize('create', Appraisal::class);
        return view('livewire.human-resource.performance.appraisals.create');
    }
}
