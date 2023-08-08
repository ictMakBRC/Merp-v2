<?php

namespace App\Services\Grants;

use App\Models\Grants\Project\Project;
use App\Data\Grants\ProjectProfileData;
use App\Models\Grants\Project\ProjectDocument;
use App\Models\HumanResource\EmployeeData\Employee;

class ProjectService
{
    public function createProject(ProjectProfileData $projectProfileDTO):Project
    {
        $projectProfile = new Project();
        $this->fillProjectFromDTO($projectProfile, $projectProfileDTO);
        $projectProfile->save();

        return $projectProfile;
    }

    public function updateProject(Project $projectProfile, ProjectProfileData $projectProfileDTO):Project
    {
        $this->fillProjectFromDTO($projectProfile, $projectProfileDTO);
        $projectProfile->save();

        return $projectProfile;
    }

    private function fillProjectFromDTO(Project $projectProfile, ProjectProfileData $projectProfileDTO)
    {
        $projectProfile->project_code = $projectProfileDTO->project_code;
        $projectProfile->name = $projectProfileDTO->name;
        $projectProfile->grant_profile_id = $projectProfileDTO->grant_profile_id;
        $projectProfile->project_type = $projectProfileDTO->project_type;
        $projectProfile->funding_source = $projectProfileDTO->funding_source;
        $projectProfile->funding_amount = $projectProfileDTO->funding_amount;
        $projectProfile->currency = $projectProfileDTO->currency;
        $projectProfile->pi = $projectProfileDTO->pi;
        $projectProfile->co_pi = $projectProfileDTO->co_pi;
        $projectProfile->start_date = $projectProfileDTO->start_date;
        $projectProfile->end_date = $projectProfileDTO->end_date;
        $projectProfile->project_summary = $projectProfileDTO->project_summary;
        $projectProfile->progress_status = $projectProfileDTO->progress_status;
    }

    //PROJECT DOCUMENTS
    public function createProjectDocument(ProjectProfileData $projectDocumentDTO):ProjectDocument
    {
        $projectDocument = new ProjectDocument();
        $this->fillProjectDocumentFromDTO($projectDocument, $projectDocumentDTO);
        $projectDocument->save();

        return $projectDocument;
    }

    public function updateProjectDocument(ProjectDocument $projectDocument, ProjectProfileData $projectDocumentDTO):ProjectDocument
    {
        $this->fillProjectDocumentFromDTO($projectDocument, $projectDocumentDTO);
        $projectDocument->save();

        return $projectDocument;
    }

    private function fillProjectDocumentFromDTO(ProjectDocument $projectDocument, ProjectProfileData $projectDocumentDTO)
    {
        $projectDocument->grant_profile_id = $projectDocumentDTO-> grant_profile_id;
        $projectDocument->document_name = $projectDocumentDTO->document_name;
        $projectDocument->document_path = $projectDocumentDTO->document_path;
        $projectDocument->description = $projectDocumentDTO->description;
    }

    //ATTACH EMPLOYEE
    public function attachEmployee(ProjectProfileData $projectDocumentDTO):void
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
