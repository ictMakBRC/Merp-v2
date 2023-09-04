<?php

namespace App\Services;

use App\Models\Finance\Budget\FmsBudget;
use App\Models\Finance\Invoice\FmsInvoice;
use Illuminate\Support\Str;
use App\Models\HumanResource\EmployeeData\Employee;

class GeneratorService
{
    public static function password()
    {
        return Str::password(8);
    }

    public static function employeeNo(){
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

    public static function budgetIdentifier()
    {
        $identifier = '';
        $yearStart = date('y');
        $characters = 'ABCDEFGHJKLMNOPQRSTUVWXYZ';
        $l = $characters[rand(0, strlen($characters) - 2)];
        $latestIdentifier = FmsBudget::select('code')->orderBy('id', 'desc')->first();

        if ($latestIdentifier) {
            $numberSplit = explode('-', $latestIdentifier->identifier);
            $numberYear = (int) filter_var($numberSplit[0], FILTER_SANITIZE_NUMBER_INT);

            if ($numberYear == $yearStart) {
                $identifier = $numberSplit[0].'-'.str_pad(((int) filter_var($numberSplit[1], FILTER_SANITIZE_NUMBER_INT) + 1), 4, '0', STR_PAD_LEFT).$l;
            } else {
                $identifier = 'FMB'.$yearStart.'-0001'.$l;
            }
        } else {
            $identifier = 'FMB'.$yearStart.'-0001'.$l;
        }

        return $identifier;
    }


    public static function getInvNumber()
    {
        $identifier = '';
        $yearStart = date('y');
        $characters = 'ABCDEFGHJKLMNOPQRSTUVWXYZ';
        $l = $characters[rand(0, strlen($characters) - 2)];
        $latestIdentifier = FmsInvoice::select('invoice_no')->orderBy('id', 'desc')->first();

        if ($latestIdentifier) {
            $numberSplit = explode('-', $latestIdentifier->identifier);
            $numberYear = (int) filter_var($numberSplit[0], FILTER_SANITIZE_NUMBER_INT);

            if ($numberYear == $yearStart) {
                $identifier = $numberSplit[0].'-'.str_pad(((int) filter_var($numberSplit[1], FILTER_SANITIZE_NUMBER_INT) + 1), 4, '0', STR_PAD_LEFT).$l;
            } else {
                $identifier = 'BRC-INV'.$yearStart.'-0001'.$l;
            }
        } else {
            $identifier = 'BRC-INV'.$yearStart.'-0001'.$l;
        }

        return $identifier;
    }

    public static function getNumber($length)
    {
        $characters = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return str_shuffle($randomString);
        return $randomString;
    }


}
