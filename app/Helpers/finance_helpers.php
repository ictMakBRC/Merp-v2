<?php

use App\Models\Finance\Settings\FmsCurrencyUpdate;
use Illuminate\Support\Str;

if (!function_exists('exchangeCurrency')) {
    function exchangeCurrency($fromCurrency, $type = 'base', $amount = 1)
    {
        $latestExchangeRate = getLatestExchangeRate($fromCurrency);

        if ($latestExchangeRate && $type && $amount) {
            if ($type == 'foreign') {
                if ($amount > 0 || $amount != '') {
                    $convertedAmount = $amount / $latestExchangeRate;
                } else {
                    $convertedAmount = 0;
                }
            } else {
                $convertedAmount = $amount * $latestExchangeRate;
            }
            return $convertedAmount;
        } else {
            return "0";
        }

        // throw new \Exception("Exchange rate not found for $fromCurrency");
    }

    function getLatestExchangeRate($currencyCode)
    {
        // Query the database or fetch exchange rates from an API
        $latestExchangeRate = FmsCurrencyUpdate::where('currency_code', $currencyCode)->latest()->first();

        return $latestExchangeRate ? $latestExchangeRate->exchange_rate : 0;
    }
}

if (!function_exists('getEmployeeNssf')) {
    function getEmployeeNssf($amount)
    {
        if (is_numeric($amount)) {
            return 0.05 * $amount;
        } else {
            return 0;
        }
    }
}
if (!function_exists('getEmployeerNssf')) {
    function getEmployeerNssf($amount)
    {
        if (is_numeric($amount)) {
            return 0.1 * $amount;
        } else {
            return 0;
        }
    }
}

if (!function_exists('getCurrencyRate')) {
    function getCurrencyRate($Currency, $exType = 'base', $exAmount = 1, )
    {
        $latestExchangeRate = getExchangeRate($Currency);

        if ($latestExchangeRate && $exType) {
            if ($exType == 'foreign') {
                $convertedAmount = $exAmount / $latestExchangeRate;
            } else {
                $convertedAmount = $exAmount * $latestExchangeRate;
            }

            return $convertedAmount;
        } else {
            return 0;
        }

        // throw new \Exception("Exchange rate not found for $fromCurrency");
    }

    function getExchangeRate($currency_id)
    {
        // Query the database or fetch exchange rates from an API
        $latestExchangeRate = FmsCurrencyUpdate::where('currency_id', $currency_id)->latest()->first();

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

if (!function_exists('getRate')) {
    function getRate($salary)
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
    function calculatePAYE($chargeableIncome)
    {
        $paye = 0;

        if ($chargeableIncome <= 235000) {
            $paye = 0;
        } elseif ($chargeableIncome > 235000 && $chargeableIncome <= 335000) {
            $paye = ($chargeableIncome - 235000) * 0.10; //10%
        } elseif ($chargeableIncome > 335000 && $chargeableIncome <= 410000) {
            $paye = ($chargeableIncome - 335000) * 0.20 + 10000; //20%
        } elseif ($chargeableIncome > 410000 && $chargeableIncome <= 10000000) {
            $paye = ($chargeableIncome - 410000) * 0.30 + 25000; //30%
        } elseif ($chargeableIncome > 10000000) {
            $paye1 = ($chargeableIncome - 410000) * 0.30 + 25000;
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
                mb_substr($words[0], 0, 1, 'UTF-8') .
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        } elseif (count($words) == 3) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8') .
                mb_substr($words[1], 0, 1, 'UTF-8') .
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        } elseif (count($words) == 4) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8') .
                mb_substr($words[1], 0, 1, 'UTF-8') .
                mb_substr($words[2], 0, 1, 'UTF-8') .
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        } elseif (count($words) == 5) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8') .
                mb_substr($words[1], 0, 1, 'UTF-8') .
                mb_substr($words[2], 0, 1, 'UTF-8') .
                mb_substr($words[3], 0, 1, 'UTF-8') .
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        } elseif (count($words) == 6) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8') .
                mb_substr($words[1], 0, 1, 'UTF-8') .
                mb_substr($words[2], 0, 1, 'UTF-8') .
                mb_substr($words[3], 0, 1, 'UTF-8') .
                mb_substr($words[4], 0, 1, 'UTF-8') .
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        } elseif (count($words) == 7) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8') .
                mb_substr($words[1], 0, 1, 'UTF-8') .
                mb_substr($words[2], 0, 1, 'UTF-8') .
                mb_substr($words[3], 0, 1, 'UTF-8') .
                mb_substr($words[4], 0, 1, 'UTF-8') .
                mb_substr($words[5], 0, 1, 'UTF-8') .
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        } elseif (count($words) == 8) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8') .
                mb_substr($words[1], 0, 1, 'UTF-8') .
                mb_substr($words[2], 0, 1, 'UTF-8') .
                mb_substr($words[3], 0, 1, 'UTF-8') .
                mb_substr($words[4], 0, 1, 'UTF-8') .
                mb_substr($words[5], 0, 1, 'UTF-8') .
                mb_substr($words[6], 0, 1, 'UTF-8') .
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        } elseif (count($words) >= 9) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8') .
                mb_substr($words[1], 0, 1, 'UTF-8') .
                mb_substr($words[2], 0, 1, 'UTF-8') .
                mb_substr($words[3], 0, 1, 'UTF-8') .
                mb_substr($words[4], 0, 1, 'UTF-8') .
                mb_substr($words[5], 0, 1, 'UTF-8') .
                mb_substr($words[6], 0, 1, 'UTF-8') .
                mb_substr($words[7], 0, 1, 'UTF-8') .
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

