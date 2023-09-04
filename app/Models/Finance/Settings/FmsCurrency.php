<?php

namespace App\Models\Finance\Settings;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsCurrency extends Model
{
        
    use HasFactory,LogsActivity;

    protected $fillable =[

        'name',
        'code',
        'is_active',
        'system_default',
        'exchange_rate',
        'updated_by',
        'created_by'
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Chart Of Accounts Sub types')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
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
            ->where('code', 'like', '%'.$search.'%');
    }
}
