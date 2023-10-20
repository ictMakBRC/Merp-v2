<?php

namespace App\Http\Livewire\HumanResource\Performance\Appraisals;

use App\Models\HumanResource\GrievanceType;
use App\Models\HumanResource\Performance\Appraisal;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class MyAppraisals extends Component
{
    use WithPagination;

    //Filters

    public $appraisalIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $slug;

    public $is_active = 1;

    public $description;

    public $totalMembers;

    public $delete_id;

    public $edit_id;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public $selectedGrievanceType = null;

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required|unique:hr_grievance_types',
            'description' => 'nullable',
        ]);

        GrievanceType::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
        ]);

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Grievance Type created successfully!']);
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
            'name' => 'required|string',
            'is_active' => 'required|numeric',
            'description' => 'nullable|string',
        ]);
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

    public function deleteData($grievanceTypeId)
    {
        $this->selectedGrievanceType = $grievanceTypeId;
    }

    public function close()
    {
        $this->resetInputs();
    }

    public function resetInputs()
    {
        $this->reset(['name', 'is_active', 'description']);
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required|unique:hr_grievance_types,name,'.$this->edit_id.'',
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
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Grievance Type updated successfully!']);
    }

    public function delete()
    {
        $grievanceType = GrievanceType::findOrFail($this->selectedGrievanceType);
        $grievanceType->delete();

        $this->dispatchBrowserEvent('close-modal');

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Grievance Type deleted successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    /**
     * updating name
     */
    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function filterMyAppraisals()
    {
        $user = auth()->user();
        $appraisals = Appraisal::search($this->search)
            ->where('employee_id', '!=', null)
            ->where('employee_id', $user->employee?->id);

        $this->appraisalIds = $appraisals->pluck('id')->toArray();

        return $appraisals;
    }

    public function render()
    {
        $data['appraisals'] = $this->filterMyAppraisals()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.human-resource.performance.appraisals.my-appraisals', $data)->layout('layouts.app');
    }
}
