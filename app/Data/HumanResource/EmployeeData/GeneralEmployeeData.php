<?php

namespace App\Data\HumanResource\EmployeeData;

use Spatie\LaravelData\Data;

class GeneralEmployeeData extends Data
{
    public ?string $entry_type;
    public ?string $nin_number;
    public ?string $title;
    public ?string $surname;
    public ?string $first_name;
    public ?string $other_name;
    public ?string $gender;
    public ?string $nationality;
    public ?string $birth_date;
    public ?string $birth_place;
    public ?string $religious_affiliation;
    public ?float $height;
    public ?float $weight;
    public ?string $blood_type;
    public ?string $civil_status;
    public ?string $address;
    public ?string $email;
    public ?string $alt_email;
    public ?string $contact;
    public ?string $alt_contact;
    public ?int $designation_id;
    public ?int $station_id;
    public ?int $department_id;
    public ?int $reporting_to;
    public ?string $work_type;
    public ?string $join_date;
    public ?string $tin_number;
    public ?string $nssf_number;
    public ?string $cv;
    public ?string $photo;
    public ?string $signature;

    // public function __construct(?string $name = null, ?string $category = null, ?string $email = null,?string $password = null, ?int $is_active = null,$signature=null)
    // {
    //     $this->name = $name;
    //     $this->category = $category;
    //     $this->email = $email;
    //     $this->password = $password;
    //     $this->is_active = $is_active;
    //     $this->signature = $signature;
    // }

      // Validation rules for the properties
      public function rules(): array
      {
          return [
            'entry_type' => 'required|string',
            'title' => 'required|string',
            'surname' => 'required|string|max:40',
            'first_name' => 'required|string|max:40',
            'gender' => 'required|string|max:6',
            'nationality' => 'required|string',
            'email' => 'required|string|email:filter|max:255|unique:employees',
            'designation_id' => 'required|integer',
            'station_id' => 'required|integer',
            'department_id' => 'required|integer',
            'work_type' => 'required|string',
            'join_date' => 'required|date',
          ];
      }
}
