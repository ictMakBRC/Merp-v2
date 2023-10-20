<?php

namespace App\Services\HumanResource\EmployeeData;

use App\Data\HumanResource\EmployeeData\EmployeeFamilyData;
use App\Models\HumanResource\EmployeeData\FamilyBackground;

class EmployeeFamilyInformationService
{
    public function createFamilyInformation(EmployeeFamilyData $familyInformationDTO): FamilyBackground
    {
        $familyInformation = new FamilyBackground();
        $this->fillFamilyInformationFromDTO($familyInformation, $familyInformationDTO);
        $familyInformation->save();

        return $familyInformation;
    }

    public function updateFamilyInformation(FamilyBackground $familyInformation, EmployeeFamilyData $familyInformationDTO): FamilyBackground
    {
        $this->fillFamilyInformationFromDTO($familyInformation, $familyInformationDTO);
        $familyInformation->save();

        return $familyInformation;
    }

    private function fillFamilyInformationFromDTO(FamilyBackground $familyInformation, EmployeeFamilyData $familyInformationDTO)
    {
        $familyInformation->employee_id = $familyInformationDTO->employee_id;
        $familyInformation->member_type = $familyInformationDTO->member_type;
        $familyInformation->surname = $familyInformationDTO->surname;
        $familyInformation->first_name = $familyInformationDTO->first_name;
        $familyInformation->other_name = $familyInformationDTO->other_name;
        $familyInformation->member_status = $familyInformationDTO->member_status;
        $familyInformation->address = $familyInformationDTO->address;

        $familyInformation->contact = $familyInformationDTO->contact;
        $familyInformation->occupation = $familyInformationDTO->occupation;
        $familyInformation->employer = $familyInformationDTO->employer;
        $familyInformation->employer_contact = $familyInformationDTO->employer_contact;
        $familyInformation->employer_address = $familyInformationDTO->employer_address;
    }
}
