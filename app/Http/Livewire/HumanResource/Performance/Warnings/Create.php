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

    public $file_uploads;

    public $employees;

    public $subject;

    public $letter;

    protected $rules = [
        'employee_id' => 'nullable',
        'subject' => 'required',
        'letter' => 'required',
        'file_uploads.*' => 'file|nullable',
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
                'subject' => $this->subject,
                'letter' => $this->letter
           ]);

        if($this->file_uploads != []) {
            foreach ($this->file_uploads as $file_upload) {
                $warning->addMedia($file_upload)->toMediaCollection();
            }
        }

        return redirect()->to(route('warnings'));
    }

    public function render()
    {
        // $this->authorize('create', Warning::class);
        return view('livewire.human-resource.performance.warnings.create');
    }
}
