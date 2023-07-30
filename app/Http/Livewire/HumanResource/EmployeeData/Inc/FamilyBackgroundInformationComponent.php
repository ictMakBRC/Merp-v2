<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use Livewire\Component;

class FamilyBackgroundInformationComponent extends Component
{
    public $employee_id;
    public $member_type;
    public $surname;
    public $first_name;
    public $other_name;

    public $member_status;
    public $address;
    public $contact;
    public $occupation;
    public $employer;
    public $employer_contact;
    public $employer_address;

    //Dependants
    public $child_name;
    public $birth_date;
   
    public function render()
    {
        return view('livewire.human-resource.employee-data.inc.family-background-information-component');
    }
}
