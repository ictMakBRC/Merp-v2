<?php

namespace App\Services\Grants;

use App\Models\Grants\Project\Project;
use App\Data\Grants\ProjectData;
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
        $project->currency = $projectDTO->currency;
        $project->pi = $projectDTO->pi;
        $project->co_pi = $projectDTO->co_pi;
        $project->start_date = $projectDTO->start_date;
        $project->end_date = $projectDTO->end_date;
        $project->project_summary = $projectDTO->project_summary;
        $project->progress_status = $projectDTO->progress_status;
    }

    //PROJECT DOCUMENTS
    public function createProjectDocument(ProjectData $projectDocumentDTO):ProjectDocument
    {
        $projectDocument = new ProjectDocument();
        $this->fillProjectDocumentFromDTO($projectDocument, $projectDocumentDTO);
        $projectDocument->save();

        return $projectDocument;
    }

    public function updateProjectDocument(ProjectDocument $projectDocument, ProjectData $projectDocumentDTO):ProjectDocument
    {
        $this->fillProjectDocumentFromDTO($projectDocument, $projectDocumentDTO);
        $projectDocument->save();

        return $projectDocument;
    }

    private function fillProjectDocumentFromDTO(ProjectDocument $projectDocument, ProjectData $projectDocumentDTO)
    {
        $projectDocument->project_id = $projectDocumentDTO->project_id;
        $projectDocument->document_category = $projectDocumentDTO->document_category;
        $projectDocument->expires = $projectDocumentDTO->expires;
        $projectDocument->expiry_date = $projectDocumentDTO->expiry_date;
        $projectDocument->document_name = $projectDocumentDTO->document_name;
        $projectDocument->document_path = $projectDocumentDTO->document_path;
        $projectDocument->description = $projectDocumentDTO->description;
    }

    //ATTACH EMPLOYEE
    public function attachEmployee(ProjectData $projectDocumentDTO):void
    {
        $employee = Employee::findOrFail($projectDocumentDTO->employee_id);
        
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

        // return $projectEmployee;
    }
  
}
