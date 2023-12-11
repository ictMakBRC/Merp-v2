<?php

namespace App\Models\Finance\Budget;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsUnitBudgetLine extends Model
{
    use HasFactory,LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Unit Budget-lines')
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


    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
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
            ->where('type', 'like', '%'.$search.'%');
    }

    protected $fillable =[
        'name',            
        'type',            
        'created_by',
        'updated_by',
        'is_active',
        'department_id',
        'project_id',
        'account_id',
    ];
}
