<?php

use App\Enums\ProcurementRequestEnum;
use App\Models\Finance\Budget\FmsBudgetLine;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsFinancialYear;
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
}

function isMacroProcurement($amount)
{
    $categorization = ProcurementCategorization::latest()->get();

    if ($amount <= $categorization->first()->threshold) {
        return false;
    } else {
        return true;
    }
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
}

function procurementMethodApproved($procurementRequestId)
{
    $pro_decision_step=ProcurementRequestDecision::where(['procurement_request_id'=>$procurementRequestId,'step'=>ProcurementRequestEnum::PM_APPROVAL])->first();
    if ($pro_decision_step && $pro_decision_step->decision == ProcurementRequestEnum::APPROVED) {
        return true;
    } 
}

function checkProcurementMethodApproval($procurementRequestId)
{
    $pro_decision=ProcurementRequestDecision::where(['procurement_request_id'=>$procurementRequestId,'step'=>ProcurementRequestEnum::PM_APPROVAL])->get();
    if (count($pro_decision)>0) {
        return true;
    } 
}

function procuremenEvaluationApproved($procurementRequestId)
{
    $pro_decision_step = ProcurementRequestDecision::where(['procurement_request_id'=>$procurementRequestId,'step'=>ProcurementRequestEnum::ER_APPROVAL])->first();
    if ($pro_decision_step && $pro_decision_step->decision == ProcurementRequestEnum::APPROVED) {
        return true;
    } 
}

function checkProcurementEvaluationApproval($procurementRequestId)
{
    $pro_decision=ProcurementRequestDecision::where(['procurement_request_id'=>$procurementRequestId,'step'=>ProcurementRequestEnum::ER_APPROVAL])->get();
    if (count($pro_decision)>0) {
        return true;
    } 
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

function getCurrencyCode($fmsCurrencyId)
{
    return FmsCurrency::where('id',$fmsCurrencyId)->value('code');
}

function exchangeToDefaultCurrency($fmsCurrencyId, $amount = 1)
{
    $fmsCurrency=FmsCurrency::findOrFail($fmsCurrencyId);
    return round($fmsCurrency->exchange_rate * $amount,2);
}

function exchangeToOtherCurrency($fmsCurrencyId, $amount = 1)
{
    $fmsCurrency=FmsCurrency::findOrFail($fmsCurrencyId);
    return round($amount/$fmsCurrency->exchange_rate,2);
}


//BUDGETING HELPERS
function getBudgetLineBalance(FmsBudgetLine $fmsBudgetLine){
    return $fmsBudgetLine->primary_balance;
}

function getFinacialYear(FmsFinancialYear $fmsFinancialYear){
    return $fmsFinancialYear->name;
}
