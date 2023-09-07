<?php

namespace App\Http\Livewire\Finance\Settings;

use App\Models\Finance\Settings\FmsFinancialYear;
use Livewire\Component;

class FmsFinancialYearsComponent extends Component
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

    public $start_date;
    public $is_budget_year;

    public $end_date;

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
            'end_date' => 'required|date',
            'start_date' => 'required|date',
        ]);
    }

    public function storeFmsfinancialYear()
    {
        $this->validate([
            'name' => 'required|string|unique:fms_financial_years',
            'is_active' => 'required|integer',
            'end_date' => 'required|date',
            'start_date' => 'required|date',

        ]);

        $financialYear = new FmsFinancialYear();
        $financialYear->name = $this->name;
        $financialYear->is_active = $this->is_active;
        $financialYear->end_date = $this->end_date;
        $financialYear->start_date = $this->start_date;
        $financialYear->is_budget_year = 0;
        $financialYear->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'financialYear created successfully!']);
    }

    public function editData(FmsFinancialYear $financialYear)
    {
        $this->edit_id = $financialYear->id;
        $this->name = $financialYear->name;
        $this->end_date = $financialYear->end_date;
        $this->is_active = $financialYear->is_active;
        $this->start_date = $financialYear->start_date;
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
        $this->reset(['name', 'is_active', 'is_budget_year','end_date','start_date']);
    }

    public function updateFmsfinancialYear()
    {
        $this->validate([
            'name' => 'required|unique:fms_financial_years,name,'.$this->edit_id.'',
            'is_active' => 'required|numeric',
            'end_date' => 'required|date',
            'start_date' => 'required|date',
        ]);

        $financialYear = FmsFinancialYear::find($this->edit_id);
        $financialYear->name = $this->name;
        $financialYear->start_date = $this->start_date;
        $financialYear->end_date = $this->end_date;
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

    public function filterfinancialYears()
    {
        $financialYears = FmsFinancialYear::search($this->search)
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
        $data['financialYears'] = $this->filterfinancialYears()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.finance.settings.fms-financial-years-component',$data);
    }
}
