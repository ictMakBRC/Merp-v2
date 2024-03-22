<?php

namespace App\Http\Livewire\Finance\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsCurrencyUpdate;

class FmsCurrencyUpdatesComponent extends Component
{
    use WithPagination;
    public $from_date;

    public $to_date;

    public $currencyIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $currency_id;

    public $is_active = 1;

    public $system_default = 0;

    public $code;

    public $exchange_rate = 1;

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
            'currency_id' => 'required|numeric',
            'exchange_rate' => 'required|numeric',
        ]);
    }

    public function storeRate()
    {
        $this->validate([

            // 'currency_code' => 'required|string',
            'currency_id' => 'required|integer',
            'exchange_rate' => 'required|numeric',
        ]);

        $currency = FmsCurrency::where('id', $this->currency_id)->first();
        if ($currency) {
            $currency_code = $currency->code;
            $rate = new FmsCurrencyUpdate();
            $rate->currency_code = $currency_code;
            $rate->exchange_rate = $this->exchange_rate;
            $rate->currency_id = $this->currency_id;
            $rate->save();
            $currency->exchange_rate = $this->exchange_rate;
            $currency->update();
        }

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'currency created successfully!']);
    }

    public function close()
    {
        $this->createNew = false;
        $this->toggleForm = false;
        $this->resetInputs();
    }

    public function resetInputs()
    {
        $this->reset(['currency_id', 'exchange_rate']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->currencyIds) > 0) {
            // return (new currenciesExport($this->currencyIds))->download('currencies_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No currencies selected for export!',
            ]);
        }
    }

    public function filterCurrencies()
    {
        $currencies = FmsCurrencyUpdate::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->currencyIds = $currencies->pluck('id')->toArray();

        return $currencies;
    }

    public function render()
    {
        $data['currency_rates'] = $this->filterCurrencies()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        $data['currencies'] = FmsCurrency::where(['is_active'=> true, 'system_default' =>false])->get();
        return view('livewire.finance.settings.fms-currency-updates-component', $data);
    }
}
