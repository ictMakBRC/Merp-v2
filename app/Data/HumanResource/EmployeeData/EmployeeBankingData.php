<?php

namespace App\Data\HumanResource\EmployeeData;

use Spatie\LaravelData\Data;

class EmployeeBankingData extends Data
{
    public ?int $employee_id;
    public ?string $bank_name;
    public ?string $branch;
    public ?string $account_name;
    public ?string $account_number;
    public ?string $currency; 
    public ?bool $is_default;

    // Validation rules for the properties
    public function rules(): array
    {
        return [
          'employee_id' => 'required|integer',
          'bank_name' => 'required|string|max:100',
          'branch' => 'required|string|max:100',
          'account_name' => 'required|string|max:100',
          'account_number' => 'required|max:255|unique:banking_information',
          'currency' => 'required|string',
          'is_default' => 'required|integer',
        ];
    }

     // Validation rules for the properties
     public function resetInputs(): array
     {
         return [
            // 'employee_id',
            'bank_name',
            'branch',
            'account_name',
            'account_number',
            'currency',
            'is_default',
         ];
     }
}