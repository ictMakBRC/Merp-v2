<?php

namespace App\Http\Livewire\Inventory\Settings;

use App\Models\Inventory\Settings\InvStorageSection;
use App\Models\Inventory\Settings\InvStore;
use Livewire\Component;
use Livewire\WithPagination;

class InvStorageSectionsComponent extends Component
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

    public $store_id;

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
            'store_id' => 'required|integer',
            'description' => 'nullable|string',
        ]);
    }

    public function sectionInvStorageSection()
    {
        $this->validate([
            'name' => 'required|string|unique:inv_storage_sections',
            'is_active' => 'required|numeric',
            'store_id' => 'required|integer',
            'description' => 'nullable|string',

        ]);

        $section = new InvStorageSection();
        $section->name = $this->name;
        $section->is_active = $this->is_active;
        $section->store_id = $this->store_id;
        $section->description = $this->description;
        $section->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'section created successfully!']);
    }

    public function editData(InvStorageSection $section)
    {
        $this->edit_id = $section->id;
        $this->name = $section->name;
        $this->store_id = $section->store_id;
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

    public function updateInvStorageSection()
    {
        $this->validate([
            'name' => 'required|unique:inv_storage_sections,name,'.$this->edit_id.'',
            'is_active' => 'required|numeric',
            'store_id' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $section = InvStorageSection::find($this->edit_id);
        $section->name = $this->name;
        $section->store_id = $this->store_id;
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

    public function filtersections()
    {
        $sections = InvStorageSection::search($this->search)
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
        $data['sections'] = $this->filtersections()->with('store')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        $data['stores'] = InvStore::where('is_active', 1)->get();

        return view('livewire.inventory.settings.storage-sections-component', $data);
    }
}
