<?php

namespace App\Models\Finance\Settings;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsFinancialYear extends Model
{
    use HasFactory,LogsActivity;

    protected $fillable =[

        'name',
        'start_date',
        'is_active',
        'end_date',
        'is_budget_year',
        'created_by'
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Financial Years')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
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
            ->where('name', 'like', '%'.$search.'%')
            ->where('end_date', 'like', '%'.$search.'%')
            ->where('start_date', 'like', '%'.$search.'%');
    }
}
