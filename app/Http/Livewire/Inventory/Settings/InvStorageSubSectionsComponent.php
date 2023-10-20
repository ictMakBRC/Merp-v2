<?php

namespace App\Http\Livewire\Inventory\Settings;

use App\Models\Inventory\Settings\InvStorageBin;
use App\Models\Inventory\Settings\InvStorageSection;
use Livewire\Component;
use Livewire\WithPagination;

class InvStorageSubSectionsComponent extends Component
{
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $sectionIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $is_active = 1;

    public $description;

    public $section_id;

    public $totalMembers;

    public $delete_id;

    public $edit_id;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

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
            'is_active' => 'required|integer',
            'section_id' => 'required|integer',
            'description' => 'nullable|string',
        ]);
    }

    public function storeInvStorageBin()
    {
        $this->validate([
            'name' => 'required|string|unique:inv_storage_bins',
            'is_active' => 'required|numeric',
            'section_id' => 'required|integer',
            'description' => 'nullable|string',

        ]);

        $section = new InvStorageBin();
        $section->name = $this->name;
        $section->is_active = $this->is_active;
        $section->section_id = $this->section_id;
        $section->description = $this->description;
        $section->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'section created successfully!']);
    }

    public function editData(InvStorageBin $section)
    {
        $this->edit_id = $section->id;
        $this->name = $section->name;
        $this->section_id = $section->section_id;
        $this->is_active = $section->is_active;
        $this->description = $section->description;
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
        $this->reset(['name', 'is_active', 'description']);
    }

    public function updateInvStorageBin()
    {
        $this->validate([
            'name' => 'required|unique:inv_storage_bins,name,'.$this->edit_id.'',
            'is_active' => 'required|numeric',
            'section_id' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $section = InvStorageBin::find($this->edit_id);
        $section->name = $this->name;
        $section->section_id = $this->section_id;
        $section->is_active = $this->is_active;
        $section->description = $this->description;
        $section->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'section updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->sectionIds) > 0) {
            // return (new sectionsExport($this->sectionIds))->download('sections_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No sections selected for export!',
            ]);
        }
    }

    public function filterStorageBins()
    {
        $sections = InvStorageBin::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->sectionIds = $sections->pluck('id')->toArray();

        return $sections;
    }

    public function render()
    {
        $data['storageBins'] = $this->filterStorageBins()->with('storageSection')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        $data['sections'] = InvStorageSection::where('is_active', 1)->get();

        return view('livewire.inventory.settings.storage-bin-sections-component', $data);
    }
}
