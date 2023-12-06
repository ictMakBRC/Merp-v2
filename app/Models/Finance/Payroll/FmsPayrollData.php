<?php

namespace App\Models\Finance\Payroll;

use App\Models\Finance\Requests\FmsRequestEmployee;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\HumanResource\EmployeeData\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class FmsPayrollData extends Model
{
    use HasFactory;
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
    public function employeeRequest()
    {
        return $this->hasMany(FmsRequestEmployee::class, 'payroll_id', 'id');
    }
    public function currency()
    {
        return $this->belongsTo(FmsCurrency::class, 'currency_id', 'id');
    }
    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = auth()->id();
            });
            self::updating(function ($model) {
                $model->updated_by = auth()->id();
            });
        }
    }

    public static function search($search)
    {
        return empty($search)?static::query()
        : static::query()
            ->where('employee_id', 'like', '%' . $search . '%')
            ->where('year', 'like', '%' . $search . '%')
            ->where('month', 'like', '%' . $search . '%');
    }

    protected $fillable = [
        'employee_id',
        'created_by',
        'updated_by',
        'status',
        'fms_payroll_id',
        'month',
        'year',
        'currency_id',
        'employee_id',
        'salary',
        'base_salary',
        'deductions',
        'employee_nssf',
        'employer_nssf',
        'other_deductions',
        'deduction_description',
        'net_salary',
        'request_id',
    ];
}
