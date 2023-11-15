<?php

namespace App\Data\Procurement\Requests;

use Spatie\LaravelData\Data;

class ProcurementRequestData extends Data
{
  public $request_type;
  public $subject;
  public $body;
  public $procuring_entity_code;
  public $procurement_sector;
  public $subcategory_id;
  public $financial_year_id;
  public $currency_id;
  public $budget_line_id;
  // public $sequence_number;
  public $procurement_plan_ref;
  public $location_of_delivery;
  public $date_required;

  
  public $contract_value;
  public $status;
  


  // Validation rules for the properties
  public function rules(): array
  {
      return [
        'request_type' =>'required|string',
        'project_id' =>'nullable|required_if:request_type,Project',
        'subject' =>'required|string',
        'body' =>'required|string',
        'procuring_entity_code' =>'required|string',
        'procurement_sector' =>'required|string',
        'subcategory_id' =>'required|integer',
        'financial_year_id' =>'required|integer',
        'currency_id' =>'required|integer',
        'budget_line_id' =>'required|integer',
        // 'sequence_number' =>'required|string',
        'procurement_plan_ref' =>'required|string',
        'location_of_delivery' =>'required|string',
        'date_required' =>'required|string',
      ];
  }



  // Validation rules for the properties
  public function resetInputs(): array
  {
    $allKeys = array_keys($this->rules());
    return array_values($allKeys);
  }


}
