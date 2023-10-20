<?php

namespace App\Services\Assets;

use App\Data\Assets\AssetLogData;
use App\Models\Assets\AssetLog;

class AssetLogService
{
    public function createAssetLog(AssetLogData $assetLogDTO): AssetLog
    {
        $assetLog = new AssetLog();
        $this->fillAssetLogFromDTO($assetLog, $assetLogDTO);
        $assetLog->save();

        return $assetLog;
    }

    public function updateAssetLog(AssetLog $assetLog, AssetLogData $assetLogDTO): AssetLog
    {
        $this->fillAssetLogFromDTO($assetLog, $assetLogDTO);
        $assetLog->save();

        return $assetLog;
    }

    private function fillAssetLogFromDTO(AssetLog $assetLog, AssetLogData $assetLogDTO)
    {
        //ALLOCATION
        $assetLog->asset_catalog_id = $assetLogDTO->asset_catalog_id;
        $assetLog->log_type = $assetLogDTO->log_type;
        $assetLog->date_allocated = $assetLogDTO->date_allocated;
        $assetLog->station_id = $assetLogDTO->station_id;
        $assetLog->department_id = $assetLogDTO->department_id;
        $assetLog->employee_id = $assetLogDTO->employee_id;
        $assetLog->allocation_status = $assetLogDTO->allocation_status;
        //BREAKDOWN
        $assetLog->breakdown_number = $assetLogDTO->breakdown_number;
        $assetLog->breakdown_type = $assetLogDTO->breakdown_type;
        $assetLog->breakdown_date = $assetLogDTO->breakdown_date;
        $assetLog->breakdown_description = $assetLogDTO->breakdown_description;
        $assetLog->action_taken = $assetLogDTO->action_taken;
        $assetLog->breakdown_status = $assetLogDTO->breakdown_status;
        //MAINTENANCE
        $assetLog->asset_breakdown_id = $assetLogDTO->asset_breakdown_id;
        $assetLog->service_type = $assetLogDTO->service_type;
        $assetLog->date_serviced = $assetLogDTO->date_serviced;
        $assetLog->service_action = $assetLogDTO->service_action;
        $assetLog->service_recommendations = $assetLogDTO->service_recommendations;
        $assetLog->resolution_status = $assetLogDTO->resolution_status;
        $assetLog->serviced_by = $assetLogDTO->serviced_by;
        $assetLog->cost = $assetLogDTO->cost;
        $assetLog->currency = $assetLogDTO->currency;
        $assetLog->next_service_date = $assetLogDTO->next_service_date;
    }
}
