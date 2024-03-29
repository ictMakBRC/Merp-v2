<?php

namespace App\Data\HumanResource\EmployeeData;

use Spatie\LaravelData\Data;

class EmployeeFamilyData extends Data
{
    public ?int $employee_id;
    public ?string $member_type;
    public ?string $surname;
    public ?string $first_name;
    public ?string $other_name;

    public ?string $member_status;
    public ?string $address;
    public ?string $contact;
    public ?string $occupation;
    public ?string $employer;
    public ?string $employer_contact;
    public ?string $employer_address;

    // Validation rules for the properties
    public function rules(): array
    {
        return [
          'employee_id' => 'required|integer',
          'member_type' => 'required|string',
          'surname' => 'required|string|max:100',
          'first_name' => 'required|string|max:100',
          'member_status' => 'required|string',
          'other_name'=>'nullable|string',
          'address'=>'nullable|string',
          'contact'=>'nullable|string',
          'occupation'=>'nullable|string',
          'employer'=>'nullable|string',
          'employer_contact'=>'nullable|string',
          'employer_address'=>'nullable|string',
        ];
    }

     // Validation rules for the properties
     public function resetInputs(): array
     {
        $allKeys = array_keys($this->rules());

        return array_values(array_diff($allKeys,['employee_id']));
     }
}
