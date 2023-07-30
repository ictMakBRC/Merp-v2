<?php

namespace App\Models\HumanResource\EmployeeData;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use App\Models\HumanResource\Employee;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\HumanResource\Settings\Station;
use App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\Settings\Designation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\HumanResource\EmployeeData\OfficialContract\OfficialContract;

class DesignationHistory extends Model
{
    use HasFactory,LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Designation History')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    protected $guarded = ['id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function station()
    {
        return $this->belongsTo(Station::class, 'station_id', 'id');
    }

    public function reports_to()
    {
        return $this->belongsTo(Employee::class, 'supervisor', 'id');
    }

    public function contract()
    {
        return $this->belongsTo(OfficialContract::class, 'official_contract_id', 'id');
    }

    public function position_one()
    {
        return $this->belongsTo(Designation::class, 'from', 'id');
    }

    public function position_two()
    {
        return $this->belongsTo(Designation::class, 'to', 'id');
    }

}
