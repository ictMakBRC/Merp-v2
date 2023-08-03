<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Data\HumanResource\EmployeeData\EmployeeBankingData;
use App\Services\HumanResource\EmployeeData\EmployeeBankingInformationService;

class BankingInformationComponent extends Component
{
    public $employee_id;
    public $bank_name;
    public $branch;
    public $account_name;
    public $account_number;
    public $currency;
    public $is_default;

    public $loadingInfo='';
    
    protected $listeners = [
        'switchEmployee' => 'setEmployeeId',
    ];

    public function setEmployeeId($details)
    {
        $this->employee_id = $details['employeeId'];
        $this->loadingInfo = $details['info'];
    }

    public function storeBankingInformation()
    {
        if ($this->employee_id==null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No employee has been selected for this operation!',
            ]);
            return;
        }

        $bankingInformationDTO = new EmployeeBankingData();
        $this->validate($bankingInformationDTO->rules());

        DB::transaction(function (){
            $bankingInformationDTO = EmployeeBankingData::from([
                'employee_id'=>$this->employee_id,
                'bank_name'=>    $this->bank_name,
                'branch'=>    $this->branch,
                'account_name'=>    $this->account_name,
                'account_number'=>    $this->account_number,
                'currency'=>    $this->currency,
                'is_default'=>    $this->is_default,
                ]
            );
  
            $bankingInformationService = new EmployeeBankingInformationService();

            $bankingInformation = $bankingInformationService->createBankingInformation($bankingInformationDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Banking information details created successfully']);

            $this->reset($bankingInformationDTO->resetInputs());

        });
    }

    public function render()
    {
        return view('livewire.human-resource.employee-data.inc.banking-information-component');
    }
}
