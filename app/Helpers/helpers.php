<?php

use Illuminate\Support\Collection;
use App\Enums\ProcurementRequestEnum;
use App\Models\Grants\Project\Project;
use App\Models\Global\FacilityInformation;
use App\Models\Finance\Budget\FmsBudgetLine;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsFinancialYear;
use App\Models\Procurement\Request\ProcurementRequest;
use App\Models\Procurement\Request\ProcurementRequestDecision;
use App\Models\Procurement\Settings\ProcurementCategorization;

function organizationInfo(){
    return FacilityInformation::first();
}
//PROCUREMENT HELPERS
function getProcurementRequestStatusColor($status)
{
    return ProcurementRequestEnum::color($status);
}

function getProcurementRequestStep($stepOrder)
{
    return ProcurementRequestEnum::step($stepOrder);
}

function getRatingColor($rating)
{
    return ProcurementRequestEnum::ratingColor(intval(round($rating)));
}

function getQualityRatingText($rating)
{
    return ProcurementRequestEnum::qualityRating(intval(round($rating)));
}

function getCostRatingText($rating)
{
    return ProcurementRequestEnum::costRating(intval(round($rating)));
}

function getTimelinessRatingText($rating)
{
    return ProcurementRequestEnum::timelinessRating(intval(round($rating)));
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

function procurementEvaluationApproved($procurementRequestId)
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

function checkBidderPricesAttached($procurementRequestId)
{
    $items = ProcurementRequest::with('items')->findOrFail($procurementRequestId)->items()->where('bidder_unit_cost', null);
    if ($items->isEmpty()) {
        return true;
    } 
}

function getItemsTotalCost($procurementRequestId)
{
    $items_cost = ProcurementRequest::with('items')->findOrFail($procurementRequestId)->items()->sum('bidder_total_cost');
    return $items_cost ;
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

function exchangeRate($fmsCurrencyId)
{
    return FmsCurrency::findOrFail($fmsCurrencyId)->exchange_rate;
}


//BUDGETING HELPERS
function getBudgetLineBalance($fmsBudgetLineId){
    return FmsBudgetLine::findOrFail($fmsBudgetLineId)->primary_balance;
}

function getLedger($ledgerable_type,$ledgerable_id){
    if ($ledgerable_type=='Project') {
        return Project::findOrFail($ledgerable_id)->ledger;
    }else{
        return auth()->user()->employee->department->ledger;
    }
}

function getFinacialYear(FmsFinancialYear $fmsFinancialYear){
    return $fmsFinancialYear->name;
}

function calculatePercentage($total, $subset, $precision = 2)
{
    if ($total == 0) {
        return 0.0; // To avoid division by zero
    }

    $percentage = ($subset / $total) * 100;

    return round($percentage, $precision);
}

function generateQuote()
{
    return Collection::make(Config::get('quotes.quotes'))->map(fn ($quot) => $quot)->random();
}

function removeSymbolsAndTransform($inputString)
{
    // Convert the string to uppercase
    $uppercaseString = strtoupper($inputString);

    // Define an array of symbols you want to remove
    $symbols = ['-', '(', ')', '/', '_',' '];

    // Use str_replace to remove the specified symbols
    $cleanString = str_replace($symbols, '', $uppercaseString);

    return $cleanString;
}
