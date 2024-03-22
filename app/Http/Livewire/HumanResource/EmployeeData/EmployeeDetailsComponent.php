<?php

namespace App\Http\Livewire\HumanResource\EmployeeData;

use Livewire\Component;
use App\Models\HumanResource\EmployeeData\Employee;
use App\Models\HumanResource\EmployeeData\WorkExperience;
use App\Models\HumanResource\EmployeeData\TrainingProgram;
use App\Models\HumanResource\EmployeeData\EmergencyContact;
use App\Models\HumanResource\EmployeeData\FamilyBackground;
use App\Models\HumanResource\EmployeeData\BankingInformation;
use App\Models\HumanResource\EmployeeData\EducationBackground;
use App\Models\HumanResource\EmployeeData\OfficialContract\OfficialContract;

class EmployeeDetailsComponent extends Component
{
    public $employee_id;
    public function mount($id){
        $this->employee_id=$id;
    }

    public function render()
    {
        $data['employee'] = Employee::with('projects')->findOrFail($this->employee_id);
        $data['bankingInformation'] = BankingInformation::with('currency')->where('employee_id',$this->employee_id)->get()??collect([]);
        $data['educationInformation'] = EducationBackground::where('employee_id',$this->employee_id)->get()??collect([]);
        $data['emergencyInformation'] = EmergencyContact::where('employee_id',$this->employee_id)->get()??collect([]);
        $data['familyInformation'] = FamilyBackground::where('employee_id',$this->employee_id)->get()??collect([]);
        $data['officialContracts'] = OfficialContract::where('employee_id',$this->employee_id)->get()??collect([]);
        $data['trainingInformation'] = TrainingProgram::where('employee_id',$this->employee_id)->get()??collect([]);
        $data['workExperienceInformation'] = WorkExperience::where('employee_id',$this->employee_id)->get()??collect([]);
        
        return view('livewire.human-resource.employee-data.employee-details-component',$data);
    }
}
