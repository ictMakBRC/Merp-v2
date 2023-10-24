<?php

use App\Enums\ProcurementRequestEnum;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Procurement\Request\ProcurementRequestDecision;
use App\Models\Procurement\Settings\ProcurementCategorization;


//PROCUREMENT HELPERS
function getProcurementRequestStatusColor($status)
{
    return ProcurementRequestEnum::color($status);
}

function getProcurementRequestStep($stepOrder)
{
    return ProcurementRequestEnum::step($stepOrder);
}

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

    // return 'Uncategorized'; // Handle cases where the thresholds are not set
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

function requiresProcurementContract($amount)
{
    $categorization = ProcurementCategorization::latest()->get();

    if ($amount <= $categorization->first()->threshold) {
        return false;
    } 

    if ($amount>=$categorization->first()->contract_requirement_threshold) {
        return true;
    } 
    
    return false;
}

function isProcurementMethodApproved($procurementRequestId)
{
    $pro_decision_step=ProcurementRequestDecision::where(['procurement_request_id'=>$procurementRequestId,'step'=>ProcurementRequestEnum::PM_APPROVAL])->first();
    if ($pro_decision_step && $pro_decision_step->decision == ProcurementRequestEnum::APPROVED) {
        
        return true;
    } 
    return false;
}

function isProcurementEvaluationApproved($procurementRequestId)
{
    $pro_decision_step = ProcurementRequestDecision::where(['procurement_request_id'=>$procurementRequestId,'step'=>ProcurementRequestEnum::ER_APPROVAL])->first();
    if ($pro_decision_step && $pro_decision_step->decision == ProcurementRequestEnum::APPROVED) {
        return true;
    } 
    return false;
}

//CURRENCY HELPERS
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
