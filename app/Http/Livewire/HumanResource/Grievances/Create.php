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

    protected $rules = [
        'grievance_type_id' => 'required',
        'addressee' => 'required',
        'file_upload' => 'file|required',
        'description' => 'nullable'
    ];

    public function mount()
    {
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
        return view('livewire.human-resource.grievances.create');
    }
}
