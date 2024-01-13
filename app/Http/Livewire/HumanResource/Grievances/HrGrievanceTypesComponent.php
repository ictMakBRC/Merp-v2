<?php

namespace App\Http\Livewire\HumanResource\Grievances;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Models\HumanResource\GrievanceType;

class HrGrievanceTypesComponent extends Component
{
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $slug =1;

    public $description;

    public $slung;

    public $delete_id;

    public $edit_id;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;
    public $exportIds;

    protected $rules = [
        'name' => 'required',
        'slug' => 'required|unique:hr_grievance_types',
        'description' => 'nullable'
    ];

    /**
     * updating name
     */
    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required',
            'slug' => 'required|unique:hr_grievance_types',
            'description' => 'nullable'
        ]);
    }

    public function storeGrievanceType()
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required|unique:hr_grievance_types',
            'description' => 'nullable'

        ]);

        $grievanceType = new GrievanceType();
        $grievanceType->name = $this->name;
        $grievanceType->slug = $this->slug;
        $grievanceType->description = $this->description;
        $grievanceType->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Grievance Type created successfully!']);
    }

    public function editData(GrievanceType $grievanceType)
    {
        $this->edit_id = $grievanceType->id;
        $this->name = $grievanceType->name;
        $this->slug = $grievanceType->slug;
        $this->description = $grievanceType->description;
        $this->createNew = true;
        $this->toggleForm = true;
    }

    public function close()
    {
        $this->createNew = false;
        $this->toggleForm = false;
        $this->resetInputs();
    }

    public function resetInputs()
    {
        $this->reset(['name', 'slug', 'description']);
    }

    public function updateGrievanceType()
    {
        $this->validate([
            'name' => 'required|unique:hr_grievance_types,name,'.$this->edit_id.'',
            'slug' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $grievanceType = GrievanceType::find($this->edit_id);
        $grievanceType->name = $this->name;
        $grievanceType->slug = $this->slug;
        $grievanceType->description = $this->description;
        $grievanceType->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'GrievanceType updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->GrievanceTypeIds) > 0) {
            // return (new GrievanceTypesExport($this->GrievanceTypeIds))->download('GrievanceTypes_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No GrievanceTypes selected for export!',
            ]);
        }
    }

    public function filterGrievanceTypes()
    {
        $grievanceTypes = GrievanceType::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->exportIds = $grievanceTypes->pluck('id')->toArray();

        return $grievanceTypes;
    }

    public function render()
    {
        $data['grievanceTypes'] = $this->filterGrievanceTypes()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.human-resource.grievances.hr-grievance-types-component', $data);
    }
}
