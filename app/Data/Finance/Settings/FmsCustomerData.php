<?php

namespace App\Data\Finance\Settings;

use Spatie\LaravelData\Data;

class FmsCustomerData extends Data
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
        ];
    }

     // Validation rules for the properties
     public function resetInputs(): array
     {
         return [
            'member_type',
            'surname',
            'first_name',
            'member_status',
            'address',
            'contact',
            'occupation',
            'employer',
            'employer_contact',
            'employer_address',
         ];
     }


    public static function fromArray(array $data): self
    {
        $customerData = new self();
        $customerData->name = $data['name'] ?? null;
        $customerData->email = $data['email'] ?? null;
        $customerData->address = $data['address'] ?? null;
        // Set other properties here if needed

        return $customerData;
    }
}
