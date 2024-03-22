<?php

namespace App\Http\Livewire\Finance\Settings;

use App\Models\Finance\Settings\FmsTax;
use Livewire\Component;

class FmsTaxComponent extends Component
{
    public $from_date;

    public $to_date;

    public $financialYearIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $is_active =1;

    public $rate;


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
            'rate' => 'required|numeric',
        ]);
    }

    public function storeData()
    {
        $this->validate([
            'name' => 'required|string|unique:fms_financial_years',
            'is_active' => 'required|integer',
            'rate' => 'required|numeric',

        ]);

        $financialYear = new FmsTax();
        $financialYear->name = $this->name;
        $financialYear->is_active = $this->is_active;
        $financialYear->rate = $this->rate;
        $financialYear->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'financialYear created successfully!']);
    }

    public function editData(FmsTax $financialYear)
    {
        $this->edit_id = $financialYear->id;
        $this->name = $financialYear->name;
        $this->is_active = $financialYear->is_active;
        $this->rate = $financialYear->rate;
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
        $this->reset(['name', 'is_active', 'rate']);
    }

    public function updateData()
    {
        $this->validate([
            'name' => 'required|unique:fms_financial_years,name,'.$this->edit_id.'',
            'is_active' => 'required|numeric',
            'rate' => 'required|numeric',
        ]);

        $financialYear = FmsTax::find($this->edit_id);
        $financialYear->name = $this->name;
        $financialYear->rate = $this->rate;
        $financialYear->is_active = $this->is_active;
        $financialYear->update();
        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'financialYear updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->financialYearIds) > 0) {
            // return (new financialYearsExport($this->financialYearIds))->download('financialYears_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No financialYears selected for export!',
            ]);
        }
    }

    public function mainQuery()
    {
        $financialYears = FmsTax::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->financialYearIds = $financialYears->pluck('id')->toArray();

        return $financialYears;
    }

    public function render()
    {
        $data['taxes'] = $this->mainQuery()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.finance.settings.fms-tax-component', $data);
    }
}
