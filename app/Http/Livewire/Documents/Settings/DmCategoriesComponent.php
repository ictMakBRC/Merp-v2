<?php

namespace App\Http\Livewire\Documents\Settings;

use App\Models\Documents\Settings\DmCategory;
use Livewire\Component;
use Livewire\WithPagination;

class DmCategoriesComponent extends Component
{
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $categoryIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $parent_id;

    public $is_active = 1;

    public $description;

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
            'description' => 'nullable|string',
            'parent_id' => 'nullable|integer',
        ]);
    }

    public function storeDocCategory()
    {
        $this->validate([
            'name' => 'required|string|unique:dm_categories',
            'is_active' => 'required|numeric',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|integer',

        ]);
        // dd($this->parent_id);
        $category = new DmCategory();
        $category->name = $this->name;
        $category->is_active = $this->is_active;
        $category->code = time();
        if ($this->parent_id != '') {
            $category->parent_id = $this->parent_id;
        }
        $category->description = $this->description;
        $category->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'category created successfully!']);
    }

    public function editData(DmCategory $category)
    {
        $this->edit_id = $category->id;
        $this->name = $category->name;
        $this->is_active = $category->is_active;
        $this->parent_id = $category->parent_id;
        $this->description = $category->description;
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

    public function updateDocCategory()
    {
        $this->validate([
            'name' => 'required|unique:dm_categories,name,'.$this->edit_id.'',
            'is_active' => 'required|numeric',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|integer',
        ]);

        $category = DmCategory::find($this->edit_id);
        $category->name = $this->name;
        $category->is_active = $this->is_active;
        $category->parent_id = $this->parent_id;
        $category->description = $this->description;
        $category->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'category updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->categoryIds) > 0) {
            // return (new categorysExport($this->categoryIds))->download('categorys_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No categorys selected for export!',
            ]);
        }
    }

    public function filterCategories()
    {
        $categorys = DmCategory::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->categoryIds = $categorys->pluck('id')->toArray();

        return $categorys;
    }

    public function render()
    {
        $data['categories'] = $this->filterCategories()->with('parent')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.documents.settings.dm-categories-component', $data);
    }
}
