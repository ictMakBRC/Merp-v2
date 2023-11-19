<?php

namespace App\Models\Finance\Payroll;

use Illuminate\Database\Eloquent\Model;
use App\Models\HumanResource\EmployeeData\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsPayrollSchedule extends Model
{
    use HasFactory;
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
