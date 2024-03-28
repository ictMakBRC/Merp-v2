<?php

namespace App\Models\HumanResource\EmployeeData;

use App\Models\Finance\Settings\FmsFinanceInstitutions;
use App\Traits\CurrencyTrait;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankingInformation extends Model
{
    use HasFactory,LogsActivity,CurrencyTrait;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Banking Information')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    public $table = 'banking_information';

    protected $guarded = ['id'];

    public function bank()
    {
        return $this->belongsTo(FmsFinanceInstitutions::class, 'bank_id');
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
