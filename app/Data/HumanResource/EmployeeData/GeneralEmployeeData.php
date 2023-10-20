<?php

namespace App\Data\HumanResource\EmployeeData;

use App\Models\HumanResource\EmployeeData\Employee;
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

    public function __construct(
        public Employee $employee,
    ) {
    }

    // Validation rules for the properties
    public function rules(): array
    {
        return [
            'entry_type' => 'required|string',
            'nin_number' => 'nullable|string|max:20|unique:employees,nin_number,'.$this->employee->id,
            'title' => 'required|string',
            'surname' => 'required|string|max:40',
            'first_name' => 'required|string|max:40',
            'gender' => 'required|string|max:6',
            'nationality' => 'required|string',
            'email' => 'required|string|email:filter|max:255|unique:employees,email,'.$this->employee->id,
            'alt_email' => 'nullable|string|email:filter|max:255|unique:employees,email,'.$this->employee->id,
            'designation_id' => 'required|integer',
            'station_id' => 'required|integer',
            'department_id' => 'required|integer',
            'work_type' => 'required|string',
            'join_date' => 'required|date|before:today',
        ];
    }

    // Validation rules for the properties
    public function resetInputs(): array
    {
        return [
            'entry_type',
            'nin_number',
            'title',
            'surname',
            'first_name',
            'other_name',
            'gender',
            'nationality',
            'birth_date',
            'birth_place',
            'religious_affiliation',
            'height',
            'weight',
            'blood_type',
            'civil_status',
            'address',
            'email',
            'alt_email',
            'contact',
            'alt_contact',
            'designation_id',
            'station_id',
            'department_id',
            'reporting_to',
            'work_type',
            'join_date',
            'tin_number',
            'nssf_number',
            'signature',
            'cv',
            'photo',
        ];
    }
}
