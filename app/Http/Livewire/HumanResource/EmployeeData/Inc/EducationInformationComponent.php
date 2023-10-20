<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use App\Data\HumanResource\EmployeeData\EducationHistoryData;
use App\Services\HumanResource\EmployeeData\EducationHistoryService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

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

    public $loadingInfo = '';

    protected $listeners = [
        'switchEmployee' => 'setEmployeeId',
    ];

    public function setEmployeeId($details)
    {
        $this->employee_id = $details['employeeId'];
        $this->loadingInfo = $details['info'];
    }

    public function storeEducationHistory()
    {
        if ($this->employee_id == null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No employee has been selected for this operation!',
            ]);

            return;
        }

        $educationHistoryDTO = new EducationHistoryData();
        $this->validate($educationHistoryDTO->rules());

        DB::transaction(function () {
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
                'employee_id' => $this->employee_id,
                'level' => $this->level,
                'school' => $this->school,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'award' => $this->award,
                'awardFilePath' => $this->awardFilePath,
            ]
            );

            $educationHistoryService = new EducationHistoryService();

            $educationHistory = $educationHistoryService->createEducationHistory($educationHistoryDTO);

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Education information details created successfully']);

            $this->reset($educationHistoryDTO->resetInputs());

        });
    }

    public function render()
    {
        return view('livewire.human-resource.employee-data.inc.education-information-component');
    }
}
