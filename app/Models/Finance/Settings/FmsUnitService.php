<?php

namespace App\Models\Finance\Settings;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsUnitService extends Model
{
    use HasFactory,LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Unit Services')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
    protected $fillable = [
        'service_id',
        'created_by',
        'updated_by',
        'is_active',
    ];

    function service() {
     return $this->belongsTo(FmsService::class, 'service_id', 'id');
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
            ->where('is_active', 'like', '%'.$search.'%')
            ->orWhereHas('service', function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                ->orWhere('sku','like', '%'.$search.'%');
            });
    }


    public function unitable(): MorphTo
    {
        return $this->morphTo();
    }
}
