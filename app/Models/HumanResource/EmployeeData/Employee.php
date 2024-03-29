<?php

namespace App\Models\HumanResource\EmployeeData;

use App\Models\HumanResource\EmployeeData\LeaveRequest\LeaveDelegation;
use Carbon\Carbon;
use App\Models\User;
use App\Services\GeneratorService;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use App\Models\Grants\Project\Project;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Grants\Project\EmployeeProject;
use App\Models\HumanResource\EmployeeData\OfficialContract\OfficialContract;
use App\Models\HumanResource\Settings\Station;
use App\Models\HumanResource\Settings\Department;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\HumanResource\Settings\Designation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\HumanResource\EmployeeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory,LogsActivity;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Employees')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function station()
    {
        return $this->belongsTo(Station::class, 'station_id', 'id');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'employee_project', 'employee_id', 'project_id')
        ->using(EmployeeProject::class) // Use the pivot model
        ->withPivot(['id','designation_id', 'contract_summary','start_date','end_date','fte','gross_salary','contract_file_path','status']) // Include the additional attributes
        ->withTimestamps();
    }

    //principal investigator
    public function projectPi()
    {
        return $this->hasMany(Project::class, 'pi', 'id');
    }

    //co principal investigator
    public function projectCoPi()
    {
        return $this->hasMany(Project::class, 'co_pi', 'id');
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->first_name.' '.$this->other_name.' '.$this->surname,
        );
    }
    protected function titledName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->title.' '.$this->first_name.' '.$this->other_name.' '.$this->surname,
        );
    }
    
     protected function flatName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->first_name.' '.$this->other_name.' '.$this->surname,
        );
    }

    protected function empName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->first_name.' '.$this->other_name.' '.$this->surname,
        );
    }

    protected function employeeAge(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->birth_date? Carbon::createFromFormat('Y-m-d', $this->birth_date)->diffInYears(Carbon::today()):1,
        );
    }

    public function officialContracts()
    {
        return $this->hasMany(OfficialContract::class, 'employee_id', 'id');
    }

    public function officialContract()
    {
        return $this->hasOne(OfficialContract::class, 'employee_id', 'id')->where('status',1);
    }

    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = auth()->id();
                $model->age = Carbon::createFromFormat('Y-m-d', $model->birth_date)->diffInYears(Carbon::today());
                $model->employee_number = GeneratorService::employeeNo();
            });

            self::updating(function ($model) {
                $model->age = Carbon::createFromFormat('Y-m-d', $model->birth_date)->diffInYears(Carbon::today());
            });
        }
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
                ->where('surname', 'like', '%'.$search.'%')
                ->orWhere('first_name', 'like', '%'.$search.'%')
                ->orWhere('other_name', 'like', '%'.$search.'%')
                ->orWhere('entry_type', 'like', '%'.$search.'%')
                ->orWhere('employee_number', 'like', '%'.$search.'%')
                ->orWhere('nin_number', 'like', '%'.$search.'%')
                ->orWhere('title', 'like', '%'.$search.'%')
                ->orWhere('nationality', 'like', '%'.$search.'%')
                ->orWhere('gender', 'like', '%'.$search.'%')
                ->orWhere('birth_place', 'like', '%'.$search.'%')
                ->orWhere('religious_affiliation', 'like', '%'.$search.'%')
                ->orWhere('blood_type', 'like', '%'.$search.'%')
                ->orWhere('civil_status', 'like', '%'.$search.'%')
                ->orWhere('address', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('contact', 'like', '%'.$search.'%')
                ->orWhere('alt_email', 'like', '%'.$search.'%')
                ->orWhere('alt_contact', 'like', '%'.$search.'%')
                ->orWhere('work_type', 'like', '%'.$search.'%')
                ->orWhere('tin_number', 'like', '%'.$search.'%')
                ->orWhere('nssf_number', 'like', '%'.$search.'%');
    }

    /**
    * User as an employee
    */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
    * User as an employee
    */
    public function supervisor()
    {
        return $this->hasOne(Employee::class, 'reporting_to');
    }

    /**
     * Check if the employee is on leave or not
     */
    public function isOnLeave()
    {
        if($this->leaves->where('status', 'approved')->first()) {
            return true;
        }
        return false;
    }

    /**
    * Employee delegations
    */
    public function delegations()
    {
        return $this->hasMany(LeaveDelegation::class, 'delegated_role_to');
    }

    /**
 * Create a new factory instance for the model.
 */
    protected static function newFactory(): Factory
    {
        return EmployeeFactory::new();
    }
}
