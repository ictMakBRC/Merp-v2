<?php

namespace App\Http\Livewire\HumanResource\Performance\Warnings;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\HumanResource\Performance\Warning;
use App\Models\HumanResource\Settings\Department;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Create extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public $employee_id;

    public $file_upload;

    public $employees;

    public $reason;

    public $letter;

    protected $rules = [
        'employee_id' => 'nullable',
        'reason' => 'required',
        'letter' => 'required',
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
                'reason' => $this->reason,
                'letter' => $this->letter
           ]);

        $warning->addMedia($this->file_upload)->toMediaCollection();

        return redirect()->to(route('warnings'));
    }

    public function render()
    {
        $this->authorize('create', Warning::class);
        return view('livewire.human-resource.performance.warnings.create');
    }
}
