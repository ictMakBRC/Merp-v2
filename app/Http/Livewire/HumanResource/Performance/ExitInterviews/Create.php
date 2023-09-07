<?php

namespace App\Http\Livewire\HumanResource\Performance\ExitInterviews;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\Performance\ExitInterview;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Create extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public $employee_id;

    public $file_upload;

    public $employees;

    protected $rules = [
        'employee_id' => 'nullable',
        'file_upload' => 'file|nullable',
    ];

    public function mount()
    {
        $this->employees = User::all();
    }


    public function store()
    {
        $this->validate();

        $warning = ExitInterview::create([
                'employee_id' => $this->employee_id,
           ]);

        $warning->addMedia($this->file_upload)->toMediaCollection();

        return redirect()->to(route('exit-interviews'));
    }

    public function render()
    {
        $this->authorize('create', ExitInterview::class);
        return view('livewire.human-resource.performance.exit-interviews.create');
    }
}
