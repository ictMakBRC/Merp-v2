<?php

namespace App\Services;

use App\Models\Finance\Budget\FmsBudget;
use App\Models\Finance\Invoice\FmsInvoice;
use Illuminate\Support\Str;
use App\Models\Procurement\Settings\Provider;
use App\Models\HumanResource\EmployeeData\Employee;
use App\Models\Procurement\Request\ProcurementRequest;
use App\Models\Procurement\Settings\ProcurementSubcategory;

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


    
    public static function providerNo()
    {
        $provider_code = '';
        $yearStart = date('y');
        $latestProviderNo = Provider::select('provider_code')->orderBy('id', 'desc')->first();;
        $randomAlphabet = ucfirst(Str::random(1));

        if ($latestProviderNo) {
            $latestProviderNoSplit = explode('-', $latestProviderNo->provider_code);
            $providerYear = (int) filter_var($latestProviderNoSplit[0], FILTER_SANITIZE_NUMBER_INT);

            if ($providerYear == $yearStart) {
                $provider_code = $latestProviderNoSplit[0].'-'.str_pad(((int) filter_var($latestProviderNoSplit[1], FILTER_SANITIZE_NUMBER_INT) + 1), 3, '0', STR_PAD_LEFT).$randomAlphabet;
            } else {
                $provider_code = $yearStart.'PRV'.'-001'.$randomAlphabet;
            }
        } else {
            $provider_code = $yearStart.'PRV'.'-001'.$randomAlphabet;
        }

        return $provider_code;
    }

    private static function incrementSubcategoryCode($code) {
        $parts = explode('/', $code);
        $lastPart = end($parts);
        $newLastPart = intval($lastPart) + 1;
        $newCode = implode('/', array_slice($parts, 0, -1)) . '/' . str_pad($newLastPart, 3, '0', STR_PAD_LEFT);
        return $newCode;
    }

    public static function procurementSubcategoryCode($category) {
        $categoryCode = '';

        switch ($category) {
            case 'Supplies':
                $categoryCode = 'Sup';
                break;
            case 'Services':
                $categoryCode = 'Svcs';
                break;
            case 'Works':
                $categoryCode = 'Works';
                break;
            case 'Consultancy':
                $categoryCode = 'Svcs';
                break;
            default:
                // Handle invalid category
                break;
        }

        // Retrieve the current category
        $latestSubcategory = ProcurementSubcategory::where('category', $category)->orderBy('id', 'desc')->first();
        if($latestSubcategory){
            return Self::incrementSubcategoryCode($latestSubcategory->code);
        }else{
            if($category=='Consultancy'){
                $categoryCount = ProcurementSubcategory::where('category', 'Services')->count() + 1;
                $categoryCode = $categoryCode . '/' . str_pad($categoryCount, 3, '0', STR_PAD_LEFT);

                $consultanceSubcategory = ProcurementSubcategory::create([
                    'category'=>'Services',
                    'code'=>$categoryCode,
                    'name'=>$category,
                ]);
                return $consultanceSubcategory->code . '/' . str_pad(1, 3, '0', STR_PAD_LEFT);  

            }else{
                return $categoryCode . '/' . str_pad(1, 3, '0', STR_PAD_LEFT);
            }
        }
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

    //Generate a request code
    public static function requestCode()
    {
      $yearMonth = date('ym');
      $characters = 'ABCDEFGHJKLMNOPQRSTUVWXYZ123456789';
      $l = $characters[rand(2, strlen($characters) - 4)];
      $randomGeneratedNumber = intval('0'.mt_rand(1, 9).mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9));

      return 'MERP-RQ/'.$yearMonth.'-'.$randomGeneratedNumber.'-'.$l;
    }

    public static function procurementRequestRef()
    {
        $requestRef = '';
        $yearStart = date('y');
        $latestRef = ProcurementRequest::select('reference_no')->orderBy('id', 'desc')->first();;
        $randomAlphabet = ucfirst(Str::random(1));

        if ($latestRef) {
            $latestRefSplit = explode('-', $latestRef->reference_no);
            $refYear = (int) filter_var($latestRefSplit[0], FILTER_SANITIZE_NUMBER_INT);

            if ($refYear == $yearStart) {
                $requestRef = $latestRefSplit[0].'-'.str_pad(((int) filter_var($latestRefSplit[1], FILTER_SANITIZE_NUMBER_INT) + 1), 3, '0', STR_PAD_LEFT).$randomAlphabet;
            } else {
                $requestRef = $yearStart.'PROC'.'-001'.$randomAlphabet;
            }
        } else {
            $requestRef = $yearStart.'PROC'.'-001'.$randomAlphabet;
        }

        return $requestRef;
    }

}
