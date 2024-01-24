<?php
namespace App\Traits;

use App\Models\Assets\AssetsCatalog;

trait AssetableTrait
{
    public function assets()
    {
        return $this->morphMany(AssetsCatalog::class, 'assetable');
    }
}