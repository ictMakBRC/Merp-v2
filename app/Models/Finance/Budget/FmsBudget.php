<?php

namespace App\Models\Finance\Budget;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use App\Models\Grants\Project\Project;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsFinancialYear;
use App\Models\HumanResource\Settings\Department;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsBudget extends Model
{
    use HasFactory,LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Budgeting')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    public function requestable(): MorphTo
    {
        return $this->morphTo();
    }

    public function project()
    {
       return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    
    public function budgetLines()
    {
       return $this->hasMany(FmsBudgetLine::class, 'fms_budget_id', 'id');
    }

    public function department()
    {
       return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    public function currency()
    {
       return $this->belongsTo(FmsCurrency::class, 'currency_id', 'id');
    }

    public function fiscalYear()
    {
       return $this->belongsTo(FmsFinancialYear::class, 'fiscal_year', 'id');
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
            ->where('name', 'like', '%'.$search.'%');
    }

    protected $fillable =[
        'name',           
        'esitmated_income',
        'estimated_expenditure',     
        'fiscal_year',
        'department_id',
        'project_id',
        'account_id',
        'created_by',
        'updated_by',
        'is_active',
        'estimated_income_local',
        'estimated_expense_local',
        'rate'
    ];
}
