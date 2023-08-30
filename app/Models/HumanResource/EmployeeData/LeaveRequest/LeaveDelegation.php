<?php

namespace App\Models\HumanResource\EmployeeData\LeaveRequest;

use App\Models\HumanResource\EmployeeData\Employee;
use Illuminate\Database\Eloquent\Model;

class LeaveDelegation extends Model
{
    protected $fillable = ['delegated_role_to', 'leave_request_id', 'comment', 'status'];

    protected $table = 'hr_leave_delegations';


    public function leaveRequest()
    {
        return $this->belongsTo(LeaveRequest::class, 'leave_request_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'delegated_role_to');
    }

    /**
     * Accept the leave delegation
     */
    public function accept($comment = '')
    {
        $this->update([
            'status' => APPROVED,
            'comment' => $comment
        ]);

        return $this;
    }

    /**
     * Decline the leave delegation
     */
    public function decline($comment = '')
    {
        $this->update([
            'status' => DECLINED,
            'comment' => $comment
        ]);
        return $this;

    }



}
