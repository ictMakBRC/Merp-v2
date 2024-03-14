<?php

namespace App\Http\Livewire\Finance\Settings;

use App\Models\Finance\Settings\FmsService;
use App\Models\Finance\Settings\FmsUnitService;
use App\Models\Grants\Project\Project;
use App\Models\HumanResource\Settings\Department;
use Livewire\Component;
use Livewire\WithPagination;

class FmsUnitServicesComponent extends Component
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
    public $service_id;
    public $unitable;
    public $department_id;
    public $project_id;
    public $sale_price;
    public $created_by;
    public $entry_type='Department';

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
                'service_id' => 'required|integer',
                'is_active' => 'required|integer',
                'sale_price' => 'nullable|numeric',
            ]);
        }
    
        public function storeFmsService()
        {
            $this->validate([
                'service_id' => 'required|integer',
                'is_active' => 'required|integer',
                'sale_price' => 'nullable|numeric',
                'project_id'=> 'nullable|numeric',
                'department_id'=> 'nullable|numeric',
            ]);

            $unitable= null;
            if ($this->entry_type == 'Project') {
                $this->validate([
                    'project_id' => 'required|integer',
                ]);
                $this->department_id = null;
                $unitable  = Project::find($this->project_id);
            } elseif ($this->entry_type == 'Department') {
                $this->validate([
                    'department_id' => 'required|integer',
                ]);
                $this->project_id = null;
                $unitable  = Department::find($this->department_id);
            }
    
            $service = new FmsUnitService();           
            $service->sale_price =  $this->sale_price;
            $service->is_active =  $this->is_active;
            $service->service_id =  $this->service_id;
            $service->unitable()->associate($unitable);

            $service->save();
            $this->dispatchBrowserEvent('close-modal');
            $this->resetInputs();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'service created successfully!']);
        }
    
        public function editData(FmsUnitService $service)
        {
            $this->edit_id = $service->id;
            $this->service_id = $service->service_id;
            $this->is_active = $service->is_active;  
            $this->sale_price = $service->sale_price;  
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
            'service_id',
            'project_id',
            'department_id',
            'created_by',
            'is_active',]);
        }
    
        public function updateFmsService()
        {
            $this->validate([
                'service_id' => 'required|integer',
                'is_active' => 'required|integer',
                'sale_price' => 'required|numeric',
                'project_id'=> 'nullable|numeric',
                'department_id'=> 'nullable|numeric',
            ]);
    
            $service = FmsUnitService::find($this->edit_id);            
            $service->sale_price =  $this->sale_price;
            $service->is_active =  $this->is_active;
            $service->service_id =  $this->service_id;
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
            $services = FmsUnitService::search($this->search)
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
            $data['services'] = $this->filterServices()->with('unitable','service')
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage);
            $data['available_services'] = FmsService::where(['is_active'=> 1])->get();
            $data['projects'] = Project::all();
            $data['departments'] = Department::where('is_active', 1)->get();
        return view('livewire.finance.settings.fms-unit-services-component', $data);
    }
}
