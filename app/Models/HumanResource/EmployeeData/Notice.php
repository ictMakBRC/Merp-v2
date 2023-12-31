<?php

namespace App\Models\HumanResource\EmployeeData;

use Illuminate\Support\Facades\Auth;
use App\Models\HumanResource\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'created_by', 'id');
    }

    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = Auth::user()->employee->id;
            });
        }
    }
}
