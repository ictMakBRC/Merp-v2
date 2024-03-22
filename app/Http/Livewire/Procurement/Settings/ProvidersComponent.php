<?php

namespace App\Http\Livewire\Procurement\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Procurement\Settings\Provider;

class ProvidersComponent extends Component
{

    use WithPagination;

    //Filters
    public $provider_id;
    public $providerIds;

    public $from_date;

    public $to_date;

    public $perPage = 50;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    protected $listeners = [
        'providerCreated',
    ];

    public function providerCreated($details)
    {
        $this->provider_id = $details['providerId'];
    }

    public function updatedCreateNew()
    {
        // $this->resetInputs();
        $this->toggleForm = false;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function loadProvider(Provider $provider):void
    {
        $loadingInfo = 'For '.$provider->name.' | '.$provider->code;
            $this->emit('loadProvider', [
                'providerId' => $provider->id,
                'info'=>$loadingInfo,
            ]);
           
        $this->createNew = true;
        $this->toggleForm = true;
    }

    
    public function filterProviders()
    {
        $providers = Provider::search($this->search)->with('procurement_requests')
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->providerIds = $providers->pluck('id')->toArray();

        return $providers;
    }

    public function render()
    {
        $data['providers'] = $this->filterProviders()
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

        return view('livewire.procurement.settings.providers-component',$data);
    }
}
