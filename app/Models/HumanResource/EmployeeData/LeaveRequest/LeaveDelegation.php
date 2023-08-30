<?php

namespace App\Models\HumanResource\EmployeeData\LeaveRequest;

use App\Models\HumanResource\EmployeeData\Employee;
use Illuminate\Database\Eloquent\Model;

class LeaveDelegation extends Model
{
    protected $fillable = ['delegated_role_to', 'leave_type_id', 'comment'];

    protected $table = 'hr_leave_delegations';


    public function leaveLequest()
    {
        return $this->belongsTo(LeaveRequest::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'delegated_role_to');
    }


}
