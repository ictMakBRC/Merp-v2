<?php

namespace App\Models\Finance\Budget;

use App\Models\Finance\Accounting\FmsChartOfAccount;
use App\Models\Finance\Transactions\FmsTransaction;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsBudgetLine extends Model
{
    use HasFactory,LogsActivity;

    public function chartOfAccount()
    {
       return $this->belongsTo(FmsChartOfAccount::class, 'chat_of_account', 'id');
    }

    public function budget()
    {
       return $this->belongsTo(FmsBudget::class, 'fms_budget_id', 'id');
    }
    public function expenses()
    {
        return $this->hasMany(FmsTransaction::class, 'budget_line_id')->where('trx_type', 'Expense');
    }

    public function incomes()
    {
        return $this->hasMany(FmsTransaction::class, 'budget_line_id')->where('trx_type', 'Income');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Budget Lines')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
    protected $fillable = [
        'name',
        'type',
        'fms_budget_id',
        'chat_of_account',
        'allocated_amount',
        'primary_balance',
        'description',
        'amount_held',
        'created_by',  
        'updated_by', 
        'is_active',
        'budget_year',  
        'quantity',   
    ];

      
    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = auth()->id();
            });
            self::updating(function ($model) {
                $model->updated_by = auth()->id();
            });
        }
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
        : static::query()
            ->where('name', 'like', '%'.$search.'%')
            ->where('type', 'like', '%'.$search.'%');
    }

}
