<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Data\HumanResource\EmployeeData\EmployeeEmergencyContactData;
use App\Services\HumanResource\EmployeeData\EmployeeEmergencyContactInformationService;

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

    public function storeContactInformation()
    {
        if ($this->employee_id==null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No employee has been selected for this operation!',
            ]);
            return;
        }

        $contactInformationDTO = new EmployeeEmergencyContactData();
        $this->validate($contactInformationDTO->rules());

        DB::transaction(function (){
            $contactInformationDTO = EmployeeEmergencyContactData::from([
                    'employee_id'=>$this->employee_id,
                    'contact_relationship'=>$this->contact_relationship,
                    'contact_name'=> $this->contact_name,
                    'contact_email'=> $this->contact_email,
                    'contact_phone'=> $this->contact_phone,
                    'contact_address'=> $this->contact_address,
                ]
            );
  
            $contactInformationService = new EmployeeEmergencyContactInformationService();

            $contactInformation = $contactInformationService->createContactInformation($contactInformationDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Contact information details created successfully']);

            $this->reset($contactInformationDTO->resetInputs());

        });
    }

    public function render()
    {
        return view('livewire.human-resource.employee-data.inc.emergency-contact-information-component');
    }
}
