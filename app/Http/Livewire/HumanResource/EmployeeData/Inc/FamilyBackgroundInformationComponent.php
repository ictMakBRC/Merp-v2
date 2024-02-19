<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Data\HumanResource\EmployeeData\EmployeeFamilyData;
use App\Models\HumanResource\EmployeeData\FamilyBackground;
use App\Services\HumanResource\EmployeeData\EmployeeFamilyInformationService;

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

    public $loadingInfo='';
    public $familyInfo;
    public $toggleForm=false;
    
    protected $listeners = [
        'switchEmployee' => 'setEmployeeId',
    ];

    public function setEmployeeId($details)
    {
        $this->employee_id = $details['employeeId'];
        $this->loadingInfo = $details['info'];

        $this->toggleForm=false;
        $familyInformationDTO = new EmployeeFamilyData();
        $this->reset($familyInformationDTO->resetInputs());
    }

    public function storeFamilyInformation()
    {
        if ($this->employee_id==null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No employee has been selected for this operation!',
            ]);
            return;
        }

        $familyInformationDTO = new EmployeeFamilyData();
        $this->validate($familyInformationDTO->rules());

        DB::transaction(function (){
            $familyInformationDTO = EmployeeFamilyData::from([
                    'employee_id'=>$this->employee_id,
                    'member_type'=>$this->member_type,
                    'surname'=>$this->surname,
                    'first_name'=>$this->first_name,
                    'other_name'=>$this->other_name,
                    'member_status'=>$this->member_status,
                    'address'=>$this->address,
                    'contact'=>$this->contact,
                    'occupation'=>$this->occupation,
                    'employer'=>$this->employer,
                    'employer_contact'=>$this->employer_contact,
                    'employer_address'=>$this->employer_address,
                ]
            );
  
            $familyInformationService = new EmployeeFamilyInformationService();

            $familyInformation = $familyInformationService->createFamilyInformation($familyInformationDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Family information details created successfully']);

            $this->reset($familyInformationDTO->resetInputs());

        });
    }
   
    public function editData(FamilyBackground $familyInformation)
    {
        $this->familyInfo = $familyInformation;

        $this->member_type = $familyInformation->member_type;
        $this->surname = $familyInformation->surname;
        $this->first_name = $familyInformation->first_name;
        $this->other_name = $familyInformation->other_name;
        $this->member_status = $familyInformation->member_status;
        $this->address = $familyInformation->address;
        $this->contact = $familyInformation->contact;
        $this->occupation = $familyInformation->occupation;
        $this->employer = $familyInformation->employer;
        $this->employer_contact = $familyInformation->employer_contact;
        $this->employer_address = $familyInformation->employer_address;
 
        $this->toggleForm = true;
    }

    public function updateFamilyInformation()
    {
        if ($this->employee_id==null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No employee has been selected for this operation!',
            ]);
            return;
        }

        $familyInformationDTO = new EmployeeFamilyData();
        $this->validate($familyInformationDTO->rules());

        DB::transaction(function (){
            $familyInformationDTO = EmployeeFamilyData::from([
                'employee_id'=>$this->employee_id,
                'member_type'=>$this->member_type,
                'surname'=>$this->surname,
                'first_name'=>$this->first_name,
                'other_name'=>$this->other_name,
                'member_status'=>$this->member_status,
                'address'=>$this->address,
                'contact'=>$this->contact,
                'occupation'=>$this->occupation,
                'employer'=>$this->employer,
                'employer_contact'=>$this->employer_contact,
                'employer_address'=>$this->employer_address,
                ]
            );
  
            $familyInformationService = new EmployeeFamilyInformationService();

            $familyInformation = $familyInformationService->updateFamilyInformation($this->familyInfo,$familyInformationDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Family information details updated successfully']);

            $this->reset($familyInformationDTO->resetInputs());
            $this->toggleForm=false;

        });
    }

    public function render()
    {
        $data['familyInformation'] = FamilyBackground::where('employee_id',$this->employee_id)->get()??collect([]);
       
        return view('livewire.human-resource.employee-data.inc.family-background-information-component',$data);
    }
}
