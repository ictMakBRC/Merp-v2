<?php

namespace App\Dat\Finance\Requests;

use Spatie\LaravelData\Data;

class FmsPaymentRequestData extends Data
{
  public $request_description;
    public $request_type;
    public $total_amount;
    public $amount_in_words;
    public $requester_signature;
    public $date_submitted;
    public $date_approved;
    public $rate;
    public $currency_id;
    public $notice_text;
    public $department_id;
    public $project_id;
    public $budget_line_id;
    public $status;
    public $created_by;
    public $updated_by;
    public $request_table;
    public $subject_id;
    public $ledger_account;
    public $is_department;
    public $invoiceData;
    public $toAccountData;
    public $fromAccountData;
    public $to_account;
    public $invoice_id;
    public $procurement_request_id;
    public $month;
    public $year;
    public $requestable;
    public $budget_amount;
    public $ledger_amount;
    public $request_code;
    public $to_budget_line_id;
    public $payment_method;
    public $description;
  


  // Validation rules for the properties
  public function rules(): array
  {
      return [
        'request_type' => 'required',
        'request_code' => 'required',
        'total_amount' => 'required',
        'budget_amount' => 'required',
        'ledger_amount' => 'required',
        'request_description' => 'required|string',
        'amount_in_words' => 'required|string',
        'rate' => 'required|numeric',
        'department_id' => 'nullable|integer',
        'project_id' => 'nullable|integer',
        'department_id' => 'nullable|integer',
        'currency_id' => 'required|integer',
        'budget_line_id' => 'nullable|integer',
        'to_budget_line_id' => 'nullable|integer',
        'ledger_account' => 'required|integer',
        'to_account' => 'nullable|integer',
        'procurement_request_id' => 'nullable|integer',
        'invoice_id' => 'nullable|integer',
        'payment_method' => 'nullable',
        'year' => 'nullable|integer',
        'month' => 'nullable|integer',
        'description' => 'nullable|string',
        'notice_text' => 'nullable|string',
      ];
  }



  // Validation rules for the properties
  public function resetInputs(): array
  {
    $allKeys = array_keys($this->rules());
    return array_values($allKeys);
  }


}
