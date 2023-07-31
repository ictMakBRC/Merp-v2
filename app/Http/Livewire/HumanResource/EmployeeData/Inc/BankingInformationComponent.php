<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use Livewire\Component;

class BankingInformationComponent extends Component
{
    public $employee_id;
    public $bank_name;
    public $branch;
    public $account_name;
    public $account_number;
    public $currency;
    public $is_default;

    public function render()
    {
        return view('livewire.human-resource.employee-data.inc.banking-information-component');
    }
}
