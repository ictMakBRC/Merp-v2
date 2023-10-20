<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use App\Data\HumanResource\EmployeeData\TrainingHistoryData;
use App\Services\HumanResource\EmployeeData\TrainingHistoryService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

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

    public $loadingInfo = '';

    protected $listeners = [
        'switchEmployee' => 'setEmployeeId',
    ];

    public function setEmployeeId($details)
    {
        $this->employee_id = $details['employeeId'];
        $this->loadingInfo = $details['info'];
    }

    public function storeTrainingHistory()
    {
        if ($this->employee_id == null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No employee has been selected for this operation!',
            ]);

            return;
        }

        $trainingHistoryDTO = new TrainingHistoryData();
        $this->validate($trainingHistoryDTO->rules());

        DB::transaction(function () {
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
                'employee_id' => $this->employee_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'organised_by' => $this->organised_by,
                'training_title' => $this->training_title,
                'description' => $this->description,
                'certificatePath' => $this->certificatePath,
            ]
            );

            $trainingHistoryService = new TrainingHistoryService();

            $trainingHistory = $trainingHistoryService->createTrainingHistory($trainingHistoryDTO);

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Training information details created successfully']);

            $this->reset($trainingHistoryDTO->resetInputs());

        });
    }

    public function render()
    {
        return view('livewire.human-resource.employee-data.inc.training-information-component');
    }
}
