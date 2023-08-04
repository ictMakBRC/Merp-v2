<?php

namespace App\Data\HumanResource\EmployeeData;

use Spatie\LaravelData\Data;

class OfficialContractData extends Data
{
    public ?int $employee_id;
    public ?string $contract_summary;
    public ?float $gross_salary;
    public ?string $currency;
    public ?string $start_date;
    public ?string $end_date;
    public ?string $contractFilePath;

    // Validation rules for the properties
    public function rules(): array
    {
        return [
          'employee_id' => 'required|integer',
          'contract_summary' => 'required|string',
          'gross_salary' => 'required|string',
          'currency' => 'required|string|max:100',
          'start_date' => 'required|date',
          'end_date' => 'required|date|after:start_date',
          'contract_file' => 'nullable|mimes:pdf|max:10000',
        ];
    }

     // Validation rules for the properties
     public function resetInputs(): array
     {
        $allKeys = array_keys($this->rules());

        // Filter out the 'employee_id' key
        $keysExceptEmployeeId = array_filter($allKeys, function ($key) {
            return $key !== 'employee_id';
        });

        return $keysExceptEmployeeId;
        //  return [
        //     'contract_summary',
        //     'gross_salary',
        //     'currency',
        //     'start_date',
        //     'end_date',
        //     'contract_file',

        //  ];
     }
}