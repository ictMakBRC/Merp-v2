<?php

namespace App\Models\Inventory\Requests;

use App\Models\User;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvUnitRequest extends Model
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

    public function unitable(): MorphTo
    {
        return $this->morphTo();
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

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
        : static::query()
            ->where('request_code', 'like', '%'.$search.'%');
    }

    protected $fillable =[
        'name',           
        'estimated_income',
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
