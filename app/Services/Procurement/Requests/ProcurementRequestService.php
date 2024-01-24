<?php

namespace App\Services\Procurement\Requests;

use Illuminate\Database\Eloquent\Model;
use App\Models\Procurement\Request\ProcurementRequest;
use App\Data\Procurement\Requests\ProcurementRequestData;

class ProcurementRequestService
{

    //DOCUMENTS
    public function createProcurementRequest(Model $model,ProcurementRequestData $procurementRequestDTO):ProcurementRequest
    {
        $procurementRequest = $model->procurementRequests()->create([
            ...$this->fillProcurementRequestFromDTO($procurementRequestDTO)
        ]);
        return $procurementRequest;
    }

    public function updateProcurementRequest(ProcurementRequest $procurementRequest, ProcurementRequestData $procurementRequestDTO):ProcurementRequest
    {
        $procurementRequest->update([
            ...$this->fillProcurementRequestFromDTO($procurementRequestDTO)
        ]);

        return $procurementRequest;
    }

    private function fillProcurementRequestFromDTO(ProcurementRequestData $procurementRequestDTO)
    {
        return [
            'request_type' => $procurementRequestDTO->request_type,
            'subject' => $procurementRequestDTO->subject,
            'body' => $procurementRequestDTO->body,
            'procuring_entity_code' => $procurementRequestDTO->procuring_entity_code,
            'procurement_sector' => $procurementRequestDTO->procurement_sector,
            'subcategory_id' => $procurementRequestDTO->subcategory_id,
            'financial_year_id' => $procurementRequestDTO->financial_year_id,
            'currency_id' => $procurementRequestDTO->currency_id,
            'budget_line_id' => $procurementRequestDTO->budget_line_id,
            // 'sequence_number' => $procurementRequestDTO->sequence_number,
            'procurement_plan_ref' => $procurementRequestDTO->procurement_plan_ref,
            'location_of_delivery' => $procurementRequestDTO->location_of_delivery,
            'date_required' => $procurementRequestDTO->date_required,
        ];
        
    }
  
}
