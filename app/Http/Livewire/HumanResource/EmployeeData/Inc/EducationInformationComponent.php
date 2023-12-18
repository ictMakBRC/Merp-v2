<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Data\HumanResource\EmployeeData\EducationHistoryData;
use App\Models\HumanResource\EmployeeData\EducationBackground;
use App\Services\HumanResource\EmployeeData\EducationHistoryService;

class EducationInformationComponent extends Component
{
    use WithFileUploads;

    public $employee_id;
    public $level;
    public $school;
    public $start_date;
    public $end_date;
    public $award;
    public $award_document;
    public $awardFilePath;
    
    public $loadingInfo='';
    public $toggleForm=false;
    public $educationInfo;
    
    protected $listeners = [
        'switchEmployee' => 'setEmployeeId',
    ];

    public function setEmployeeId($details)
    {
        $this->employee_id = $details['employeeId'];
        $this->loadingInfo = $details['info'];
        $this->toggleForm=false;
        $educationHistoryDTO = new EducationHistoryData();
        $this->reset($educationHistoryDTO->resetInputs());
    }

    public function storeEducationHistory()
    {
        if ($this->employee_id==null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No employee has been selected for this operation!',
            ]);
            return;
        }

        $educationHistoryDTO = new EducationHistoryData();
        $this->validate($educationHistoryDTO->rules());

        DB::transaction(function (){
            if ($this->award_document != null) {
                $this->validate([
                    'award_document' => ['mimes:pdf', 'max:10000'],
                ]);
    
                $awardFileName = date('YmdHis').'.'.$this->award_document->extension();
                $this->awardFilePath = $this->award_document->storeAs('employees/education-awards', $awardFileName);
            } else {
                $this->awardFilePath = null;
            }

            $educationHistoryDTO = EducationHistoryData::from([
                    'employee_id'=>$this->employee_id,
                    'level'=>$this->level,
                    'school'=>$this->school,
                    'start_date'=> $this->start_date,
                    'end_date'=> $this->end_date,
                    'award'=> $this->award,
                    'awardFilePath'=> $this->awardFilePath,
                ]
            );
  
            $educationHistoryService = new EducationHistoryService();

            $educationHistory = $educationHistoryService->createEducationHistory($educationHistoryDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Education information details created successfully']);

            $this->reset($educationHistoryDTO->resetInputs());

        });
    }

    public function editData(EducationBackground $educationBackground)
    {
        $this->educationInfo = $educationBackground;

        $this->level =  $educationBackground->level;
        $this->school =  $educationBackground->school;
        $this->start_date =   $educationBackground->start_date;
        $this->end_date =   $educationBackground->end_date;
        $this->award =   $educationBackground->award;

        $this->toggleForm = true;
    }

    public function updateEducationHistory()
    {
        if ($this->employee_id==null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No employee has been selected for this operation!',
            ]);
            
            return;
        }

        $educationHistoryDTO = new EducationHistoryData();
        $this->validate($educationHistoryDTO->rules());

        DB::transaction(function (){
            if ($this->award_document != null) {
                $this->validate([
                    'award_document' => ['mimes:pdf', 'max:10000'],
                ]);
    
                $awardFileName = date('YmdHis').'.'.$this->award_document->extension();
                $this->awardFilePath = $this->award_document->storeAs('employees/education-awards', $awardFileName);
                if (file_exists(storage_path().$this->educationInfo->award_document)) {
                    @unlink(storage_path().$this->educationInfo->award_document);
                }

            } else {
                $this->awardFilePath = $this->educationInfo->award_document;
            }

            $educationHistoryDTO = EducationHistoryData::from([
                    'employee_id'=>$this->employee_id,
                    'level'=>$this->level,
                    'school'=>$this->school,
                    'start_date'=> $this->start_date,
                    'end_date'=> $this->end_date,
                    'award'=> $this->award,
                    'awardFilePath'=> $this->awardFilePath,
                ]
            );
  
            $educationHistoryService = new EducationHistoryService();

            $educationHistory = $educationHistoryService->updateEducationHistory($this->educationInfo,$educationHistoryDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Education information details updated successfully']);

            $this->reset($educationHistoryDTO->resetInputs());
            $this->toggleForm=false;

        });
    }
    
    public function render()
    {
        $data['educationInformation'] = EducationBackground::where('employee_id',$this->employee_id)->get()??collect([]);

        return view('livewire.human-resource.employee-data.inc.education-information-component',$data);
    }
}
