<?php

namespace App\Models\HumanResource\EmployeeData;

use Illuminate\Support\Facades\Auth;
use App\Models\HumanResource\Employee;
use Illuminate\Database\Eloquent\Model;
use App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\Settings\Designation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectContract extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function position()
    {
        return $this->belongsTo(Designation::class, 'position_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Department::class, 'project_id', 'id');
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
