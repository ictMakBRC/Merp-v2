<?php

namespace App\Services\HumanResource\EmployeeData;

use App\Data\HumanResource\EmployeeData\EducationHistoryData;
use App\Models\HumanResource\EmployeeData\EducationBackground;

class EducationHistoryService
{
    public function createEducationHistory(EducationHistoryData $educationHistoryDTO): EducationBackground
    {
        $educationBackground = new EducationBackground();
        $this->fillEducationHistoryFromDTO($educationBackground, $educationHistoryDTO);
        $educationBackground->save();

        return $educationBackground;
    }

    public function updateEducationHistory(EducationBackground $educationBackground, EducationHistoryData $educationHistoryDTO): EducationBackground
    {
        $this->fillEducationHistoryFromDTO($educationBackground, $educationHistoryDTO);
        $educationBackground->save();

        return $educationBackground;
    }

    private function fillEducationHistoryFromDTO(EducationBackground $educationBackground, EducationHistoryData $educationHistoryDTO)
    {
        $educationBackground->employee_id = $educationHistoryDTO->employee_id;
        $educationBackground->level = $educationHistoryDTO->level;
        $educationBackground->school = $educationHistoryDTO->school;
        $educationBackground->award = $educationHistoryDTO->award;
        $educationBackground->start_date = $educationHistoryDTO->start_date;
        $educationBackground->end_date = $educationHistoryDTO->end_date;
        $educationBackground->award_document = $educationHistoryDTO->awardFilePath;
    }
}
