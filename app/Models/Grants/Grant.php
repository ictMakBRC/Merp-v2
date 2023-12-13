<?php

namespace App\Models\Grants;

use App\Traits\DocumentableTrait;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use App\Models\Grants\Project\Project;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ProcurementRequestableTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\HumanResource\EmployeeData\Employee;
use App\Traits\CurrencyTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grant extends Model
{
    use HasFactory,LogsActivity, DocumentableTrait, ProcurementRequestableTrait, CurrencyTrait;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Users')
            ->dontLogIfAttributesChangedOnly(['updated_at', 'password'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    //principal investigator
    public function principalInvestigator()
    {
        return $this->belongsTo(Employee::class,'pi','id');
    }

    public function project()
    {
        return $this->hasOne(Project::class,'grant_id','id');
    }
    
    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = auth()->id();
            });
        }
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
        : static::query()
            ->where('grant_code', 'like', '%'.$search.'%')
            ->orWhere('grant_name', 'like', '%'.$search.'%')
            ->orWhere('grant_type', 'like', '%'.$search.'%');
    }

}
