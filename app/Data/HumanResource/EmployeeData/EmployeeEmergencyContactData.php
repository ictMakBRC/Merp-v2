<?php

namespace App\Data\HumanResource\EmployeeData;

use Spatie\LaravelData\Data;

class EmployeeEmergencyContactData extends Data
{
    public ?int $employee_id;
    public ?string $contact_name;
    public ?string $contact_relationship;
    public ?string $contact_address;
    public ?string $contact_phone;
    public ?string $contact_email;

    // Validation rules for the properties
    public function rules(): array
    {
        return [
          'employee_id' => 'required|integer',
          'contact_name' => 'required|string',
          'contact_relationship' => 'required|string',
          'contact_address' => 'required|string|max:100',
          'contact_phone' => 'required|string|max:100',
        ];
    }

     // Validation rules for the properties
     public function resetInputs(): array
     {
        $allKeys = array_keys($this->rules());

        return array_values(array_diff($allKeys,['employee_id']));
     }
}
