<?php

namespace App\Data\HumanResource\EmployeeData;

use Spatie\LaravelData\Data;

class TrainingHistoryData extends Data
{
    public ?int $employee_id;

    public ?string $start_date;

    public ?string $end_date;

    public ?string $organised_by;

    public ?string $training_title;

    public ?string $description;

    public ?string $certificatePath;

    // Validation rules for the properties
    public function rules(): array
    {
        return [
            'employee_id' => 'required|integer',
            'start_date' => 'required|date|before:today',
            'end_date' => 'required|date|after:start_date|before:today',
            'organised_by' => 'required|string',
            'training_title' => 'required|string',
            'description' => 'required|string',
            'certificate' => 'nullable|mimes:pdf|max:10000',
        ];
    }

    // Validation rules for the properties
    public function resetInputs(): array
    {
        $allKeys = array_keys($this->rules());

        return array_values(array_diff($allKeys, ['employee_id']));
    }
}
