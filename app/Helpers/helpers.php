<?php

use App\Enums\ProcurementRequestEnum;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Procurement\Settings\ProcurementCategorization;

function getProcurementRequestStatusColor($status)
{
    return ProcurementRequestEnum::color($status);
}

function getProcurementRequestStep($stepOrder)
{
    return ProcurementRequestEnum::step($stepOrder);
}

//PROCUREMENT CATEGORIES
function getProcurementCategorization($amount)
{
    $categorization = ProcurementCategorization::latest()->get();

    if ($categorization->first()) {
        if ($amount <= $categorization->first()->threshold) {
            return $categorization->first();
        } else {
            return $categorization->last();
        }
    }

    return 'Uncategorized'; // Handle cases where the thresholds are not set
}

function isMacroProcurement($amount)
{
    $categorization = ProcurementCategorization::latest()->get();

    if ($amount <= $categorization->first()->threshold) {
        return false;
    } else {
        return true;
    }

    return false; // Handle cases where the thresholds are not set
}

//CURRENCIES
function getCurrencies()
{
    $currencies = FmsCurrency::all();

    return $currencies;
}

function getDefaultCurrency()
{
    $defaultCurrency = FmsCurrency::where('system_default',true)->first();

    return $defaultCurrency;
}

function isDefaultCurrency($currencyId)
{
    $currency = FmsCurrency::findOrFail($currencyId);
    if($currency->system_default){
        return true;
    }else{
        return false;
    }
}
