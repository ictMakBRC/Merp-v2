<?php

namespace App\Http\Livewire\Finance\Settings;

use App\Models\Finance\Settings\FmsChartOfAccountsType;
use Livewire\Component;
use Livewire\WithPagination;

class ChartOfAccountsTypesComponent extends Component
{
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $accountTypeIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

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
            'is_active' => 'required|string',
            'description' => 'nullable|string',
        ]);
    }

    public function storeaccountType()
    {
        $this->validate([
            'name' => 'required|string|unique:accountTypes',
            'is_active' => 'required|numeric',
            'description' => 'nullable|string',

        ]);

        $accountType = new FmsChartOfAccountsType();
        $accountType->name = $this->name;
        $accountType->is_active = $this->is_active;
        $accountType->description = $this->description;
        $accountType->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'accountType created successfully!']);
    }

    public function editData(FmsChartOfAccountsType $accountType)
    {
        $this->edit_id = $accountType->id;
        $this->name = $accountType->name;
        $this->is_active = $accountType->is_active;
        $this->description = $accountType->description;
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

    public function updateaccountType()
    {
        $this->validate([
            'name' => 'required|unique:accountTypes,name,'.$this->edit_id.'',
            'is_active' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $accountType = FmsChartOfAccountsType::find($this->edit_id);
        $accountType->name = $this->name;
        $accountType->is_active = $this->is_active;
        $accountType->description = $this->description;
        $accountType->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'accountType updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->accountTypeIds) > 0) {
            // return (new accountTypesExport($this->accountTypeIds))->download('accountTypes_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No accountTypes selected for export!',
            ]);
        }
    }

    public function filterAccountTypes()
    {
        $accountTypes = FmsChartOfAccountsType::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->accountTypeIds = $accountTypes->pluck('id')->toArray();

        return $accountTypes;
    }

    public function render()
    {
        $data['accountTypes'] = $this->filterAccountTypes()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.finance.settings.chart-of-accounts-types-component', $data);
    }
}
