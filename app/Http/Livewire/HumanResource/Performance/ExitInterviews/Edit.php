<?php

namespace App\Http\Livewire\HumanResource\Performance\ExitInterviews;

use App\Models\HumanResource\Performance\ExitInterview;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public $employee_id;

    public $file_upload;

    public $employees;

    public $exitInterview;

    protected $rules = [
        'employee_id' => 'nullable',
        'file_upload' => 'file|nullable',
    ];

    public function mount(ExitInterview $exitInterview)
    {
        $this->employees = User::all();
        $this->exitInterview = $exitInterview;
        $this->employee_id = $exitInterview->employee_id;
    }

    public function download()
    {
        $file = $this->exitInterview->getFirstMedia();

        return response()->download(
            $file->getPath(),
            "{$file->file_name}"
        );
    }

    public function update()
    {

        $this->validate();

        $this->exitInterview->update([
            'department_id' => $this->department_id,
            'employee_id' => $this->employee_id,
        ]);
        if ($this->file_upload) {
            $this->exitInterview->getFirstMedia()?->delete();
            $this->exitInterview->addMedia($this->file_upload)->toMediaCollection();
        }

        return redirect()->to(route('exit-interviews'));
    }

    public function render()
    {
        $this->authorize('update', ExitInterview::class);

        return view('livewire.human-resource.performance.exit-interviews.edit');
    }
}
