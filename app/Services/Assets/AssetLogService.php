<?php

namespace App\Services\Assets;

use App\Models\Assets\AssetLog;
use App\Data\Assets\AssetLogData;
use Illuminate\Database\Eloquent\Model;



class AssetLogService
{
    public function createAssetLog(Model $model,AssetLogData $assetLogDTO):AssetLog
    {
        // $assetLog = new AssetLog();
        // $this->fillAssetLogFromDTO($assetLog, $assetLogDTO);
        // $assetLog->save();

        $assetLog = $model->asset_logs()->create([
            ...$this->fillAssetLogFromDTO($assetLogDTO)
        ]);

        return $assetLog;
    }

    public function updateAssetLog(AssetLog $assetLog, AssetLogData $assetLogDTO):AssetLog
    {
        // $this->fillAssetLogFromDTO($assetLog, $assetLogDTO);
        // $assetLog->save();

        $assetLog->update([
            ...$this->fillAssetLogFromDTO($assetLogDTO)
        ]);

        return $assetLog;
    }

    private function fillAssetLogFromDTO(AssetLogData $assetLogDTO)
    {
        return [
        //ALLOCATION
        'asset_catalog_id' => $assetLogDTO->asset_catalog_id,
        'log_type' => $assetLogDTO->log_type,
        'date_allocated' => $assetLogDTO->date_allocated,
        'station_id' => $assetLogDTO->station_id,
        // 'department_id' => $assetLogDTO->department_id,
        'employee_id' => $assetLogDTO->employee_id,
        'allocation_status' => $assetLogDTO->allocation_status,
        //BREAKDOWN
        'breakdown_number' => $assetLogDTO->breakdown_number,
        'breakdown_type' => $assetLogDTO->breakdown_type,
        'breakdown_date' => $assetLogDTO->breakdown_date,
        'breakdown_description' => $assetLogDTO->breakdown_description,
        'action_taken' => $assetLogDTO->action_taken,
        'breakdown_status' => $assetLogDTO->breakdown_status,
        //MAINTENANCE
        'asset_breakdown_id' => $assetLogDTO->asset_breakdown_id,
        'service_type' => $assetLogDTO->service_type,
        'date_serviced' => $assetLogDTO->date_serviced,
        'service_action' => $assetLogDTO->service_action,
        'service_recommendations' => $assetLogDTO->service_recommendations,
        'resolution_status' => $assetLogDTO->resolution_status,
        'serviced_by' => $assetLogDTO->serviced_by,
        'cost' => $assetLogDTO->cost,
        'currency_id' => $assetLogDTO->currency_id,
        'next_service_date' => $assetLogDTO->next_service_date,];
    }
}
