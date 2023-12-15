<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Data\HumanResource\EmployeeData\TrainingHistoryData;
use App\Models\HumanResource\EmployeeData\TrainingProgram;
use App\Services\HumanResource\EmployeeData\TrainingHistoryService;

class TrainingInformationComponent extends Component
{
    use WithFileUploads;
    
    public $employee_id;
    public $start_date;
    public $end_date;
    public $organised_by;
    public $training_title;
    public $description;
    public $certificate;
    public $certificatePath;

    public $loadingInfo='';
    
    public $toggleForm=false;
    public $trainingInfo;
    
    protected $listeners = [
        'switchEmployee' => 'setEmployeeId',
    ];

    public function setEmployeeId($details)
    {
        $this->employee_id = $details['employeeId'];
        $this->loadingInfo = $details['info'];
        $this->toggleForm=false;
        $trainingHistoryDTO = new TrainingHistoryData();
        $this->reset($trainingHistoryDTO->resetInputs());
    }

    public function storeTrainingHistory()
    {
        if ($this->employee_id==null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No employee has been selected for this operation!',
            ]);
            return;
        }

        $trainingHistoryDTO = new TrainingHistoryData();
        $this->validate($trainingHistoryDTO->rules());

        DB::transaction(function (){
            if ($this->certificate != null) {
                $this->validate([
                    'certificate' => ['mimes:pdf', 'max:10000'],
                ]);
    
                $certificateFileName = date('YmdHis').'.'.$this->certificate->extension();
                $this->certificatePath = $this->certificate->storeAs('employees/training-certificates', $certificateFileName);
            } else {
                $this->certificatePath = null;
            }

            $trainingHistoryDTO = TrainingHistoryData::from([
                    'employee_id'=>$this->employee_id,
                    'start_date'=>$this->start_date,
                    'end_date'=> $this->end_date,
                    'organised_by'=> $this->organised_by,
                    'training_title'=> $this->training_title,
                    'description'=> $this->description,
                    'certificatePath'=> $this->certificatePath,
                ]
            );
  
            $trainingHistoryService = new TrainingHistoryService();

            $trainingHistory = $trainingHistoryService->createTrainingHistory($trainingHistoryDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Training information details created successfully']);

            $this->reset($trainingHistoryDTO->resetInputs());

        });
    }

    public function editData(TrainingProgram $trainingProgram)
    {
        $this->trainingInfo = $trainingProgram;

        $this->start_date = $trainingProgram->start_date;
        $this->end_date = $trainingProgram->end_date;
        $this->organised_by = $trainingProgram->organised_by;
        $this->training_title = $trainingProgram->training_title;
        $this->description = $trainingProgram->description;
 
        $this->toggleForm = true;
    }

    public function updateTrainingHistory()
    {
        if ($this->employee_id==null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No employee has been selected for this operation!',
            ]);
            return;
        }

        $trainingInformationDTO = new TrainingHistoryData();
        $this->validate($trainingInformationDTO->rules());

        DB::transaction(function (){
            
            if ($this->certificate != null) {
                $this->validate([
                    'certificate' => ['mimes:pdf', 'max:10000'],
                ]);
    
                $certificateFileName = date('YmdHis').'.'.$this->certificate->extension();
                $this->certificatePath = $this->certificate->storeAs('employees/training-certificates', $certificateFileName);
                if (file_exists(storage_path().$this->trainingInfo->certificate)) {
                    @unlink(storage_path().$this->trainingInfo->certificate);
                }
            } else {
                $this->certificatePath = $this->trainingInfo->certificate;
            }

            $trainingInformationDTO = TrainingHistoryData::from([
                'employee_id'=>$this->employee_id,
                'start_date'=>$this->start_date,
                'end_date'=> $this->end_date,
                'organised_by'=> $this->organised_by,
                'training_title'=> $this->training_title,
                'description'=> $this->description,
                'certificatePath'=> $this->certificatePath,
                ]
            );
  
            $trainingInformationService = new TrainingHistoryService();

            $trainingInformation = $trainingInformationService->updateTrainingHistory($this->trainingInfo,$trainingInformationDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Training information details updated successfully']);

            $this->reset($trainingInformationDTO->resetInputs());
            $this->toggleForm=false;

        });
    }
    
    public function render()
    {
        $data['trainingInformation'] = TrainingProgram::where('employee_id',$this->employee_id)->get()??collect([]);
     
        return view('livewire.human-resource.employee-data.inc.training-information-component',$data);
    }
}
