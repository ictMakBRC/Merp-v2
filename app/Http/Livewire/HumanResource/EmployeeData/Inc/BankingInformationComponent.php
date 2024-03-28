<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Data\HumanResource\EmployeeData\EmployeeBankingData;
use App\Models\Finance\Settings\FmsFinanceInstitutions;
use App\Models\HumanResource\EmployeeData\BankingInformation;
use App\Services\HumanResource\EmployeeData\EmployeeBankingInformationService;

class BankingInformationComponent extends Component
{
    public $employee_id;
    public $bank_id;
    public $branch;
    public $account_name;
    public $account_number;
    public $currency_id;
    public $is_default;

    public $loadingInfo='';

    public $bankingInfo;
    public $toggleForm=false;
    
    protected $listeners = [
        'switchEmployee' => 'setEmployeeId',
    ];

    public function setEmployeeId($details)
    {
        $this->employee_id = $details['employeeId'];
        $this->loadingInfo = $details['info'];

        $this->toggleForm=false;
        $bankingInformationDTO = new EmployeeBankingData();
        $this->reset($bankingInformationDTO->resetInputs());
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
                'bank_id'=>    $this->bank_id,
                'branch'=>    $this->branch,
                'account_name'=>    $this->account_name,
                'account_number'=>    $this->account_number,
                'currency_id'=>    $this->currency_id,
                'is_default'=>    $this->is_default,
                ]
            );
  
            $bankingInformationService = new EmployeeBankingInformationService();

            $bankingInformation = $bankingInformationService->createBankingInformation($bankingInformationDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Banking information details created successfully']);

            $this->reset($bankingInformationDTO->resetInputs());

        });
    }

    public function editData(BankingInformation $bankingInformation)
    {
        $this->bankingInfo = $bankingInformation;

        $this->bank_id = $bankingInformation->bank_id;
        $this->branch = $bankingInformation->branch;
        $this->account_name = $bankingInformation->account_name;
        $this->account_number = $bankingInformation->account_number;
        $this->currency_id = $bankingInformation->currency_id;
        $this->is_default = $bankingInformation->is_default;
 
        $this->toggleForm = true;
    }

    public function updateBankingInformation()
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
        $this->validate($bankingInformationDTO->updateRules());

        DB::transaction(function (){
            $bankingInformationDTO = EmployeeBankingData::from([
                'employee_id'=>$this->employee_id,
                'bank_id'=>    $this->bank_id,
                'branch'=>    $this->branch,
                'account_name'=>    $this->account_name,
                'account_number'=>    $this->account_number,
                'currency_id'=>    $this->currency_id,
                'is_default'=>    $this->is_default,
                ]
            );
  
            $bankingInformationService = new EmployeeBankingInformationService();

            $bankingInformation = $bankingInformationService->updateBankingInformation($this->bankingInfo,$bankingInformationDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Banking information details updated successfully']);

            $this->reset($bankingInformationDTO->resetInputs());
            $this->toggleForm=false;

        });
    }

    public function render()
    {
      
        $data['bankingInformation'] = BankingInformation::with('currency')->where('employee_id',$this->employee_id)->get()??collect([]);
        $data['banks'] = FmsFinanceInstitutions::get()??collect([]);

        return view('livewire.human-resource.employee-data.inc.banking-information-component',$data);
    }
}
