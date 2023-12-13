<?php

namespace App\Models\Finance\Payroll;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Finance\Settings\FmsCurrency;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsPayroll extends Model
{
    use HasFactory;
    use HasFactory, LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Payroll Requests')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
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
            ->where('payment_voucher', 'like', '%'.$search.'%')
            ->where('year', 'like', '%'.$search.'%')
            ->where('month', 'like', '%'.$search.'%');
    }

    protected $fillable =[
        'created_by',   
        'updated_by',             
        'payment_voucher',
        'status',
    ];
}
