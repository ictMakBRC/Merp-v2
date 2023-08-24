<?php

namespace App\Models\HumanResource\EmployeeData\LeaveRequest;

use Illuminate\Database\Eloquent\Model;

class LeaveDelegation extends Model
{
    protected $fillable = ['delegated_role_to', 'leave_id'];

    protected $table = 'hr_leave_delegations';

    protected $appends = ['staff'];

    public function leave()
    {
        return $this->belongsTo(LeaveRequest::class);
    }


}
