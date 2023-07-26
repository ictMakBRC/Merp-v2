<?php

namespace App\Models\HumanResource;

use App\Models\Global\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProjectContract extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'project_id',
        'position_id', 'contract_name', 'gross_salary', 'contract_file', 'start_date', 'end_date', 'fte', 'status', 'created_by', ];

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
