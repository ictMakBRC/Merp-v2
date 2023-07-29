<?php

namespace App\Models\HumanResource;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Leave extends Model
{
    use HasFactory,LogsActivity,CausesActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Desginations')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    protected $fillable = ['name', 'duration', 'carriable', 'is_payable', 'payment_type', 'given_to', 'notice_days', 'details', 'status'];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()           
                ->where('name', 'like', '%'.$search.'%')
                ->orWhere('payment_type', 'like', '%'.$search.'%');               
    }
}
