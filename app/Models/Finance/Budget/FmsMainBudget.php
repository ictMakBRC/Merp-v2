<?php

namespace App\Models\Finance\Budget;

use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsFinancialYear;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class FmsMainBudget extends Model
{
    use HasFactory;
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Budget')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    public function currency()
    {
        return $this->belongsTo(FmsCurrency::class, 'currency_id', 'id');
    }

    public function fiscalYear()
    {
        return $this->belongsTo(FmsFinancialYear::class, 'fiscal_year', 'id');
    }

    public function budgets()
    {
        return $this->hasMany(FmsBudget::class, 'fiscal_year', 'fiscal_year');
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
        return empty($search)?static::query()
        : static::query()
            ->where('name', 'like', '%' . $search . '%');
    }

    protected $fillable = [
        'name',
        'estimated_income',
        'estimated_expenditure',
        'fiscal_year',
        'created_by',
        'updated_by',
        'is_active',
        'rate',
    ];
}
