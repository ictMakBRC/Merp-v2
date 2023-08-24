<?php

namespace App\Models\HumanResource\EmployeeData;

use Carbon\Carbon;
use App\Models\User;
use App\Services\GeneratorService;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
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
        ->withPivot(['designation_id', 'contract_summary','start_date','end_date','fte','gross_salary','contract_file_path','status']) // Include the additional attributes
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
            get: fn () => $this->prefix.' '.$this->surname.' '.$this->first_name.' '.$this->other_name,
        );
    }

    protected function employeeAge(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::createFromFormat('Y-m-d', $this->birth_date)->diffInYears(Carbon::today()),
        );
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
                ->orWhere('first_name', 'like', '%'.$search.'%');
    }

    /**
    * User as an employee
    */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
 * Create a new factory instance for the model.
 */
    protected static function newFactory(): Factory
    {
        return EmployeeFactory::new();
    }
}
