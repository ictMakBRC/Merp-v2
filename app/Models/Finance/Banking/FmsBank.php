<?php

namespace App\Models\Finance\Banking;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Finance\Settings\FmsCurrency;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsBank extends Model
{
    use HasFactory,LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Banks')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
    protected $fillable = [
        'name',
        'coa_id',
        'account_no',
        'current_balance',
        'opening_balance',
        'is_active',
        'currency_id',
        'created_by',
        'updated_by',
        'notice_text',
        'as_of',
    ];
    
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
            ->where('name', 'like', '%'.$search.'%')
            ->orWhere('account_no', 'like', '%'.$search.'%')
            ->orWhereHas('currency', function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
            });
    }
}
