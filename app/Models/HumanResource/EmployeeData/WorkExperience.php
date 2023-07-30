<?php

namespace App\Models\HumanResource\EmployeeData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WorkExperience extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'start_date', 'end_date', 'company',
        'position_held', 'employment_type', 'monthly_salary', 'service_length', 'job_description', 'created_by', ];

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
