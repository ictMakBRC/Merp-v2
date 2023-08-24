<?php

namespace App\Models\HumanResource\EmployeeData\LeaveRequest;

use App\Models\User;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveRequest extends Model
{
    use HasFactory,LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Leave Requests')
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

    /**
     * Different leave delegations
     */
    public function delegations()
    {
        return $this->hasMany(LeaveDelegation::class);
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

    /**
    * Search the appraisal by department
    */
    public static function search($search)
    {
        return
         static::query();
    }

    /**
     * Delegate the user to take on users roles
     * @param  $delegateeId
     */
    public function delegateAnotherEmployee($delegateeId, $comment = '')
    {
        $this->delegations()->create([
            'delegated_role_to' => $delegateeId,
            'comment' => $comment
        ]);
        return $this;
    }

}
