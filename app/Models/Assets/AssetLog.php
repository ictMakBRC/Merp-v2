<?php

namespace App\Models\Assets;

use App\Models\HumanResource\EmployeeData\Employee;
use App\Models\HumanResource\Settings\Station;
use App\Traits\CurrencyTrait;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetLog extends Model
{
    use HasFactory,LogsActivity, CurrencyTrait;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Assets Logs')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    protected $guarded =['id'];
    
    public function loggable()
    {
        return $this->morphTo();
    }

    public function station()
    {
        return $this->belongsTo(Station::class, 'station_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function breakdown()
    {
        return $this->belongsTo(AssetLog::class, 'breakdown_id');
    }

    // public function assets_logs()
    // {
    //     return $this->hasMany(AssetLog::class, 'parent_id');
    // }
    
    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = auth()->id();
            });
        }
    }
}
