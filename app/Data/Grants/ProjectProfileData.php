<?php

namespace App\Data\Grants;

use Spatie\LaravelData\Data;

class ProjectProfileData extends Data
{
  public ?string $project_code;
  public ?string $name;
  public ?int $grant_profile_id;
  public ?string $project_type;
  public ?string $funding_source;
  public ?float $funding_amount;
  public ?string $currency;
  public ?int $pi;
  public ?int $co_pi;
  public ?string $start_date;
  public ?string $end_date;
  public ?string $project_summary;
  public ?string $progress_status;

  //PROJECT PROFILE DOCUMENTS
  public ?int $project_id;
  public ?string $document_name;
  public ?string $document_path;
  public ?string $description;

  //PROJECT EMPLOYEES
  public ?int $employee_id;
  public ?int $designation_id;
  public ?string $contract_summary;
  public ?string $contract_start_date;
  public ?string $contract_end_date;
  public ?float $fte;
  public ?float $gross_salary;
  public ?string $contract_file_path;
  public ?string $status;

  // Validation rules for the properties
  public function rules(): array
  {
    return [
      'project_code' => 'required|string|unique:projects',
      'name' => 'required|string|unique:projects',
      'grant_profile_id' => 'required|integer',
      'project_type' => 'required|string',
      'funding_source' => 'nullable|string',
      'funding_amount' => 'nullable|numeric',
      'currency' => 'required|string',
      'pi' => 'required|integer',
      'co_pi' => 'required|integer',
      'start_date' => 'required|date',
      'end_date' => 'required|date|after:start_date',
      'project_summary' => 'required|string|max:255',
      'progress_status' => 'required|string',
    ];
  }

  // Validation rules for the properties
  public function projectEmployeeRules(): array
  {
    return [
      'project_id' => 'required|integer',
      'employee_id' => 'required|integer',
      'designation_id' => 'required|integer',
      'contract_summary' => 'required|numeric',
      'start_date' => 'required|date',
      'end_date' => 'required|date|after:start_date',
      'fte' => 'nullable|numeric',
      'contract_file' => 'nullable|mimes:pdf|max:10000',
      'status' => 'required|string',
    ];
  }

  // Validation rules for the properties
  public function projectDocumentRules(): array
  {
    return [
      'project_id' => 'required|integer',
      'document_name' => 'required|string',
      'document' => 'required|string',
      'description' => 'required|string',
    ];
  }

  // Validation rules for the properties
  public function resetInputs(): array
  {
    $allKeys = array_keys($this->rules());
    return array_values($allKeys);
  }

  // Validation rules for the properties
  public function resetProjectDocumentInputs(): array
  {
    $allKeys = array_keys($this->projectDocumentRules());
    return array_values(array_diff($allKeys,['project_id']));
  }

  // Validation rules for the properties
  public function resetProjectEmployeeInputs(): array
  {
    $allKeys = array_keys($this->projectEmployeeRules());
    return array_values(array_diff($allKeys,['project_id']));
  }
}
