<?php

namespace App\Models\HumanResource;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Appraisal extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'emp_id', 'department_id', 'start_date', 'end_date', 'appraisal_file', 'uploaded_by'];

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
