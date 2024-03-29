<?php

namespace App\Models\Finance\Transactions;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use App\Models\Grants\Project\Project;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsCustomer;
use App\Models\HumanResource\Settings\Department;
use App\Models\Finance\Accounting\FmsLedgerAccount;
use App\Models\Finance\Budget\FmsBudgetLine;
use App\Models\Finance\Budget\FmsUnitBudgetLine;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsTransaction extends Model
{
    use HasFactory,LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Transactions')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
    public function requestable(): MorphTo
    {
        return $this->morphTo();
    }
    public function budgetLine()
    {
        return $this->belongsTo(FmsBudgetLine::class, 'budget_line_id', 'id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }


    public function fromAccount()
    {
        return $this->belongsTo(FmsLedgerAccount::class, 'ledger_account', 'id');
    }

    public function toAccount()
    {
        return $this->belongsTo(FmsLedgerAccount::class, 'to_account', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(FmsCustomer::class, 'customer_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    public function currency()
    {
        return $this->belongsTo(FmsCurrency::class, 'currency_id', 'id');
    }
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
            ->where('trx_ref', 'like', '%'.$search.'%')
            ->where('trx_no', 'like', '%'.$search.'%');
    }

    protected $fillable =[
        'trx_no',
        'trx_ref',
        'trx_date',
        'total_amount',
        'amount_local',
        'rate',
        'rate_to',
        'department_id',    
        'project_id',
        'billed_department',    
        'billed_project',
        'customer_id',
        'currency_id',
        'budget_line_id',
        'ledger_account',
        'to_account',
        'trx_type',
        'entry_type',
        'status',
        'description',           
        'created_by',
        'updated_by',
        'is_active',
        'is_department',
        'line_balance', 
        'line_amount', 
        'account_amount', 
        'account_balance', 
    ];
}
