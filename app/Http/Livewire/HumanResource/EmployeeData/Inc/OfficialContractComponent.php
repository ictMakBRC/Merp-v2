<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use Livewire\Component;

class OfficialContractComponent extends Component
{
    public $employee_id;
    public $contract_summary;
    public $gross_salary;
    public $currency;
    public $start_date;
    public $end_date;
    public $contract_file;
    
    public function render()
    {
        return view('livewire.human-resource.employee-data.inc.official-contract-component');
    }
}
