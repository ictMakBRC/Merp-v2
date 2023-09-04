<?php

namespace App\Http\Livewire\Finance\Settings;

use App\Models\Finance\Settings\FmsCurrency;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Finance\Settings\FmsService;
use App\Models\Finance\Settings\FmsServiceCategory;

class FmsServicesComponent extends Component
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

    public $is_active =1;
    public $name;
    public $sku;
    public $code;
    public $rate;
    public $is_taxable;
    public $tax_rate;
    public $is_purchased;
    public $supplier_id;
    public $cost_price;
    public $sale_price;
    public $description;
    public $currency_id;
    public $category_id;
    public $created_by;

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
    
        public function storeFmsService()
        {
            $this->validate([
                'name' => 'required|string|unique:fms_services',
                'is_active' => 'required|numeric',
                'description' => 'nullable|string',
                'sku',
                'code',
                'rate',
                'is_taxable',
                'tax_rate',
                'is_purchased',
                'supplier_id',
                'cost_price',
                'sale_price',
                'currency_id',
                'category_id',
    
            ]);
    
            $service = new FmsService();
            $service->name = $this->name;
            $service->is_active = $this->is_active; 
            $service->sku =  $this->sku;
            $service->code =  $this->code;
            $service->rate =  $this->rate;
            $service->is_taxable =  $this->is_taxable;
            $service->tax_rate =  $this->tax_rate;
            $service->is_purchased =  $this->is_purchased;
            $service->supplier_id =  $this->supplier_id;
            $service->cost_price =  $this->cost_price;
            $service->sale_price =  $this->sale_price;
            $service->currency_id =  $this->currency_id;
            $service->category_id =  $this->category_id;
            $service->description = $this->description;

            $service->save();
            $this->dispatchBrowserEvent('close-modal');
            $this->resetInputs();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'service created successfully!']);
        }
    
        public function editData(FmsService $service)
        {
            $this->edit_id = $service->id;
            $this->name = $service->name;
            $this->is_active = $service->is_active;
            $this->description = $service->description;            
            $this->sku =  $service->sku;
            $this->code =  $service->code;
            $this->rate =  $service->rate;
            $this->is_taxable =  $service->is_taxable;
            $this->tax_rate =  $service->tax_rate;
            $this->is_purchased =  $service->is_purchased;
            $this->supplier_id =  $service->supplier_id;
            $this->cost_price =  $service->cost_price;
            $this->sale_price =  $service->sale_price;
            $this->currency_id =  $service->currency_id;
            $this->category_id =  $service->category_id;

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
            'name',
            'sku',
            'code',
            'rate',
            'is_taxable',
            'tax_rate',
            'is_purchased',
            'supplier_id',
            'cost_price',
            'sale_price',
            'description',
            'currency_id',
            'category_id',
            'created_by',
            'is_active',]);
        }
    
        public function updateFmsService()
        {
            $this->validate([
                'name' => 'required|unique:fms_services,name,'.$this->edit_id.'',
                'is_active' => 'required|numeric',
                'description' => 'nullable|string',
            ]);
    
            $service = FmsService::find($this->edit_id);
            
            $service->name = $this->name;
            $service->is_active = $this->is_active; 
            $service->sku =  $this->sku;
            $service->code =  $this->code;
            $service->rate =  $this->rate;
            $service->is_taxable =  $this->is_taxable;
            $service->tax_rate =  $this->tax_rate;
            $service->is_purchased =  $this->is_purchased;
            $service->supplier_id =  $this->supplier_id;
            $service->cost_price =  $this->cost_price;
            $service->sale_price =  $this->sale_price;
            $service->currency_id =  $this->currency_id;
            $service->category_id =  $this->category_id;
            $service->description = $this->description;
            $service->update();
    
            $this->resetInputs();
            $this->createNew = false;
            $this->toggleForm = false;
            $this->dispatchBrowserEvent('close-modal');
            $this->resetInputs();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'service updated successfully!']);
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
    
        public function filterServices()
        {
            $services = FmsService::search($this->search)
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
            $data['services'] = $this->filterServices()
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage);
            $data['currencies'] = FmsCurrency::where('is_active', 1)->get();
            $data['categories'] = FmsServiceCategory::where('is_active', 1)->get();
        return view('livewire.finance.settings.fms-services-component', $data);
    }
}
