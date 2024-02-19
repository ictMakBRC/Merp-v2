<?php

namespace App\Http\Livewire\HumanResource\Performance\Appraisals;

use App\Models\HumanResource\Performance\Appraisal;
use App\Models\HumanResource\Settings\Configuration;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public $start_date;

    public $end_date;

    public $file_upload;

    public $employees;

    protected $rules = [
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
            'employee_id' => auth()->user()->employee->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        $appraisal->addMedia($this->file_upload)->toMediaCollection();

        return redirect()->to(route('appraisals'));
    }

    public function download()
    {
        $appraisal = Configuration::where('key', 'appraisal_letter')->first();
        $mediaItem = $appraisal->getFirstMedia();
        return response()->download($mediaItem->getPath(), $mediaItem->file_name);
    }

    public function render()
    {
        $this->authorize('create', Appraisal::class);
        return view('livewire.human-resource.performance.appraisals.create');
    }
}
