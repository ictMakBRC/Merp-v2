<?php

namespace App\Services;

use App\Models\HumanResource\EmployeeData\Employee;
use Illuminate\Support\Str;

class GeneratorService
{
    public static function password()
    {
        return Str::password(8);
    }

    public static function employeeNo()
    {
        $alphabets = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $emp_number = '';
        $randomAlphabetIndex = mt_rand(0, strlen($alphabets) - 1);
        $randomAlphabet = $alphabets[$randomAlphabetIndex];

        $latestEmpNo = Employee::select('employee_number')->orderBy('id', 'desc')->first();

        if ($latestEmpNo) {
            $emp_number = 'BRC'.((int) filter_var($latestEmpNo->employee_number, FILTER_SANITIZE_NUMBER_INT) + 1).$randomAlphabet;
        } else {
            $emp_number = 'BRC10000'.$randomAlphabet;
        }

        return $emp_number;
    }
}
