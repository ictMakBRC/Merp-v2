<?php

namespace App\Models\Finance\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FmsBudgetAdjustment extends Model
{
    use HasFactory;
    public $fillable = [
        'amount',
        'reason',
        'description',
        'status',
        'comment',
        'from_budget_line_id',
        'to_budget_line_id',  
    ];
}
