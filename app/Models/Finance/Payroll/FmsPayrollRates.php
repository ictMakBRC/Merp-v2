<?php

namespace App\Models\Finance\Payroll;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Finance\Settings\FmsCurrency;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsPayrollRates extends Model
{
    use HasFactory;
    public function payroll()
    {
        return $this->belongsTo(FmsPayroll::class, 'payroll_id', 'id');
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
}
