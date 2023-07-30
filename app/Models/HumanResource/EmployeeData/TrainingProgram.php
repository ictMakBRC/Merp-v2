<?php

namespace App\Models\HumanResource\EmployeeData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TrainingProgram extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'start_date', 'end_date', 'organised_by',
        'training_name', 'training_length', 'training_description', 'certificate', 'created_by', ];

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
