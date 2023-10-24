<?php

namespace App\Http\Livewire\HumanResource\Grievances;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\HumanResource\Grievance;
use App\Models\HumanResource\GrievanceType;

class Edit extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $grievance_type_id;

    public $addressee;

    public $file_upload;

    public $description;

    public $grievanceTypes;

    protected $rules = [
        'grievance_type_id' => 'required',
        'addressee' => 'required',
        'file_upload' => 'file|nullable',
        'description' => 'nullable'
    ];

    public function mount(Grievance $grievance)
    {
        $this->grievance_type_id = $grievance->grievance_type_id;
        $this->addressee = $grievance->addressee;
        $this->description = $grievance->comment;
        $this->grievanceTypes = GrievanceType::all();
    }


    public function store()
    {
        $this->validate();

        $grievance = Grievance::create([
               'grievance_type_id' => $this->grievance_type_id,
               'subject' => 'Subject',
               'addressee' => $this->addressee,
               'comment' => $this->description
           ]);

        $grievance->addMedia($this->file_upload)->toMediaCollection();

        return redirect()->to(route('grievances'));
    }

    public function render()
    {
        $this->authorize('update', Grievance::class);
        return view('livewire.human-resource.grievances.edit');
    }
}
