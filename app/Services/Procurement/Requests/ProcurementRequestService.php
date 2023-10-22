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
        $document = $model->procurementRequests()->create([
            ...$this->fillProcurementRequestFromDTO($procurementRequestDTO)
        ]);
        return $document;
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
            'financial_year' => $procurementRequestDTO->financial_year,
            'currency' => $procurementRequestDTO->currency,
            'budget_line' => $procurementRequestDTO->budget_line,
            'sequence_number' => $procurementRequestDTO->sequence_number,
            'procurement_plan_ref' => $procurementRequestDTO->procurement_plan_ref,
            'location_of_delivery' => $procurementRequestDTO->location_of_delivery,
            'date_required' => $procurementRequestDTO->date_required,
        ];
        
    }
  
}