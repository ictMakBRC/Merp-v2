<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Data\HumanResource\EmployeeData\EmployeeEmergencyContactData;
use App\Models\HumanResource\EmployeeData\EmergencyContact;
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
    public $contactInfo;
    public $toggleForm=false;
    
    protected $listeners = [
        'switchEmployee' => 'setEmployeeId',
    ];

    public function setEmployeeId($details)
    {
        $this->employee_id = $details['employeeId'];
        $this->loadingInfo = $details['info'];
        $this->toggleForm=false;
        $emergencyContactInformationDTO = new EmployeeEmergencyContactData();
        $this->reset($emergencyContactInformationDTO->resetInputs());

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

    public function editData(EmergencyContact $emergencyContact)
    {
        $this->contactInfo = $emergencyContact;

        $this->contact_relationship = $emergencyContact->contact_relationship;
        $this->contact_name =  $emergencyContact->contact_name;
        $this->contact_email =  $emergencyContact->contact_email;
        $this->contact_phone =  $emergencyContact->contact_phone;
        $this->contact_address =  $emergencyContact->contact_address;
 
        $this->toggleForm = true;
    }

    public function updateContactInformation()
    {
        if ($this->employee_id==null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No employee has been selected for this operation!',
            ]);
            return;
        }

        $emergencyContactInformationDTO = new EmployeeEmergencyContactData();
        $this->validate($emergencyContactInformationDTO->rules());

        DB::transaction(function (){
            $emergencyContactInformationDTO = EmployeeEmergencyContactData::from([
                'employee_id'=>$this->employee_id,
                'contact_relationship'=>$this->contact_relationship,
                'contact_name'=> $this->contact_name,
                'contact_email'=> $this->contact_email,
                'contact_phone'=> $this->contact_phone,
                'contact_address'=> $this->contact_address,
                ]
            );
  
            $emergencyContactInformationService = new EmployeeEmergencyContactInformationService();

            $emergencyContactInformation = $emergencyContactInformationService->updateContactInformation($this->contactInfo,$emergencyContactInformationDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Emergency Contact details updated successfully']);

            $this->reset($emergencyContactInformationDTO->resetInputs());
            $this->toggleForm=false;

        });
    }

    public function render()
    {
        $data['emergencyInformation'] = EmergencyContact::where('employee_id',$this->employee_id)->get()??collect([]);
       
        return view('livewire.human-resource.employee-data.inc.emergency-contact-information-component',$data);
    }
}
