<?php
namespace App\Traits;

use App\Models\Assets\AssetLog;

trait AssetLoggableTrait
{
    public function asset_logs()
    {
        return $this->morphMany(AssetLog::class, 'loggable');
    }
}