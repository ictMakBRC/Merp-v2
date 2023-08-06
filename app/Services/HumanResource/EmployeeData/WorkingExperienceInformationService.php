<?php

namespace App\Services\HumanResource\EmployeeData;

use App\Models\HumanResource\EmployeeData\WorkExperience;
use App\Data\HumanResource\EmployeeData\WorkingExperienceData;

class WorkingExperienceInformationService
{
    public function createWorkingExperienceInformation(WorkingExperienceData $workingExperienceDTO):WorkExperience
    {
        $workingExperienceInformation = new WorkExperience();
        $this->fillWorkingExperienceInformationFromDTO($workingExperienceInformation, $workingExperienceDTO);
        $workingExperienceInformation->save();

        return $workingExperienceInformation;
    }

    public function updateWorkingExperienceInformation(WorkExperience $workingExperienceInformation, WorkingExperienceData $workingExperienceDTO):WorkExperience
    {
        $this->fillWorkingExperienceInformationFromDTO($workingExperienceInformation, $workingExperienceDTO);
        $workingExperienceInformation->save();

        return $workingExperienceInformation;
    }

    private function fillWorkingExperienceInformationFromDTO(WorkExperience $workingExperienceInformation, WorkingExperienceData $workingExperienceDTO)
    {
        $workingExperienceInformation->employee_id = $workingExperienceDTO->employee_id;
        $workingExperienceInformation->start_date = $workingExperienceDTO->start_date;
        $workingExperienceInformation->end_date =  $workingExperienceDTO->end_date;
        $workingExperienceInformation->company = $workingExperienceDTO->company;
        $workingExperienceInformation->position_held =  $workingExperienceDTO->position_held;
        $workingExperienceInformation->monthly_salary =  $workingExperienceDTO->monthly_salary;
        $workingExperienceInformation->currency = $workingExperienceDTO->currency;
        $workingExperienceInformation->employment_type = $workingExperienceDTO->employment_type;
        $workingExperienceInformation->key_responsibilities = $workingExperienceDTO->key_responsibilities;
    }
}
