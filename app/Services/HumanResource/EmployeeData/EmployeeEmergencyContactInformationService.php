<?php

namespace App\Services\HumanResource\EmployeeData;

use App\Models\HumanResource\EmployeeData\EmergencyContact;
use App\Data\HumanResource\EmployeeData\EmployeeEmergencyContactData;

class EmployeeEmergencyContactInformationService
{
    public function createContactInformation(EmployeeEmergencyContactData $contactInformationDTO):EmergencyContact
    {
        $contactInformation = new EmergencyContact();
        $this->fillContactInformationFromDTO($contactInformation, $contactInformationDTO);
        $contactInformation->save();

        return $contactInformation;
    }

    public function updateContactInformation(EmergencyContact $contactInformation, EmployeeEmergencyContactData $contactInformationDTO):EmergencyContact
    {
        $this->fillContactInformationFromDTO($contactInformation, $contactInformationDTO);
        $contactInformation->save();

        return $contactInformation;
    }

    private function fillContactInformationFromDTO(EmergencyContact $contactInformation, EmployeeEmergencyContactData $contactInformationDTO)
    {
        $contactInformation->employee_id = $contactInformationDTO->employee_id;
        $contactInformation->contact_name = $contactInformationDTO->contact_name;
        $contactInformation->contact_relationship = $contactInformationDTO->contact_relationship;
        $contactInformation->contact_address = $contactInformationDTO->contact_address;
        $contactInformation->contact_phone = $contactInformationDTO->contact_phone;
        $contactInformation->contact_email = $contactInformationDTO->contact_email;
    }
}
