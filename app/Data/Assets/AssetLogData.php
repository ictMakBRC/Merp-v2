<?php

namespace App\Data\Assets;

use Spatie\LaravelData\Data;

class AssetLogData extends Data
{
    public ?int $asset_catalog_id;
    public ?string $log_type;
    public ?string $date_allocated;
    public ?int $station_id;
    public ?int $department_id;
    public ?int $employee_id;
    public ?string $allocation_status;

    public ?string $breakdown_number;
    public ?string $breakdown_type;
    public ?string $breakdown_date;
    public ?string $breakdown_description;
    public ?string $action_taken;
    public ?string $breakdown_status;

    public ?string $asset_breakdown_id;
    public ?string $service_type;
    public ?string $date_serviced;
    public ?string $service_action;
    public ?string $service_recommendations;
    public ?string $resolution_status;
    public ?string $serviced_by;
    public ?float $cost;
    public ?string $currency;
    public ?string $next_service_date;

    // Validation rules for the properties
    public function allocationRules(): array
    {
        return [
        'asset_catalog_id'=>'required|integer',
        'log_type'=>'required|string',
        'date_allocated'=>'required|date|before_or_equal:today',
        'station_id'=>'required|integer',
        'department_id'=>'required|integer',
        'employee_id'=>'nullable|string',

        ];
    }

    public function breakdownRules(): array
    {
        return [
        'asset_catalog_id'=>'required|integer',
        'log_type'=>'required|string',
        'breakdown_number'=>'required|string',
        'breakdown_type'=>'required|string',
        'breakdown_date'=>'required|date|before_or_equal:today',
        'breakdown_description'=>'required|string',
        'action_taken'=>'required|string',
        'breakdown_status'=>'required|string',

        ];
    }

    public function maintenanceRules(): array
    {
        return [
        'asset_catalog_id'=>'required|integer',
        'log_type'=>'required|string',
        'asset_breakdown_id'=>'required|integer',
        'service_type'=>'required|string',
        'date_serviced'=>'required|date|before_or_equal:today',
        'service_action'=>'required|string',
        'service_recommendations'=>'required|string',
        'resolution_status'=>'required|string',
        'serviced_by'=>'required|string',
        'cost'=>'required|numeric',
        'currency'=>'required|string',
        'next_service_date'=>'required|date|after:date_serviced',

        ];
    }
    
    // Validation rules for the properties
    public function resetInputs(): array
    {
        $allKeys = array_keys([...$this->allocationRules(),...$this->breakdownRules(),...$this->maintenanceRules()]);
        return array_values(array_diff($allKeys,['asset_catalog_id','log_type']));
    }
}
