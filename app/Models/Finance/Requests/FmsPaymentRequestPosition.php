<?php

namespace App\Models\Finance\Requests;

use App\Models\User;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsPaymentRequestPosition extends Model
{

     use HasFactory, LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Payment Positions')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to', 'id');
    }

    function user() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    function userUpdated() {
        return $this->belongsTo(User::class, 'updated_by', 'id');
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
            ->where('name', 'like', '%'.$search.'%');
    }

    protected $fillable =[
        'assigned_to',
        'level',
    ];
}
