<?php

namespace App\Models\Grants\Project;

use App\Models\Grants\Grant;
use App\Traits\DocumentableTrait;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ProcurementRequestableTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\EmployeeData\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory, LogsActivity, DocumentableTrait, ProcurementRequestableTrait;

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

    public function departments()
    {
        return $this->belongsToMany(Department::class,'department_project','project_id','department_id')
        ->withTimestamps();
    }

    //principal investigator
    public function principalInvestigator()
    {
        return $this->belongsTo(Employee::class,'pi','id');
    }

    //co principal investigator
    public function coInvestigator()
    {
        return $this->belongsTo(Employee::class,'co_pi','id');
    }

    public function grant()
    {
        return $this->belongsTo(Grant::class,'grant_profile_id','id');
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
            ->where('project_code', 'like', '%'.$search.'%')
            ->orWhere('project_category', 'like', '%'.$search.'%')
            ->orWhere('project_type', 'like', '%'.$search.'%');
    }
}
