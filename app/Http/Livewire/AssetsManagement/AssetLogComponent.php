<?php

namespace App\Http\Livewire\AssetsManagement;

use Livewire\Component;
use App\Data\Assets\AssetLogData;
use Illuminate\Support\Facades\DB;
use App\Models\Assets\AssetsCatalog;
use App\Services\Assets\AssetLogService;
use App\Models\HumanResource\Settings\Station;
use App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\EmployeeData\Employee;

class AssetLogComponent extends Component
{
    public $asset_catalog_id;
    public $log_type;
    public $date_allocated;
    public $station_id;
    public $department_id;
    public $employee_id;
    public $allocation_status;

    public $breakdown_number;
    public $breakdown_type;
    public $breakdown_date;
    public $breakdown_description;
    public $action_taken;
    public $date_breakdown_recorded;
    public $breakdown_status;

    public $asset_breakdown_id;
    public $service_type;
    public $date_serviced;
    public $service_action;
    public $service_recommendations;
    public $resolution_status;
    public $serviced_by;
    public $cost;
    public $currency;
    public $next_service_date;

    public $asset_name;
    public $barcode;
    public $serial_number;
    public $brand;
    public $model;

    public function mount(AssetsCatalog $assetsCatalog){

        $this->asset_catalog_id = $assetsCatalog->id;
        $this->asset_name = $assetsCatalog->asset_name;
        $this->barcode = $assetsCatalog->barcode;
        $this->serial_number = $assetsCatalog->serial_number;
        $this->brand = $assetsCatalog->brand;
        $this->model = $assetsCatalog->model;

    }

    protected $listeners = [
        'logAsset' => 'setAssetId',
    ];

    public function setAssetId($details)
    {
        $this->asset_catalog_id = $details['assetId'];
        $assetsCatalog = AssetsCatalog::find($this->asset_catalog_id); 
        // $this->asset_catalog_id = $assetsCatalog->id;
        $this->asset_name = $assetsCatalog->asset_name;
        $this->barcode = $assetsCatalog->barcode;
        $this->serial_number = $assetsCatalog->serial_number;
        $this->brand = $assetsCatalog->brand;
        $this->model = $assetsCatalog->model;
    }


    public function storeLogDetails()
    {
        $assetLogDTO = new AssetLogData();
        $assetLogService = new AssetLogService();

        if ($this->log_type=='Allocation') {
            $this->validate($assetLogDTO->allocationRules());
         
            DB::transaction(function () use($assetLogService){

                $assetLogDTO = AssetLogData::from([
                    'asset_catalog_id' => $this->asset_catalog_id,
                    'log_type' => $this->log_type,
                    'date_allocated' => $this->date_allocated,
                    'station_id' => $this->station_id,
                    'department_id' => $this->department_id,
                    'employee_id' => $this->employee_id,
                    'allocation_status' => true,
                    
                    ]
                );
   
                $asset = $assetLogService->createAssetLog($assetLogDTO);
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Asset Allocation details created successfully']);
                $this->reset($assetLogDTO->resetInputs());
    
            });

        }elseif($this->log_type=='Breakdown'){
            dd($assetLogDTO->resetInputs());
            $this->validate($assetLogDTO->breakdownRules());
            DB::transaction(function ()use($assetLogService){

                $assetLogDTO = AssetLogData::from([
                    'asset_catalog_id' => $this->asset_catalog_id,
                    'log_type' => $this->log_type,
                    'breakdown_number' => $this->breakdown_number,
                    'breakdown_type' => $this->breakdown_type,
                    'breakdown_date' => $this->breakdown_date,
                    'breakdown_description' => $this->breakdown_description,
                    'action_taken' => $this->action_taken,
                    'breakdown_status' => $this->breakdown_status,
                    
                    ]
                );
                // dd($assetLogDTO);
    
                $asset = $assetLogService->createAssetLog($assetLogDTO);
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Asset Breakdown details created successfully']);
                $this->reset($assetLogDTO->resetInputs());
    
            });

        }elseif($this->log_type=='Maintenance'){
            $this->validate($assetLogDTO->maintenanceRules());
            DB::transaction(function ()use($assetLogService){

                $assetLogDTO = AssetLogData::from([
                    'asset_catalog_id' => $this->asset_catalog_id,
                    'log_type' => $this->log_type,
                    'asset_breakdown_id' => $this->asset_breakdown_id,
                    'service_type' => $this->service_type,
                    'date_serviced' => $this->date_serviced,
                    'service_action' => $this->service_action,
                    'service_recommendations' => $this->service_recommendations,
                    'resolution_status'=>$this->resolution_status,
                    'serviced_by' => $this->serviced_by,
                    'cost' => $this->cost,
                    'currency' => $this->currency,
                    'next_service_date' => $this->next_service_date,
                    
                    ]
                );
    
                $asset = $assetLogService->createAssetLog($assetLogDTO);
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Asset Maintenance details created successfully']);
                $this->reset($assetLogDTO->resetInputs());
    
            });

        }else{
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No Log type has been selected for this operation!',
            ]);
            return;
        }

        
    }

    public function render()
    {
        $data['stations'] = Station::where('is_active',true)->get();
        $data['departments'] = Department::where('is_active',true)->get();
        $data['employees'] = Employee::where('is_active',true)->get();
        
        return view('livewire.assets-management.asset-log-component',$data)->layout('layouts.app');
    }
}
