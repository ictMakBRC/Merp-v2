<?php

namespace App\Models\HumanResource\EmployeeData\Performance\Termination;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Termination extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'emp_id', 'department_id',
        'reason', 'termination_date', 'letter', 'status', 'created_by', ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
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
