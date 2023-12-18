<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Data\HumanResource\EmployeeData\OfficialContractData;
use App\Models\HumanResource\EmployeeData\OfficialContract\OfficialContract;
use App\Models\HumanResource\Settings\Office;
use App\Services\HumanResource\EmployeeData\OfficialContractInformationService;
use Livewire\WithFileUploads;

class OfficialContractComponent extends Component
{
    use WithFileUploads;
    
    public $employee_id;
    public $contract_summary;
    public $gross_salary;
    public $currency_id;
    public $start_date;
    public $end_date;
    public $contract_file;

    public $contractFilePath;

    public $loadingInfo='';
    
    public $toggleForm=false;
    public $contractInfo;
    
    protected $listeners = [
        'switchEmployee' => 'setEmployeeId',
    ];

    public function setEmployeeId($details)
    {
        $this->employee_id = $details['employeeId'];
        $this->loadingInfo = $details['info'];
        $this->toggleForm=false;
        $officialContractInformationDTO = new OfficialContractData();
        $this->reset($officialContractInformationDTO->resetInputs());
    }

    public function storeOfficialContractInformation()
    {
        if ($this->employee_id==null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No employee has been selected for this operation!',
            ]);
            return;
        }

        $officialContractInformationDTO = new OfficialContractData();
        $this->validate($officialContractInformationDTO->rules());

        DB::transaction(function (){
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
                    'employee_id'=>$this->employee_id,
                    'contract_summary'=>$this->contract_summary,
                    'gross_salary'=> $this->gross_salary,
                    'currency_id'=> $this->currency_id,
                    'start_date'=> $this->start_date,
                    'end_date'=> $this->end_date,
                    'contractFilePath'=> $this->contractFilePath,
                ]
            );
  
            $officialContractInformationService = new OfficialContractInformationService();

            $officialContractInformation = $officialContractInformationService->createContractInformation($officialContractInformationDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Official Contract information details created successfully']);

            $this->reset($officialContractInformationDTO->resetInputs());

        });
    }
    
    public function editData(OfficialContract $officialContract)
    {
        $this->contractInfo = $officialContract;
        $this->contract_summary = $officialContract->contract_summary;
        $this->gross_salary =  $officialContract->gross_salary;
        $this->currency_id =  $officialContract->currency_id;
        $this->start_date =  $officialContract->start_date;
        $this->end_date =  $officialContract->end_date;
 
        $this->toggleForm = true;
    }

    public function updateOfficialContractInformation()
    {
        if ($this->employee_id==null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No employee has been selected for this operation!',
            ]);
            return;
        }

        $contractInformationDTO = new OfficialContractData();
        $this->validate($contractInformationDTO->rules());

        DB::transaction(function (){

            if ($this->contract_file != null) {
                $this->validate([
                    'contract_file' => ['mimes:pdf', 'max:10000'],
                ]);
    
                $contractFileName = date('YmdHis').'.'.$this->contract_file->extension();
                $this->contractFilePath = $this->contract_file->storeAs('employees/official-contracts', $contractFileName);
                if (file_exists(storage_path().$this->contractInfo->contract_file)) {
                    @unlink(storage_path().$this->contractInfo->contract_file);
                }
            } else {
                $this->contractFilePath = $this->contractInfo->contract_file;
            }

            $contractInformationDTO = OfficialContractData::from([
                'employee_id'=>$this->employee_id,
                'contract_summary'=>$this->contract_summary,
                'gross_salary'=> $this->gross_salary,
                'currency_id'=> $this->currency_id,
                'start_date'=> $this->start_date,
                'end_date'=> $this->end_date,
                'contractFilePath'=> $this->contractFilePath,
                ]
            );
  
            $contractInformationService = new OfficialContractInformationService();

            $contractInformation = $contractInformationService->updateContractInformation($this->contractInfo,$contractInformationDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Official Contract information details updated successfully']);

            $this->reset($contractInformationDTO->resetInputs());
            $this->toggleForm=false;

        });
    }

    public function render()
    {
        $data['officialContracts'] = OfficialContract::where('employee_id',$this->employee_id)->get()??collect([]);
        
        return view('livewire.human-resource.employee-data.inc.official-contract-component',$data);
    }
}
