<?php
namespace App\Traits;

use App\Models\Procurement\Request\ProcurementRequest;

trait ProcurementRequestableTrait
{
    public function procurementRequests()
    {
        return $this->morphMany(ProcurementRequest::class, 'requestable');
    }
}