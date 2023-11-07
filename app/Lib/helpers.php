<?php

use App\Models\User;
use Illuminate\Support\Str;
use App\Jobs\ProcessDispatchMails;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Models\Finance\Settings\FmsCurrencyUpdate;

function showWhenLinkActive($link)
{
    return Route::currentRouteName() == $link;
}

/**
 * Return all the active links
 * @param array $links
 * @param string $class
 */
function isLinkActive(array $links, $class = 'active')
{
    foreach ($links as $link) {
        if(showWhenLinkActive($link)) {
            return $class;
        }
    }
    return "";
}

/**
 * Method to globalize the authentication of a user
 * @param $permission - examples of permissions are f_tat, c_bsc etc
 */
function  isUserAuthorized($permission){

        // get the user
        $user = auth()->user();

        // isAuthorized true or false
        $isAuthorized = false;

        if($user->hasPermission($permission)){
            $isAuthorized = true;
        }

        return $isAuthorized;
}

/**
 * If employee1 goes on leave and employee1 indicates that employee2 is their OIC(Officer in Charge - or deputy)/Supervisor
 * Then this function should return employee1 thereby indicating that  employee2 is the OIC of employee1
 * @param $employee - current employee
 */
function getUsersDelegatee($employee)
{
    if($employee->isOnLeave()){
        return $employee;
    }
    return $employee;
}

/**
 * Send the email to the recipient or their delegated staff if they are on leave
 */
function globalSendEmail($recipient, $subject, $mailable)
{
    try {
        //check if the recipient is the employee
        if (!property_exists($recipient, "user_type")) {
            $recipient = User::where("email", $recipient->email)->first();
        }

        //check if the user is on leave
        $recipient = getUsersDelegatee($recipient);

        //check if the recipient is on leave
        ProcessDispatchMails::dispatch($mailable, $recipient)->onQueue('emails');

    } catch(\Throwable $th) {//throw $th;
        Log::error("Global Send Mail overall failed: $subject\nrecipient not found!" . $th->getMessage(), [$th]);
    }
}


if (!function_exists('exchangeCurrency')) {
    function exchangeCurrency($fromCurrency, $type='base', $amount=1)
    {
        $latestExchangeRate = getLatestExchangeRate($fromCurrency);
        
        if ($latestExchangeRate && $type && $amount) {           
            if ($type =='foreign') { 
                if($amount>0||$amount!=''){                    
                    $convertedAmount = $amount / $latestExchangeRate;
                } else{                    
                 $convertedAmount = 0;
                }              
            } else {                
                $convertedAmount = $amount * $latestExchangeRate;
            }
            return $convertedAmount;
        }else{
            return "0";
        }

        // throw new \Exception("Exchange rate not found for $fromCurrency");
    }

    function getLatestExchangeRate($currencyCode)
    {
        // Query the database or fetch exchange rates from an API
        $latestExchangeRate = FmsCurrencyUpdate::where('currency_code',$currencyCode)->latest()->first();
        
        return $latestExchangeRate ? $latestExchangeRate->exchange_rate : 0;
    }
}

if (!function_exists('exchangeCurrencyId')) {
    function exchangeCurrencyId($Currency, $exType='base', $exAmount = 1,)
    {
        $latestExchangeRate = getExchangeRate($Currency);
        
        if ($latestExchangeRate && $exType) {
            if ($exType =='foreign') {                
                $convertedAmount = $exAmount / $latestExchangeRate;
            } else {                
                $convertedAmount = $exAmount * $latestExchangeRate;
            }
            
            return $convertedAmount;
        }else{
            return 0;
        }

        // throw new \Exception("Exchange rate not found for $fromCurrency");
    }

    function getExchangeRate($currency_id)
    {
        // Query the database or fetch exchange rates from an API
        $latestExchangeRate = FmsCurrencyUpdate::where('currency_id',$currency_id)->latest()->first();
        
        return $latestExchangeRate ? $latestExchangeRate->exchange_rate : 0;
    }
}

if (!function_exists('exchangeMoney')) {
    function exchangeMoney($amount = 1, $rate = 1)
    {
        
        if ($rate) {
            $convertedAmount = $amount * $rate;
            return $convertedAmount;
        }

    }

}

// helpers.php

