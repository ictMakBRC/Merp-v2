<?php

namespace App\Http\Livewire\Finance\Payroll;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Finance\Payroll\FmsPayroll;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsCurrencyUpdate;

class FmsPayrollsComponent extends Component
{
    use WithPagination;
    public $from_date;

    public $to_date;

    public $serviceIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $delete_id;

    public $edit_id;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public $is_active = 1;

    public $year;
    public $month;
    public $currency_id;
    public $rate;

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
        {
            $this->month = now()->format('m');
            $this->year = now()->format('Y');
    }

    public function createPayroll()
    {
        $this->validate([
            'month' => 'required',
            'year' => 'required',
        ]);
        $record = FmsPayroll::where([ 'month' => $this->month, 'year' => $this->year])->first();
        if($record){

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! payroll already exists!',
                'text' => 'Months already paid or in queue',
            ]);
            return false;

        }
        $payroll = new FmsPayroll();
        $payroll->month = $this->month;
        $payroll->year = $this->year;
        $payroll->payment_voucher = 'BRCP-'.$this->month.'-'.$this->year.time();
        $payroll->save();
        $this->resetInputs();        
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Payroll created successfully!']);
        return redirect()->SignedRoute('finance-payroll_data', $payroll->payment_voucher);
    }

    public function updatedCurrencyId()
    {
        if ($this->currency_id) {
            $latestRate = FmsCurrencyUpdate::where('currency_id', $this->currency_id)->latest()->first();

            if ($latestRate) {
                $this->rate = $latestRate->exchange_rate;
            }
        }
    }


    public function editData(FmsPayroll $service)
    {
        $this->edit_id = $service->id;

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
        $this->reset([
            'year',
            'month',
        ]);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->serviceIds) > 0) {
            // return (new servicesExport($this->serviceIds))->download('services_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No services selected for export!',
            ]);
        }
    }

    public function mainQuery()
    {
        $services = FmsPayroll::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->serviceIds = $services->pluck('id')->toArray();

        return $services;
    }

    public function render()
    {
        $data['payrolls'] = $this->mainQuery()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);           

        $data['currencies'] = FmsCurrency::where('is_active',1)->get();
        return view('livewire.finance.payroll.fms-payrolls-component', $data);
    }
}

