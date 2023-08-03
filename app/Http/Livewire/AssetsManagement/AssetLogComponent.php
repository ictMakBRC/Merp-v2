<?php

namespace App\Http\Livewire\AssetsManagement;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Data\Assets\AssetLogData;
use App\Services\Assets\AssetLogService;
use App\Models\HumanResource\Settings\Station;
use App\Models\HumanResource\Settings\Department;

class AssetsComponent extends Component
{
    public ?int $asset_catalog_id;
    public ?string $log_type;
    public ?string $date_allocated;
    public ?int $station_id;
    public ?int $department_id;
    public ?int $user_id;
    public ?string $allocation_status;

    public ?string $breakdown_number;
    public ?string $breakdown_type;
    public ?string $breakdown_date;
    public ?string $breakdown_description;
    public ?string $action_taken;
    public ?string $date_breakdown_recorded;
    public ?int $breakdown_status;

    public ?string $asset_breakdown_id;
    public ?string $service_type;
    public ?string $date_serviced;
    public ?string $service_action;
    public ?string $service_recommendations;
    public ?string $serviced_by;
    public ?float $currency;
    public ?string $next_service_date;

    public function storeLogDetails()
    {
        $AssetLogDTO = new AssetLogData();
        $this->validate($AssetLogDTO->rules());

        DB::transaction(function (){

            $AssetLogDTO = AssetLogData::from([
                'asset_catalog_id' => $this->asset_catalog_id,
                'log_type' => $this->log_type,
                'date_allocated' => $this->date_allocated,
                'station_id' => $this->station_id,
                'department_id' => $this->department_id,
                'user_id' => $this->user_id,
                'allocation_status' => $this->allocation_status,
                'breakdown_number' => $this->breakdown_number,
                'breakdown_type' => $this->breakdown_type,
                'breakdown_date' => $this->breakdown_date,
                'breakdown_description' => $this->breakdown_description,
                'action_taken' => $this->action_taken,
                'date_breakdown_recorded' => $this->date_breakdown_recorded,
                'breakdown_status' => $this->breakdown_status,
                'asset_breakdown_id' => $this->asset_breakdown_id,
                'service_type' => $this->service_type,
                'date_serviced' => $this->date_serviced,
                'service_action' => $this->service_action,
                'service_recommendations' => $this->service_recommendations,
                'serviced_by' => $this->serviced_by,
                'currency' => $this->currency,
                'next_service_date' => $this->next_service_date,
                
                ]
            );
  
            $assetCatalogService = new AssetLogService();

            $asset = $assetCatalogService->createAssetLog($AssetLogDTO);
   

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Asset log details created successfully']);

            $this->reset($AssetLogDTO->resetInputs());

        });
    }

    public function render()
    {
        $data['stations'] = Station::where('is_active',true)->get();
        $data['departments'] = Department::where('is_active',true)->get();
        return view('livewire.assets-management.asset-log-component',$data)->layout('layouts.app');
    }
}
