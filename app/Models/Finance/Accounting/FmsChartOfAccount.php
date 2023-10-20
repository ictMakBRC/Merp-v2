<?php

namespace App\Models\Finance\Accounting;

use App\Models\Finance\Settings\FmsChartOfAccountsSubType;
use App\Models\Finance\Settings\FmsChartOfAccountsType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class FmsChartOfAccount extends Model
{
    use HasFactory,LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Chart Of Accounts')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    protected $fillable = [
        'name',
        'code',
        'account_type',
        'sub_account_type',
        'is_active',
        'description',
        'created_by',
        'parent_account',
        'primary_balance',
        'bank_balance',
        'as_of',
    ];

    public function type()
    {
        return $this->belongsTo(FmsChartOfAccountsType::class, 'account_type', 'id');
    }

    public function subType()
    {
        return $this->belongsTo(FmsChartOfAccountsSubType::class, 'sub_account_type', 'id');
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
            ->where('name', 'like', '%'.$search.'%')
            ->orWhere('code', 'like', '%'.$search.'%')
            ->orWhereHas('type', function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
            })
            ->orWhereHas('subType', function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
            });
    }
}
