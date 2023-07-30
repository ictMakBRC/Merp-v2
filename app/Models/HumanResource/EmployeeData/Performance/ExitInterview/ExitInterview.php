<?php

namespace App\Models\HumanResource\EmployeeData\Performance\ExitInterview;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ExitInterview extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'emp_id', 'department_id', 'interview_file', 'uploaded_by'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->uploaded_by = auth()->id();
            });
        }
    }
}
