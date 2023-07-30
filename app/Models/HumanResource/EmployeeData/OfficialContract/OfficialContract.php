<?php

namespace App\Models\HumanResource\EmployeeData\OfficialContract;

use App\Models\Global\Department;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OfficialContract extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'department_id', 'contract_name', 'start_date', 'end_date', 'gross_salary', 'contract_file', 'status', 'created_by'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function scopeContractOwner($query)
    {
        $next_date = Carbon::today()->addDays(30)->format('Y-m-d');
        $query->addSelect(['emp_id' => Employee::select('emp_id')->whereColumn('employee_id', 'employees.id'),
            'surname' => Employee::select('surname')->whereColumn('employee_id', 'employees.id'),
            'other_name' => Employee::select('other_name')->whereColumn('employee_id', 'employees.id'),
            'first_name' => Employee::select('first_name')->whereColumn('employee_id', 'employees.id'),
            'prefix' => Employee::select('prefix')->whereColumn('employee_id', 'employees.id'),
            'department_name' => Department::select('department_name')->whereColumn('department_id', 'departments.id'),
            DB::raw('DATEDIFF(end_date,CURRENT_DATE()) as days_to_expire'),
        ])->where('status', 'Running')->whereBetween('end_date', [Carbon::today()->subDays(1), $next_date])->orderBy('end_date', 'Asc');
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
