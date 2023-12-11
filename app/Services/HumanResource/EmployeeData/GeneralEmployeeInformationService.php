<?php

namespace App\Services\HumanResource\EmployeeData;

use App\Models\HumanResource\EmployeeData\Employee;
use App\Data\HumanResource\EmployeeData\GeneralEmployeeData;

class GeneralEmployeeInformationService
{
    public function createEmployee(GeneralEmployeeData $employeeDTO):Employee
    {
        $employee = new Employee();
        $this->fillEmployeeFromDTO($employee, $employeeDTO);
        $employee->save();

        return $employee;
    }

    public function updateEmployee(Employee $employee, GeneralEmployeeData $employeeDTO):Employee
    {
        $this->fillEmployeeFromDTO($employee, $employeeDTO);
        $employee->save();

        return $employee;
    }

    private function fillEmployeeFromDTO(Employee $employee, GeneralEmployeeData $employeeDTO)
    {
        $employee->entry_type = $employeeDTO->entry_type;
        $employee->nin_number = $employeeDTO->nin_number;
        $employee->title = $employeeDTO->title;
        $employee->surname = $employeeDTO->surname;
        $employee->first_name = $employeeDTO->first_name;
        $employee->other_name = $employeeDTO->other_name;
        $employee->gender = $employeeDTO->gender;
        $employee->nationality = $employeeDTO->nationality;
        $employee->birth_date = $employeeDTO->birth_date;
        $employee->birth_place = $employeeDTO->birth_place;
        $employee->religious_affiliation = $employeeDTO->religious_affiliation;
        $employee->height = $employeeDTO->height;
        $employee->weight = $employeeDTO->weight;
        $employee->blood_type = $employeeDTO->blood_type;
        $employee->civil_status = $employeeDTO->civil_status;
        $employee->address = $employeeDTO->address;
        $employee->email = $employeeDTO->email;
        $employee->alt_email = $employeeDTO->alt_email;
        $employee->contact = $employeeDTO->contact;
        $employee->alt_contact = $employeeDTO->alt_contact;
        $employee->designation_id = $employeeDTO->designation_id;
        $employee->station_id = $employeeDTO->station_id;
        $employee->department_id = $employeeDTO->department_id;
        $employee->reporting_to = $employeeDTO->reporting_to;
        $employee->work_type = $employeeDTO->work_type;
        $employee->join_date = $employeeDTO->join_date;
        $employee->tin_number = $employeeDTO->tin_number;
        $employee->nssf_number = $employeeDTO->nssf_number;
        $employee->cv = $employeeDTO->cv;
        $employee->photo = $employeeDTO->photo;
        $employee->signature = $employeeDTO->signature;
    }
}
