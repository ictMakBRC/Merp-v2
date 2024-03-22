<?php

namespace App\Models\Finance\Payroll;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Finance\Payroll\FmsPayroll;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Requests\FmsRequestEmployee;
use App\Models\HumanResource\EmployeeData\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsPayrollSchedule extends Model
{
    use HasFactory;
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
    public function employeeRequest()
    {
        return $this->hasMany(FmsRequestEmployee::class, 'schedule_id', 'id');
    }

    public function payroll()
    {
        return $this->belongsTo(FmsPayroll::class, 'fms_payroll_id', 'id');
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

    protected $fillable =[
        'payment_voucher',
        'employee_id',
        'fms_payroll_id',
        'currency_id',
        'rate',
        'salary',
        'base_salary',
        'paye',
        'worker_nssf',
        'emp_nssf',
        'deductions',
        'bonuses',
        'net_salary',
        'request_id',
        'status',         
        'created_by',  
        'updated_by', 
    ];
}
