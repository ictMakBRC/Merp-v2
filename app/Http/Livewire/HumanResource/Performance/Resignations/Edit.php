<?php

namespace App\Http\Livewire\HumanResource\Performance\Resignations;

use App\Models\HumanResource\Performance\Resignation;
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

    public $hand_over_date;

    public $comment;

    public $employees;

    public $resignation;

    protected $rules = [
        'employee_id' => 'nullable',
        'comment' => 'nullable',
        'hand_over_date' => 'required',
        'file_upload' => 'file|nullable',
    ];

    public function mount(Resignation $resignation)
    {
        $this->employees = User::all();
        $this->resignation = $resignation;
        $this->hand_over_date = $resignation->hand_over_date;
        $this->comment = $resignation->comment;
    }

    public function download()
    {
        $file = $this->resignation->getFirstMedia();

        return response()->download(
            $file->getPath(),
            "{$file->file_name}"
        );
    }

    public function update()
    {
        $this->validate();

        $this->resignation->update([
            'department_id' => $this->department_id,
            'employee_id' => $this->employee_id,
            'comment' => $this->comment,
            'hand_over_date' => $this->hand_over_date,
        ]);

        if ($this->file_upload) {
            $this->resignation->getFirstMedia()?->delete();
            $this->resignation->addMedia($this->file_upload)->toMediaCollection();
        }

        return redirect()->to(route('resignations'));
    }

    public function render()
    {
        $this->authorize('update', Resignation::class);

        return view('livewire.human-resource.performance.resignations.edit');
    }
}
