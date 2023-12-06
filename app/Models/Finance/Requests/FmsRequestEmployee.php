<?php

namespace App\Models\Finance\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\HumanResource\EmployeeData\Employee;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsRequestEmployee extends Model
{
    use HasFactory;
    public function requestable(): MorphTo
    {
        return $this->morphTo();
    }
    public function contractable(): MorphTo
    {
        return $this->morphTo();
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
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
            return empty($search) ? static::query()
            : static::query()
                ->where('employee_id', 'like', '%'.$search.'%')
                ->where('year', 'like', '%'.$search.'%')
                ->where('month', 'like', '%'.$search.'%');
        }
    
        protected $fillable =[
            'employee_id',   
            'created_by',   
            'updated_by',      
            'status',
            'payroll_id',
            'paye_rate',
            'worker_nssf_rate',
            'emp_nssf_rate',
            'deductions',
            'bonuses',
            'net_salary', 
            'schedule_id',
        ];
    
}
