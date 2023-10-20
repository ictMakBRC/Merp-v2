<?php

namespace App\Data\HumanResource\EmployeeData;

use Spatie\LaravelData\Data;

class EducationHistoryData extends Data
{
    public ?int $employee_id;

    public $level;

    public $school;

    public $start_date;

    public $end_date;

    public $award;

    public $awardFilePath;

    // Validation rules for the properties
    public function rules(): array
    {
        return [
            'employee_id' => 'required|integer',
            'level' => 'required|string',
            'school' => 'required|string|max:100',
            'start_date' => 'required|date|before:today',
            'end_date' => 'required|date|after:start_date|before:today',
            'award' => 'required|string',
            'award_document' => 'nullable|mimes:pdf|max:10000',
        ];
    }

    // Validation rules for the properties
    public function resetInputs(): array
    {
        $allKeys = array_keys($this->rules());

        return array_values(array_diff($allKeys, ['employee_id']));
    }
}
