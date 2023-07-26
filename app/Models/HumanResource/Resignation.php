<?php

namespace App\Models\HumanResource;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Resignation extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'emp_id', 'department_id',
        'subject', 'hand_over_date', 'letter', 'status', 'comment', 'approved_by', 'created_by', ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function approver()
    {
        return $this->belongsTo(Employee::class, 'approved_by', 'id');
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