if (!function_exists('calculatePAY')) {
    function calculatePAY($salary)
    {
        // Define the PAYE tax brackets and their corresponding tax rates
        $taxBrackets = [
            ['min' => 0, 'max' => 235000, 'rate' => 0],
            ['min' => 235001, 'max' => 335000, 'rate' => 0.1], // 10%
            ['min' => 335001, 'max' => 410000, 'rate' => 0.2], // 20%
            ['min' => 410001, 'max' => 10000000, 'rate' => 0.3], // 30%
            ['min' => 10000001, 'max' => PHP_INT_MAX, 'rate' => 0.4], // 40% for salaries above 10,000,000
        ];

        // Find the applicable tax bracket for the given salary
        foreach ($taxBrackets as $bracket) {
            if ($salary >= $bracket['min'] && $salary <= $bracket['max']) {
                return $bracket['rate'];
            }
        }

        // Handle the case where no applicable tax bracket is found
        throw new \Exception("No applicable tax bracket found for salary: $salary");
    }
}
if (!function_exists('calculatePAYE')) {
    function calculatePAYE($chargeableIncome) {
        $paye = 0;

        if ($chargeableIncome <= 235000) {
            $paye = 0;
        }elseif ($chargeableIncome > 235000 && $chargeableIncome <= 335000) {
            $paye = ($chargeableIncome - 235000) * 0.10; //10%
        } elseif ($chargeableIncome > 335000 && $chargeableIncome <= 410000) {
            $paye = ($chargeableIncome - 335000) * 0.20 + 10000; //20%
        } elseif ($chargeableIncome > 410000 && $chargeableIncome <= 10000000) {
            $paye = ($chargeableIncome - 410000) * 0.30 + 25000; //30%
        } elseif ($chargeableIncome > 10000000) {
            $paye1 = ($chargeableIncome - 410000) * 0.30 + 25000 ;
            $paye2 = ($chargeableIncome - 10000000) * 0.10;
            $paye = $paye1 + $paye2;
        }

        return $paye;
    }

    
    function generateInitials(string $name)
    {
        $n = Str::of($name)->wordCount();
        $words = explode(' ', $name);

        if (count($words) <= 2) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8').
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        } elseif (count($words) == 3) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8').
                mb_substr($words[1], 0, 1, 'UTF-8').
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        } elseif (count($words) == 4) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8').
                mb_substr($words[1], 0, 1, 'UTF-8').
                mb_substr($words[2], 0, 1, 'UTF-8').
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        } elseif (count($words) == 5) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8').
                mb_substr($words[1], 0, 1, 'UTF-8').
                mb_substr($words[2], 0, 1, 'UTF-8').
                mb_substr($words[3], 0, 1, 'UTF-8').
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        } elseif (count($words) == 6) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8').
                mb_substr($words[1], 0, 1, 'UTF-8').
                mb_substr($words[2], 0, 1, 'UTF-8').
                mb_substr($words[3], 0, 1, 'UTF-8').
                mb_substr($words[4], 0, 1, 'UTF-8').
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        } elseif (count($words) == 7) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8').
                mb_substr($words[1], 0, 1, 'UTF-8').
                mb_substr($words[2], 0, 1, 'UTF-8').
                mb_substr($words[3], 0, 1, 'UTF-8').
                mb_substr($words[4], 0, 1, 'UTF-8').
                mb_substr($words[5], 0, 1, 'UTF-8').
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        } elseif (count($words) == 8) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8').
                mb_substr($words[1], 0, 1, 'UTF-8').
                mb_substr($words[2], 0, 1, 'UTF-8').
                mb_substr($words[3], 0, 1, 'UTF-8').
                mb_substr($words[4], 0, 1, 'UTF-8').
                mb_substr($words[5], 0, 1, 'UTF-8').
                mb_substr($words[6], 0, 1, 'UTF-8').
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        } elseif (count($words) >= 9) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8').
                mb_substr($words[1], 0, 1, 'UTF-8').
                mb_substr($words[2], 0, 1, 'UTF-8').
                mb_substr($words[3], 0, 1, 'UTF-8').
                mb_substr($words[4], 0, 1, 'UTF-8').
                mb_substr($words[5], 0, 1, 'UTF-8').
                mb_substr($words[6], 0, 1, 'UTF-8').
                mb_substr($words[7], 0, 1, 'UTF-8').
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        }

        return makeInitialsFromSingleWord($name);
    }
       /**
     * Make initials from a word with no spaces
     *
     * @return string
     */
    function makeInitialsFromSingleWord(string $name)
    {
        $n = Str::of($name)->wordCount();
        preg_match_all('#([A-Z]+)#', $name, $capitals);
        if (count($capitals[1]) >= $n) {
            return mb_substr(implode('', $capitals[1]), 0, $n, 'UTF-8');
        }

        return mb_strtoupper(mb_substr($name, 0, $n, 'UTF-8'), 'UTF-8');
    }
}


