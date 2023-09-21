<?php

namespace App\Http\Livewire\Procurement\Settings\Inc;

use App\Models\Procurement\Settings\ProcurementSubcategory;
use Livewire\Component;
use App\Models\Procurement\Settings\Provider;

class ProviderSectorsComponent extends Component
{
    //Provider Categories
    public $provider_id;
    public $categories=[];
    public $category;
    public $provider_subcategories=[];
   
    public $selectedSubcategories;

    protected $listeners = [
        'providerCreated' => 'setProviderId',
    ];

    public function setProviderId($details)
    {
        $this->provider_id = $details['providerId'];
    }

    public function mount()
    {
        $this->selectedSubcategories = collect([]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedProviderSubcategories()
    {
        if ($this->provider_id) {
            $this->selectedSubcategories = ProcurementSubcategory::whereIn('id', $this->provider_subcategories)->get();
        } else {
            $this->provider_subcategories=[];
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops! Not found!',
                'text' => 'No Provider Selected, Please select or create provider',
            ]);
        }
    }

    public function updatedProviderId()
    {
        $currentSubcategories = Provider::findOrFail($this->provider_id)?->procurementSubcategories?->pluck('id')->toArray()??[];
            // dd($currentSubcategories);
        $this->provider_subcategories=array_unique(array_merge($this->provider_subcategories, $currentSubcategories));
        $this->selectedSubcategories = ProcurementSubcategory::whereIn('id', $this->provider_subcategories)->get();
    }

    public function attachSubcategories()
    {
        if ($this->provider_id) {
            $this->validate([
                'provider_id' => 'required',
            ]);

            $provider = Provider::findOrFail($this->provider_id);
            $provider->procurementSubcategories()->sync($this->provider_subcategories);
            $this->resetInputs();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Provider sector subcategories attached successfully,']);

        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops! Not found!',
                'text' => 'No Provider Selected, Please select or create provider',
            ]);
        }
    }

    public function detachSubcategory($subcategoryId)
    {
        $this->provider_subcategories = array_values(array_diff($this->provider_subcategories,[$subcategoryId]));
        $this->selectedSubcategories = ProcurementSubcategory::whereIn('id', $this->provider_subcategories)->get();
    }

    public function resetInputs()
    {
        $this->reset(['provider_id']);
        $this->provider_subcategories = [];
        $this->selectedSubcategories = collect([]);
    }

    public function filterSubcategories()
    {
        $subcategories = ProcurementSubcategory::where('is_active',true)
            ->when($this->category != '', function ($query) {
                $query->where('category', $this->category);
            }, function ($query) {
                return $query;
            })->get();

        return $subcategories;
    }
 
    public function render()
    {
        $data['providers'] = Provider::where('is_active',true)->get();
        $data['subcategories'] = $this->filterSubcategories();
        return view('livewire.procurement.settings.inc.provider-sectors-component',$data);
    }
}
