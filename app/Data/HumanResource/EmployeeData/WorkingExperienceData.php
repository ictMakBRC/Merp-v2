<?php

namespace App\Data\HumanResource\EmployeeData;

use Spatie\LaravelData\Data;

class WorkingExperienceData extends Data
{
    public ?int $employee_id;
    public ?string $start_date;
    public ?string $end_date;
    public ?string $company;
    public ?string $position_held;
    public ?float $monthly_salary;
    public ?string $currency;
    public ?string $employment_type;
    public ?string $key_responsibilities;

    // Validation rules for the properties
    public function rules(): array
    {
        return [
          'employee_id' => 'required|integer',
          'start_date' => 'required|date|before:today',
          'end_date' => 'required|date|after:start_date|before:today',
          'company' => 'required|string',
          'position_held' => 'required|string',
          'employment_type' => 'required|string',
          'monthly_salary' => 'nullable|numeric',
          'currency' => 'nullable|string',
          'key_responsibilities' => 'nullable|string',
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
        //     'start_date',
        //     'end_date',
        //     'company',
        //     'position_held',
        //     'employment_type',
        //     'monthly_salary',
        //     'currency',
        //     'key_responsibilities',
        //  ];
     }
}
