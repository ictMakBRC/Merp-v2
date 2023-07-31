<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use Livewire\Component;

class EmergencyContactInformationComponent extends Component
{
    public $employee_id;
    public $contact_relationship;
    public $contact_name;
    public $contact_email;
    public $contact_phone;
    public $contact_address;

    public $loadingInfo='';
    
    protected $listeners = [
        'switchEmployee' => 'setEmployeeId',
    ];

    public function setEmployeeId($details)
    {
        $this->employee_id = $details['employeeId'];
        $this->loadingInfo = $details['info'];
    }

    public function render()
    {
        return view('livewire.human-resource.employee-data.inc.emergency-contact-information-component');
    }
}
