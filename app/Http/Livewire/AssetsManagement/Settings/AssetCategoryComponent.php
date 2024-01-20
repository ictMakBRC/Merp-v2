<?php

namespace App\Http\Livewire\AssetsManagement\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Assets\Settings\AssetCategory;
use App\Models\Assets\Settings\AssetClassification;

class AssetCategoryComponent extends Component
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

    public $asset_classifications_id;

    public $name;

    public $description;

    public $short_code;

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
            'asset_classifications_id' => 'required|integer',
            'name' => 'required|string',
            'short_code' => 'required|string|unique:asset_categories',
            'description' => 'nullable|string',
        ]);
    }

    public function storeAssetCategory()
    {
        $this->validate([
            'asset_classifications_id' => 'required|integer',
            'name' => 'required|string|unique:asset_categories',
            'short_code' => 'required|string|unique:asset_categories',
            'description' => 'nullable|string',
        ]);

        $category = new AssetCategory();
        $category->asset_classifications_id = $this->asset_classifications_id;
        $category->name = $this->name;
        $category->short_code = $this->short_code;
        $category->description = $this->description;
        $category->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Asset Category created successfully!']);
    }

    public function editData(AssetCategory $category)
    {
        $this->edit_id = $category->id;
        $this->name = $category->name;
        $this->short_code = $category->short_code;
        $this->asset_classifications_id = $category->classification->id;
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
        $this->reset(['asset_classifications_id','name','short_code','description','edit_id']);
    }

    public function updateAssetCategory()
    {
        $this->validate([
            'asset_classifications_id' => 'required|integer',
            'name' => 'required|unique:asset_categories,name,'.$this->edit_id.'',
            'short_code' => 'required|unique:asset_categories,short_code,'.$this->edit_id.'',
            'description' => 'nullable|string',
        ]);

        $category = AssetCategory::find($this->edit_id);
        $category->asset_classifications_id = $this->asset_classifications_id;
        $category->name = $this->name;
        $category->short_code = $this->short_code;
        $category->description = $this->description;
        $category->update();

        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Asset Category updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->categoryIds) > 0) {
            // return (new AssetCategoryExport($this->departmentIds))->download('AssetCategory_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'info',
                'message' => 'Oops! Not Found!',
                'text' => 'No Asset Category selected for export!',
            ]);
        }
    }

    public function filterAssetCategory()
    {
        $categories = AssetCategory::search($this->search)->with('classification')
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->categoryIds = $categories->pluck('id')->toArray();

        return $categories;
    }

    public function render()
    {
        $data['categories'] = $this->filterAssetCategory()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        $data['classifications'] = AssetClassification::all();

        return view('livewire.assets-management.settings.asset-category-component',$data)->layout('layouts.app');
    }
}
