<?php

namespace App\Models\HumanResource\EmployeeData\OfficialContract;

use App\Models\Finance\Settings\FmsCurrency;
use Carbon\Carbon;
use App\Models\Global\Department;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\HumanResource\EmployeeData\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfficialContract extends Model
{
    use HasFactory,LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Official Contracts')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    public function currency()
    {
        return $this->belongsTo(FmsCurrency::class, 'currency', 'code');
    }

    public function currencyUpdates()
    {
        return $this->currency->currencyUpdates();
    }

    public function calculateGrossAmountUGX($code)
    {
        // Use the latest currency update to convert gross amount to UGX
        $latestCurrencyUpdate = $this->currencyUpdates()->where('currency_code',$code)->latest()->first();
        $grossAmountUGX = $this->gross_amount * $latestCurrencyUpdate->exchange_rate??0;
        return $grossAmountUGX;
    }

    protected $guarded = ['id'];

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
    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
                ->where('contract_summary', 'like', '%'.$search.'%');
    }
    public static function searchMyContract($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('employee_id',auth()->user()->employee_id)
                ->where('contract_summary', 'like', '%'.$search.'%');
    }
}
