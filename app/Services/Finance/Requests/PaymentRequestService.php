<?php

namespace App\Services\Finance\Requests;

use App\Dat\Finance\Requests\FmsPaymentRequestData;
use App\Models\Finance\Requests\FmsPaymentRequest;
use Illuminate\Database\Eloquent\Model;

class PaymentRequestService
{

    //DOCUMENTS
    public function createFmsPaymentRequest(Model $model, FmsPaymentRequestData $FmsPaymentRequestDTO): FmsPaymentRequest
    {
        $document = $model->FmsPaymentRequests()->create([
            ...$this->fillFmsPaymentRequestFromDTO($FmsPaymentRequestDTO),
        ]);
        return $document;
    }

    public function updateFmsPaymentRequest(FmsPaymentRequest $FmsPaymentRequest, FmsPaymentRequestData $FmsPaymentRequestDTO): FmsPaymentRequest
    {
        $FmsPaymentRequest->update([
            ...$this->fillFmsPaymentRequestFromDTO($FmsPaymentRequestDTO),
        ]);

        return $FmsPaymentRequest;
    }

    private function fillFmsPaymentRequestFromDTO(FmsPaymentRequestData $FmsPaymentRequestDTO)
    {
        return [
            'requestable' => $FmsPaymentRequestDTO->requestable,
            'request_type' => $FmsPaymentRequestDTO->request_type,
            'request_code' => $FmsPaymentRequestDTO->request_code,
            'total_amount' => $FmsPaymentRequestDTO->total_amount,
            'budget_amount' => $FmsPaymentRequestDTO->budget_amount,
            'ledger_amount' => $FmsPaymentRequestDTO->ledger_amount,
            'request_description' => $FmsPaymentRequestDTO->request_description,
            'amount_in_words' => $FmsPaymentRequestDTO->amount_in_words,
            'rate' => $FmsPaymentRequestDTO->rate,
            'department_id' => $FmsPaymentRequestDTO->department_id,
            'project_id' => $FmsPaymentRequestDTO->project_id,
            'department_id' => $FmsPaymentRequestDTO->department_id,
            'currency_id' => $FmsPaymentRequestDTO->currency_id,
            'budget_line_id' => $FmsPaymentRequestDTO->budget_line_id,
            'to_budget_line_id' => $FmsPaymentRequestDTO->to_budget_line_id,
            'ledger_account' => $FmsPaymentRequestDTO->ledger_account,
            'to_account' => $FmsPaymentRequestDTO->to_account,
            'procurement_request_id' => $FmsPaymentRequestDTO->procurement_request_id,
            'invoice_id' => $FmsPaymentRequestDTO->invoice_id,
            'payment_method' => $FmsPaymentRequestDTO->payment_method,
            'year' => $FmsPaymentRequestDTO->year,
            'month' => $FmsPaymentRequestDTO->month,
            'description' => $FmsPaymentRequestDTO->description,
            'notice_text' => $FmsPaymentRequestDTO->notice_text,
        ];

    }

}
