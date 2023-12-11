<?php

namespace App\Models\Grants\Project;

use App\Models\Finance\Accounting\FmsLedgerAccount;
use App\Models\Grants\Grant;
use App\Models\HumanResource\EmployeeData\Employee;
use App\Models\HumanResource\Settings\Department;
use App\Traits\CurrencyTrait;
use App\Traits\DocumentableTrait;
use App\Traits\ProcurementRequestableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Project extends Model
{
    use HasFactory, LogsActivity, DocumentableTrait, ProcurementRequestableTrait, CurrencyTrait;

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

    // public function requests(): MorphMany
    // {
    //     return $this->morphMany(Request::class, 'requestable');
    // }

    public function ledger()
    {
        return $this->HasOne(FmsLedgerAccount::class, 'project_id', 'id');
    }
    
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_project', 'project_id', 'employee_id')
            ->using(EmployeeProject::class) // Use the pivot model
            ->withPivot(['designation_id', 'contract_summary', 'start_date', 'end_date', 'fte', 'gross_salary', 'contract_file_path', 'status']) // Include the additional attributes
            ->withTimestamps();
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_project', 'project_id', 'department_id')
            ->withTimestamps();
    }

    //principal investigator
    public function principalInvestigator()
    {
        return $this->belongsTo(Employee::class, 'pi', 'id');
    }

    //co principal investigator
    public function coInvestigator()
    {
        return $this->belongsTo(Employee::class, 'co_pi', 'id');
    }

    public function grant()
    {
        return $this->belongsTo(Grant::class, 'grant_profile_id', 'id');
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
        return empty($search)?static::query()
        : static::query()
            ->where('project_code', 'like', '%' . $search . '%')
            ->orWhere('project_category', 'like', '%' . $search . '%')
            ->orWhere('project_type', 'like', '%' . $search . '%');
    }
}
