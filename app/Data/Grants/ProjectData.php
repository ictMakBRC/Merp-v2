<?php

namespace App\Data\Grants;

use Spatie\LaravelData\Data;

class ProjectData extends Data
{
  public ?string $project_code;
  public ?string $project_category;
  public ?string $project_type;
  // public ?int $associated_institution;
  public ?string $name;
  // public ?int $grant_id;
  public ?string $funding_source;
  public ?float $funding_amount;
  public ?string $currency_id;
  // public ?int $pi;
  // public ?int $co_pi;
  public ?string $start_date;
  public ?string $end_date;
  public ?string $project_summary;
  public ?string $progress_status;

  //PROJECT PROFILE DOCUMENTS
  public ?int $project_id;
  public ?string $document_category;
  public ?bool $expires;
  public ?string $document_name;
  public ?string $document_path;
  public ?string $expiry_date;
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
      'project_category' => 'required|string',
      'project_type' => 'required|string',
      // 'associated_institution' => 'required|integer',
      'project_code' => 'required|string|unique:projects',
      'name' => 'required|string|unique:projects',
      // 'grant_id' => 'nullable|integer',
      'funding_source' => 'nullable|string',
      'funding_amount' => 'nullable|numeric',
      'currency_id' => 'required|integer',
      // 'pi' => 'required_if:project_category,Primary|integer',
      // 'co_pi' => 'nullable|integer',
      'start_date' => 'required|date',
      'end_date' => 'required|date|after:start_date',
      'project_summary' => 'required|string',
      'progress_status' => 'required|string',
    ];
  }

  public function updateRules(): array
  {
    return [
      'project_category' => 'required|string',
      'project_type' => 'required|string',
      // 'associated_institution' => 'required|integer',
      'project_code' => 'required|string',
      'name' => 'required|string',
      // 'grant_id' => 'nullable|integer',
      'funding_source' => 'nullable|string',
      'funding_amount' => 'nullable|numeric',
      'currency_id' => 'required|integer',
      // 'pi' => 'required_if:project_category,Primary|integer',
      // 'co_pi' => 'nullable|integer',
      'start_date' => 'required|date',
      'end_date' => 'required|date|after:start_date',
      'project_summary' => 'required|string',
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
      'contract_summary' => 'required|string',
      'contract_start_date' => 'required|date',
      'contract_end_date' => 'required|date|after:contract_start_date',
      'fte' => 'nullable|numeric',
      'contract_file' => 'nullable|mimes:pdf|max:10000',
      'gross_salary' => 'required|numeric',
      'status' => 'required|string',
    ];
  }

  // Validation rules for the properties
  public function resetInputs(): array
  {
    $allKeys = array_keys($this->rules());
    return array_values($allKeys);
  }

  // Validation rules for the properties
  public function resetProjectEmployeeInputs(): array
  {
    $allKeys = array_keys($this->projectEmployeeRules());
    return array_values(array_diff($allKeys,['project_id']));
  }
}
