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

    // Validation rules for the properties
    public function rules(): array
    {
        return [
        'asset_catalog_id'=>'nullable|string',
        'log_type'=>'nullable|string',
        'date_allocated'=>'nullable|date|before_or_equal:today',
        'station_id'=>'nullable|string',
        'department_id'=>'nullable|string',
        'user_id'=>'nullable|string',
        'allocation_status'=>'nullable|string',

        'breakdown_number'=>'nullable|string',
        'breakdown_type'=>'nullable|string',
        'breakdown_date'=>'nullable|date|before_or_equal:today',
        'breakdown_description'=>'nullable|string',
        'action_taken'=>'nullable|string',
        'date_breakdown_recorded'=>'nullable|date|before_or_equal:today|after_or_equal:breakdown_date',
        'breakdown_status'=>'nullable|string',

        'asset_breakdown_id'=>'nullable|integer',
        'service_type'=>'nullable|string',
        'date_serviced'=>'nullable|date|before_or_equal:today',
        'service_action'=>'nullable|string',
        'service_recommendations'=>'nullable|string',
        'serviced_by'=>'nullable|string',
        'currency'=>'nullable|numeric',
        'next_service_date'=>'nullable|date|after:date_serviced',

        ];
    }
    
    // Validation rules for the properties
    public function resetInputs(): array
    {
        return array_keys($this->rules());
    }
}
