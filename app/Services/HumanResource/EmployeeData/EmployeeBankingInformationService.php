<?php

namespace App\Services\HumanResource\EmployeeData;

use App\Data\HumanResource\EmployeeData\EmployeeBankingData;
use App\Models\HumanResource\EmployeeData\BankingInformation;

class EmployeeBankingInformationService
{
    public function createBankingInformation(EmployeeBankingData $bankingInformationDTO): BankingInformation
    {
        $bankingInformation = new BankingInformation();
        $this->fillBankingInformationFromDTO($bankingInformation, $bankingInformationDTO);
        $bankingInformation->save();

        if ($bankingInformation->is_default) {

            BankingInformation::where('employee_id', $bankingInformation->employee_id)
                ->where('id', '!=', $bankingInformation->id)
                ->update(['is_default' => false]);

        }

        return $bankingInformation;
    }

    public function updateBankingInformation(BankingInformation $bankingInformation, EmployeeBankingData $bankingInformationDTO): BankingInformation
    {
        $this->fillBankingInformationFromDTO($bankingInformation, $bankingInformationDTO);
        $bankingInformation->save();

        if ($bankingInformation->is_default) {

            BankingInformation::where('employee_id', $bankingInformation->employee_id)
                ->where('id', '!=', $bankingInformation->id)
                ->update(['is_default' => false]);

        }

        return $bankingInformation;
    }

    private function fillBankingInformationFromDTO(BankingInformation $bankingInformation, EmployeeBankingData $bankingInformationDTO)
    {
        $bankingInformation->employee_id = $bankingInformationDTO->employee_id;
        $bankingInformation->bank_name = $bankingInformationDTO->bank_name;
        $bankingInformation->branch = $bankingInformationDTO->branch;
        $bankingInformation->account_name = $bankingInformationDTO->account_name;
        $bankingInformation->account_number = $bankingInformationDTO->account_number;
        $bankingInformation->currency = $bankingInformationDTO->currency;
        $bankingInformation->is_default = $bankingInformationDTO->is_default;
    }
}
