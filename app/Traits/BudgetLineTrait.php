<?php
namespace App\Traits;

use App\Models\Finance\Budget\FmsBudgetLine;

trait BudgetLineTrait
{
    public function budget_line()
    {
        return $this->belongsTo(FmsBudgetLine::class, 'budget_line_id');
    }
}