<?php

namespace App\Services\Grants;

use App\Data\Grants\ProjectData;
use App\Models\Grants\Project\Project;
use App\Models\Grants\Project\ProjectDocument;
use App\Models\HumanResource\EmployeeData\Employee;



class ProjectService
{
    public function createProject(ProjectData $projectDTO):Project
    {
        $project = new Project();
        $this->fillProjectFromDTO($project, $projectDTO);
        $project->save();

        return $project;
    }

    public function updateProject(Project $project, ProjectData $projectDTO):Project
    {
        $this->fillProjectFromDTO($project, $projectDTO);
        $project->save();

        return $project;
    }

    private function fillProjectFromDTO(Project $project, ProjectData $projectDTO)
    {
        $project->project_type = $projectDTO->project_type;
        $project->project_category = $projectDTO->project_category;
        $project->associated_institution = $projectDTO->associated_institution;
        $project->project_code = $projectDTO->project_code;
        $project->name = $projectDTO->name;
        $project->grant_id = $projectDTO->grant_id;
        $project->funding_source = $projectDTO->funding_source;
        $project->funding_amount = $projectDTO->funding_amount;
        $project->currency_id = $projectDTO->currency_id;
        $project->pi = $projectDTO->pi;
        $project->co_pi = $projectDTO->co_pi;
        $project->start_date = $projectDTO->start_date;
        $project->end_date = $projectDTO->end_date;
        $project->project_summary = $projectDTO->project_summary;
        $project->progress_status = $projectDTO->progress_status;
    }

    //ATTACH EMPLOYEE
    // public function attachEmployee(ProjectData $projectDocumentDTO):Employee
    // {
    //     $employee = Employee::findOrFail($projectDocumentDTO->employee_id);
        
    //     $employee->projects()->attach($projectDocumentDTO->project_id, [
    //         'designation_id' => $projectDocumentDTO->designation_id,
    //         'contract_summary' => $projectDocumentDTO->contract_summary,
    //         'start_date' => $projectDocumentDTO->contract_start_date,
    //         'end_date' => $projectDocumentDTO->contract_end_date,
    //         'fte' => $projectDocumentDTO->fte,
    //         'gross_salary' => $projectDocumentDTO->gross_salary,
    //         'contract_file_path' => $projectDocumentDTO->contract_file_path,
    //         'status' => $projectDocumentDTO->status,
    //     ]);

    //     $employee->projects()->where(['status' => 'Running'])
    //     ->where('id','!=',$contractInformation->id)
    //     ->update(['status'=>0]);

    //     return $employee;
    // }

    public function attachEmployee(ProjectData $projectDocumentDTO): Employee
    {
        $employee = Employee::findOrFail($projectDocumentDTO->employee_id);

        // Check if there is any running contract for the employee on the project
        $runningContract = $employee->projects()
            ->where('projects.id', $projectDocumentDTO->project_id)
            ->wherePivot('status', '!=', 'Terminated')
            ->wherePivot('end_date', '>=', now())
            // ->orWhereNull('projects.end_date')
            ->first();

        // Mark the status as terminated for the running contract (if it exists)
        if ($runningContract) {
            $employee->projects()->updateExistingPivot(
                $runningContract->id,
                ['status' => 'Terminated']
            );
        }

        // Mark existing contracts related to the project for the employee as expired
        $employee->projects()
        ->where('projects.id', $projectDocumentDTO->project_id)
        ->wherePivot('status', '!=', 'Terminated')
        ->each(function ($project) {
            $project->pivot->update(['status' => 'Expired']);
        });


        // Attach the new contract details
        $employee->projects()->attach($projectDocumentDTO->project_id, [
            'designation_id' => $projectDocumentDTO->designation_id,
            'contract_summary' => $projectDocumentDTO->contract_summary,
            'start_date' => $projectDocumentDTO->contract_start_date,
            'end_date' => $projectDocumentDTO->contract_end_date,
            'fte' => $projectDocumentDTO->fte,
            'gross_salary' => $projectDocumentDTO->gross_salary,
            'contract_file_path' => $projectDocumentDTO->contract_file_path,
            'status' => $projectDocumentDTO->status,
        ]);

        return $employee;
    }
  
}
