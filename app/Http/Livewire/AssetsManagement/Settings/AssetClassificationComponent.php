<?php

namespace App\Http\Livewire\AssetsManagement\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Assets\Settings\AssetClassification;

class AssetClassificationComponent extends Component
{
   
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $classificationIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $description;

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
            'description' => 'nullable|string',
        ]);
    }

    public function storeAssetClassification()
    {
        $this->validate([
            'name' => 'required|string|unique:asset_classifications',
            'description' => 'nullable|string',
        ]);

        $classification = new AssetClassification();
        $classification->name = $this->name;
        $classification->description = $this->description;
        $classification->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Asset Classification created successfully!']);
    }

    public function editData(AssetClassification $classification)
    {
        $this->edit_id = $classification->id;
        $this->name = $classification->name;
        $this->description = $classification->description;
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
        $this->reset(['name','description','edit_id']);
    }

    public function updateAssetClassification()
    {
        $this->validate([
            'name' => 'required|unique:asset_classifications,name,'.$this->edit_id.'',
            'description' => 'nullable|string',
        ]);

        $classification = AssetClassification::find($this->edit_id);
        $classification->name = $this->name;
        $classification->description = $this->description;
        $classification->update();

        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Asset Classification updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->classificationIds) > 0) {
            // return (new AssetClassificationExport($this->departmentIds))->download('AssetClassification_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'info',
                'message' => 'Oops! Not Found!',
                'text' => 'No Asset Classification selected for export!',
            ]);
        }
    }

    public function filterAssetClassification()
    {
        $classifications = AssetClassification::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->classificationIds = $classifications->pluck('id')->toArray();

        return $classifications;
    }

    public function render()
    {
        $data['classifications'] = $this->filterAssetClassification()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.assets-management.settings.asset-classification-component',$data)->layout('layouts.app');
    }
}
