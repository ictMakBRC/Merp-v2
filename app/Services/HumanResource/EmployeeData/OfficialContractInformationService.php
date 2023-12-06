<?php

namespace App\Services\HumanResource\EmployeeData;

use App\Data\HumanResource\EmployeeData\OfficialContractData;
use App\Models\HumanResource\EmployeeData\OfficialContract\OfficialContract;

class OfficialContractInformationService
{
    public function createContractInformation(OfficialContractData $officialContractDTO):OfficialContract
    {
        $contractInformation = new OfficialContract();
        $this->fillContractInformationFromDTO($contractInformation, $officialContractDTO);
        $contractInformation->save();
        OfficialContract::where(['employee_id' => $contractInformation->employee_id, 'status' => 1])
        ->where('id','!=',$contractInformation->id)
        ->update(['status'=>0]);

        return $contractInformation;
    }

    public function updateContractInformation(OfficialContract $contractInformation, OfficialContractData $officialContractDTO):OfficialContract
    {
        $this->fillContractInformationFromDTO($contractInformation, $officialContractDTO);
        $contractInformation->save();

        return $contractInformation;
    }

    private function fillContractInformationFromDTO(OfficialContract $contractInformation, OfficialContractData $officialContractDTO)
    {
        $contractInformation->employee_id = $officialContractDTO->employee_id;
        $contractInformation->contract_summary = $officialContractDTO->contract_summary;
        $contractInformation->gross_salary =  $officialContractDTO->gross_salary;
        $contractInformation->currency_id =  $officialContractDTO->currency_id;
        $contractInformation->start_date = $officialContractDTO->start_date;
        $contractInformation->end_date =  $officialContractDTO->end_date;
        $contractInformation->contract_file = $officialContractDTO->contractFilePath;
    }
}
