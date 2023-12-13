<?php

namespace App\Http\Livewire\Inventory\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Inventory\Settings\InvCategory;

class InvCategoriesComponent extends Component
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
    
        public $is_active =1;
    
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
            ]);
        }
    
        public function storeInvCategory()
        {
            $this->validate([
                'name' => 'required|string|unique:inv_categories',
                'is_active' => 'required|numeric',
                'description' => 'nullable|string',
    
            ]);
    
            $category = new InvCategory();
            $category->name = $this->name;
            $category->is_active = $this->is_active;
            $category->description = $this->description;
            $category->save();
            $this->dispatchBrowserEvent('close-modal');
            $this->resetInputs();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'category created successfully!']);
        }
    
        public function editData(InvCategory $category)
        {
            $this->edit_id = $category->id;
            $this->name = $category->name;
            $this->is_active = $category->is_active;
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
    
        public function updateInvCategory()
        {
            $this->validate([
                'name' => 'required|unique:inv_categories,name,'.$this->edit_id.'',
                'is_active' => 'required|numeric',
                'description' => 'nullable|string',
            ]);
    
            $category = InvCategory::find($this->edit_id);
            $category->name = $this->name;
            $category->is_active = $this->is_active;
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
            $categorys = InvCategory::search($this->search)
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
            $data['categories'] = $this->filterCategories()
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage);
      
            return view('livewire.inventory.settings.inv-categories-component', $data);
        }
}
