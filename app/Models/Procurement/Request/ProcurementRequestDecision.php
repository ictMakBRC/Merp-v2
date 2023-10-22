<?php

namespace App\Models\Procurement\Request;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Procurement\Request\ProcurementRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProcurementRequestDecision extends Model
{
    use HasFactory,LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Procurement Request Decisions')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    protected $guarded = [
        'id',
    ];

    public function procurement_requests()
    {
        return $this->belongsTo(ProcurementRequest::class, 'procurement_request_id');
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
        : static::query()
            ->where('decision_maker', 'like', '%'.$search.'%')
            ->orWhere('decision', 'like', '%'.$search.'%')
            ->orWhere('step', 'like', '%'.$search.'%');
    }
}
