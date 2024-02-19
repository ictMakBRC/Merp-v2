<?php

namespace App\Http\Livewire\HumanResource\Grievances;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\HumanResource\Grievance;
use App\Models\HumanResource\GrievanceType;

class Create extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $grievance_type_id;

    public $addressee;

    public $file_upload;

    public $description;

    public $grievanceTypes;

    public $isAnonymous = false;

    protected $rules = [
        'grievance_type_id' => 'required',
        'addressee' => 'required',
        'file_upload' => 'file|nullable',
        'description' => 'nullable',
        'isAnonymous' => 'nullable'
    ];

    public function mount()
    {
        $this->grievanceTypes = GrievanceType::all();
    }


    public function store()
    {
        $this->validate();

        $user = auth()->user();

        $grievance = Grievance::create([
               'grievance_type_id' => $this->grievance_type_id,
               'employee_id' => $this->isAnonymous == false ? $user->employee->id : null,
               'subject' => 'Subject',
               'addressee' => $this->addressee,
               'comment' => $this->description
           ]);

        $grievance->addMedia($this->file_upload)->toMediaCollection();

        return redirect()->to(route('grievances'));
    }

    public function render()
    {
        $this->authorize('create', Grievance::class);
        return view('livewire.human-resource.grievances.create');
    }
}
