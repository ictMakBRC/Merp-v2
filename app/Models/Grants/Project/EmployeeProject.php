<?php

namespace App\Models\Grants\Project;


use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\HumanResource\Settings\Designation;
use App\Models\HumanResource\EmployeeData\Employee;

class EmployeeProject extends Pivot
{
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
