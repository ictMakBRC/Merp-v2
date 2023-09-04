<?php

namespace App\Models\Grants\Project;

use App\Models\Grants\GrantProfile;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Grants\Project\ProjectDocument;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory, LogsActivity;

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

    public function employees()
    {
        return $this->belongsToMany(Employee::class,'employee_project','project_id','employee_id')
        ->using(EmployeeProject::class) // Use the pivot model
        ->withPivot(['designation_id', 'contract_summary','start_date','end_date','fte','gross_salary','contract_file_path','status']) // Include the additional attributes
        ->withTimestamps();
    }

    //principal investigator
    public function pi()
    {
        return $this->belongsTo(Employee::class,'pi','id');
    }

    //co principal investigator
    public function coPi()
    {
        return $this->belongsTo(Employee::class,'co_pi','id');
    }

    public function grant()
    {
        return $this->belongsTo(GrantProfile::class,'grant_profile_id','id');
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

    public function documents()
    {
        return $this->hasMany(ProjectDocument::class,'project_id','id');
    }
}
