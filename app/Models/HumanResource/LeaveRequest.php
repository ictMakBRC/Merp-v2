<?php

namespace App\Models\HumanResource;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'emp_id', 'department_id', 'leave_id', 'start_date', 'end_date', 'length', 'reason', 'delegated_to', 'delegatee_status', 'duties_delegated', 'comment', 'delegatee_comment', 'approved_by', 'created_by'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function leave()
    {
        return $this->belongsTo(Leave::class, 'leave_id', 'id');
    }

    public function approver()
    {
        return $this->belongsTo(Employee::class, 'approved_by', 'id');
    }

    public function acceptedby()
    {
        return $this->belongsTo(Employee::class, 'accepted_by', 'id');
    }

    public function delegatedto()
    {
        return $this->belongsTo(Employee::class, 'delegated_to', 'id');
    }

    public function scopeLeaveRequestCheck($query)
    {
        $query->where('employee_id', Auth::user()->employee->id)->where('end_date', '>', date('Y-m-d'))->orWhere('status', 'Pending');
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
}
