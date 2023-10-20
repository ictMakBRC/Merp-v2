<?php

namespace App\Services\Procurement\Settings;

use App\Data\Procurement\Settings\ProcurementSubcategoryData;
use App\Models\Procurement\Settings\ProcurementSubcategory;

class ProcurementSubcategoryService
{
    public function createProcurementSubcategory(ProcurementSubcategoryData $procurementSubcategoryDTO): ProcurementSubcategory
    {
        $procurementSubcategory = new ProcurementSubcategory();
        $this->fillProcurementSubcategoryFromDTO($procurementSubcategory, $procurementSubcategoryDTO);
        $procurementSubcategory->save();

        return $procurementSubcategory;
    }

    public function updateProcurementSubcategory(ProcurementSubcategory $procurementSubcategory, ProcurementSubcategoryData $procurementSubcategoryDTO): ProcurementSubcategory
    {
        $this->fillProcurementSubcategoryFromDTO($procurementSubcategory, $procurementSubcategoryDTO);
        $procurementSubcategory->save();

        return $procurementSubcategory;
    }

    private function fillProcurementSubcategoryFromDTO(ProcurementSubcategory $procurementSubcategory, ProcurementSubcategoryData $procurementSubcategoryDTO)
    {
        $procurementSubcategory->category = $procurementSubcategoryDTO->category;
        $procurementSubcategory->name = $procurementSubcategoryDTO->name;
        $procurementSubcategory->is_active = $procurementSubcategoryDTO->is_active;
    }
}
