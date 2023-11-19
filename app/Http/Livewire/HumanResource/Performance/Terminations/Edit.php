<?php

namespace App\Http\Livewire\HumanResource\Performance\Terminations;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\Performance\Termination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Edit extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public $employee_id;

    public $file_upload;

    public $termination_date;

    public $letter;

    public $reason;

    public $employees;

    public $termination;

    protected $rules = [
        'employee_id' => 'nullable',
        'reason' => 'nullable',
        'letter' => 'required',
        'termination_date' => 'required',
        'file_upload' => 'file|nullable',
    ];

    public function mount(Termination $termination)
    {
        $this->employees = User::all();
        $this->termination = $termination;
        $this->termination_date = $termination->termination_date;
        $this->reason = $termination->reason;
        $this->letter = $termination->letter;
    }

    public function download()
    {
        $file = $this->termination->getFirstMedia();
        return response()->download(
            $file->getPath(),
            "{$file->file_name}"
        );
    }


    public function update()
    {
        $this->validate();

        $this->termination->update([
            'employee_id' => $this->employee_id,
            'reason' => $this->reason,
            'letter' => $this->letter,
            'termination_date' => $this->termination_date
           ]);

        if($this->file_upload) {
            $this->termination->getFirstMedia()?->delete();
            $this->termination->addMedia($this->file_upload)->toMediaCollection();
        }
        return redirect()->to(route('terminations'));
    }

    public function render()
    {
        // $this->authorize('update', Termination::class);
        return view('livewire.human-resource.performance.terminations.edit');
    }
}
