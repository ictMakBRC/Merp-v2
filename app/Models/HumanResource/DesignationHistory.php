<?php

namespace App\Models\HumanResource;

use App\Models\Global\Department;
use App\Models\Global\Station;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignationHistory extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'emp_id', 'department_id', 'from', 'to', 'gross_salary', 'official_contract_id', 'end_date'];

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
