<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use Livewire\Component;
use App\Models\HumanResource\Settings\Station;
use App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\Settings\Designation;
use App\Models\HumanResource\EmployeeData\Employee;

class GeneralInformationComponent extends Component
{
    public $employee_id;
    public $entry_type;
    public $nin_number;
    public $title;
    public $surname;
    public $first_name;
    public $other_name;
    public $gender;
    public $nationality;
    public $birthday;
    public $birth_place;
    public $religious_affiliation;
    public $height;
    public $weight;
    public $blood_type;
    public $civil_status;
    public $address;
    public $email;
    public $alt_email;
    public $contact;
    public $alt_contact;
    public $designation_id;
    public $station_id;
    public $department_id;
    public $reporting_to;
    public $work_type;
    public $join_date;
    public $tin_number;
    public $nssf_number;
    public $cv;
    public $photo;
    public $signature;

    public function render()
    {
        $data['designations'] = Designation::where('is_active',true)->get();
        $data['stations'] = Station::where('is_active',true)->get();
        $data['departments'] = Department::where('is_active',true)->get();
        $data['supervisors'] = Employee::where('is_active',true)->get();
        

        return view('livewire.human-resource.employee-data.inc.general-information-component',$data);
    }
}
