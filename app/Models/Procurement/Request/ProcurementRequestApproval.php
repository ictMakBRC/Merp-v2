<?php

namespace App\Models\Procurement\Request;

use App\Models\User;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Procurement\Request\ProcurementRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProcurementRequestApproval extends Model
{
    use HasFactory,LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Procurement Request Approval')
            ->dontLogIfAttributesChangedOnly(['updated_at', 'password'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    protected $guarded = ['id'];

    public function procurement_request()
    {
        return $this->belongsTo(ProcurementRequest::class, 'procurement_request_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            // self::creating(function ($model) {
            //     $model->created_by = auth()->id();
            // });

            self::updating(function ($model) {
                $model->approver_id = auth()->id();
            });
        }
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
        : static::query()
            ->where('step', 'like', '%'.$search.'%');
    }
}
