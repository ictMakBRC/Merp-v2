<?php

namespace App\Http\Livewire\HumanResource\Performance\Resignations;

use App\Models\HumanResource\Performance\Resignation;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public $employee_id;

    public $file_uploads;

    public $hand_over_date;

    public $subject;

    public $employees;

    public $letter;

    protected $rules = [
        'employee_id' => 'nullable',
        'subject' => 'nullable',
        'letter' => 'required',
        'hand_over_date' => 'required',
        'file_uploads.*' => 'file|nullable',
    ];

    public function mount()
    {
        $this->employees = User::all();
    }

    public function store()
    {
        $this->validate();

        $resignation = Resignation::create([
            'employee_id' => $this->employee_id,
            'subject' => $this->subject,
            'letter' => $this->letter,
            'hand_over_date' => $this->hand_over_date,
        ]);

        if ($this->file_uploads != []) {
            foreach ($this->file_uploads as $file_upload) {
                $resignation->addMedia($file_upload)->toMediaCollection();
            }
        }

        return redirect()->to(route('resignations'));
    }

    public function render()
    {
        $this->authorize('create', Resignation::class);

        return view('livewire.human-resource.performance.resignations.create');
    }
}