function convertToWords($amount, $currencyCode = 'USD')
{
    $numberToWords = [
        '0' => 'zero',
        '1' => 'one',
        '2' => 'two',
        '3' => 'three',
        '4' => 'four',
        '5' => 'five',
        '6' => 'six',
        '7' => 'seven',
        '8' => 'eight',
        '9' => 'nine',
    ];

    $teenNumbers = [
        '10' => 'ten',
        '11' => 'eleven',
        '12' => 'twelve',
        '13' => 'thirteen',
        '14' => 'fourteen',
        '15' => 'fifteen',
        '16' => 'sixteen',
        '17' => 'seventeen',
        '18' => 'eighteen',
        '19' => 'nineteen',
    ];

    $tensNumbers = [
        '2' => 'twenty',
        '3' => 'thirty',
        '4' => 'forty',
        '5' => 'fifty',
        '6' => 'sixty',
        '7' => 'seventy',
        '8' => 'eighty',
        '9' => 'ninety',
    ];

    $amount = number_format($amount, 2, '.', '');

    list($dollars, $cents) = explode('.', $amount);

    $dollarsInWords = '';
    $centsInWords = '';

    if ($dollars > 0) {
        $dollarsInWords = convertThreeDigitGroupToWords($dollars) . ' ' . getCurrencyName($currencyCode);
    }

    if ($cents > 0) {
        $centsInWords = convertTwoDigitGroupToWords($cents) . ' ' . getCentsWord($cents, $currencyCode);
    }

    $result = trim("$dollarsInWords $centsInWords");

    return ucfirst($result); // Make the first letter uppercase
}

function convertThreeDigitGroupToWords($number)
{
    $hundreds = floor($number / 100);
    $tensAndUnits = $number % 100;

    $result = '';

    if ($hundreds > 0) {
        $result .= $GLOBALS['numberToWords'][$hundreds] . ' hundred';
    }

    if ($tensAndUnits > 0) {
        if ($hundreds > 0) {
            $result .= ' and ';
        }

        if ($tensAndUnits < 10) {
            $result .= $GLOBALS['numberToWords'][$tensAndUnits];
        } elseif ($tensAndUnits < 20) {
            $result .= $GLOBALS['teenNumbers'][$tensAndUnits];
        } else {
            $tens = floor($tensAndUnits / 10);
            $units = $tensAndUnits % 10;

            $result .= $GLOBALS['tensNumbers'][$tens];

            if ($units > 0) {
                $result .= '-' . $GLOBALS['numberToWords'][$units];
            }
        }
    }

    return $result;
}

function convertTwoDigitGroupToWords($number)
{
    if ($number < 10) {
        return $GLOBALS['numberToWords'][$number];
    } elseif ($number < 20) {
        return $GLOBALS['teenNumbers'][$number];
    } else {
        $tens = floor($number / 10);
        $units = $number % 10;

        $result = $GLOBALS['tensNumbers'][$tens];

        if ($units > 0) {
            $result .= '-' . $GLOBALS['numberToWords'][$units];
        }

        return $result;
    }
}

function getCurrencyName($currencyCode)
{
    // Add more currencies as needed
    $currencyNames = [
        'USD' => 'dollars',
        'EUR' => 'euros',
        'GBP' => 'pounds',
        'UGX' => 'shillings',
        // Add more currencies as needed
    ];

    return $currencyNames[$currencyCode] ?? '';
}

function getCentsWord($cents, $currencyCode)
{
    // Customize based on language and currency
    $centsWord = $cents == 1 ? 'cent' : 'cents';

    return $centsWord . ' ' . getCurrencyName($currencyCode);
}
