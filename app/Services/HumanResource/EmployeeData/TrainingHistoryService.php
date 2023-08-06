<?php

namespace App\Services\HumanResource\EmployeeData;

use App\Models\HumanResource\EmployeeData\TrainingProgram;
use App\Data\HumanResource\EmployeeData\TrainingHistoryData;

class TrainingHistoryService
{
    public function createTrainingHistory(TrainingHistoryData $trainingHistoryDTO):TrainingProgram
    {
        $trainingHistory = new TrainingProgram();
        $this->fillTrainingHistoryFromDTO($trainingHistory, $trainingHistoryDTO);
        $trainingHistory->save();

        return $trainingHistory;
    }

    public function updateTrainingHistory(TrainingProgram $trainingHistory, TrainingHistoryData $trainingHistoryDTO):TrainingProgram
    {
        $this->fillTrainingHistoryFromDTO($trainingHistory, $trainingHistoryDTO);
        $trainingHistory->save();

        return $trainingHistory;
    }

    private function fillTrainingHistoryFromDTO(TrainingProgram $trainingHistory, TrainingHistoryData $trainingHistoryDTO)
    {
        $trainingHistory->employee_id = $trainingHistoryDTO->employee_id;
        $trainingHistory->start_date = $trainingHistoryDTO->start_date;
        $trainingHistory->end_date =  $trainingHistoryDTO->end_date;
        $trainingHistory->organised_by = $trainingHistoryDTO->organised_by;
        $trainingHistory->training_title =  $trainingHistoryDTO->training_title;
        $trainingHistory->description =  $trainingHistoryDTO->description;
        $trainingHistory->certificate = $trainingHistoryDTO->certificatePath;
    }
}
