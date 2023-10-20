<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use App\Data\HumanResource\EmployeeData\EmployeeFamilyData;
use App\Services\HumanResource\EmployeeData\EmployeeFamilyInformationService;
use Illuminate\Support\Facades\DB;
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

    public $loadingInfo = '';

    protected $listeners = [
        'switchEmployee' => 'setEmployeeId',
    ];

    public function setEmployeeId($details)
    {
        $this->employee_id = $details['employeeId'];
        $this->loadingInfo = $details['info'];
    }

    public function storeFamilyInformation()
    {
        if ($this->employee_id == null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No employee has been selected for this operation!',
            ]);

            return;
        }

        $familyInformationDTO = new EmployeeFamilyData();
        $this->validate($familyInformationDTO->rules());

        DB::transaction(function () {
            $familyInformationDTO = EmployeeFamilyData::from([
                'employee_id' => $this->employee_id,
                'member_type' => $this->member_type,
                'surname' => $this->surname,
                'first_name' => $this->first_name,
                'other_name' => $this->other_name,
                'member_status' => $this->member_status,
                'address' => $this->address,
                'contact' => $this->contact,
                'occupation' => $this->occupation,
                'employer' => $this->employer,
                'employer_contact' => $this->employer_contact,
                'employer_address' => $this->employer_address,
            ]
            );

            $familyInformationService = new EmployeeFamilyInformationService();

            $familyInformation = $familyInformationService->createFamilyInformation($familyInformationDTO);

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Family information details created successfully']);

            $this->reset($familyInformationDTO->resetInputs());

        });
    }

    public function render()
    {
        return view('livewire.human-resource.employee-data.inc.family-background-information-component');
    }
}
