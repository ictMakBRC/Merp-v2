<?php
namespace App\Traits;

use App\Models\Finance\Settings\FmsFinancialYear;

trait FinancialYearTrait
{
    public function financial_year()
    {
        return $this->belongsTo(FmsFinancialYear::class, 'financial_year_id');
    }
}