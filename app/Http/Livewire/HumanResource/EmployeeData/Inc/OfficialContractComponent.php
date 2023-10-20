<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use App\Data\HumanResource\EmployeeData\OfficialContractData;
use App\Services\HumanResource\EmployeeData\OfficialContractInformationService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class OfficialContractComponent extends Component
{
    use WithFileUploads;

    public $employee_id;

    public $contract_summary;

    public $gross_salary;

    public $currency;

    public $start_date;

    public $end_date;

    public $contract_file;

    public $contractFilePath;

    public $loadingInfo = '';

    protected $listeners = [
        'switchEmployee' => 'setEmployeeId',
    ];

    public function setEmployeeId($details)
    {
        $this->employee_id = $details['employeeId'];
        $this->loadingInfo = $details['info'];
    }

    public function storeOfficialContractInformation()
    {
        if ($this->employee_id == null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No employee has been selected for this operation!',
            ]);

            return;
        }

        $officialContractInformationDTO = new OfficialContractData();
        $this->validate($officialContractInformationDTO->rules());

        DB::transaction(function () {
            if ($this->contract_file != null) {
                $this->validate([
                    'contract_file' => ['mimes:pdf', 'max:10000'],
                ]);

                $contractFileName = date('YmdHis').'.'.$this->contract_file->extension();
                $this->contractFilePath = $this->contract_file->storeAs('employees/official-contracts', $contractFileName);
            } else {
                $this->contractFilePath = null;
            }

            $officialContractInformationDTO = OfficialContractData::from([
                'employee_id' => $this->employee_id,
                'contract_summary' => $this->contract_summary,
                'gross_salary' => $this->gross_salary,
                'currency' => $this->currency,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'contractFilePath' => $this->contractFilePath,
            ]
            );

            $officialContractInformationService = new OfficialContractInformationService();

            $officialContractInformation = $officialContractInformationService->createContractInformation($officialContractInformationDTO);

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Official Contract information details created successfully']);

            $this->reset($officialContractInformationDTO->resetInputs());

        });
    }

    public function render()
    {
        return view('livewire.human-resource.employee-data.inc.official-contract-component');
    }
}
