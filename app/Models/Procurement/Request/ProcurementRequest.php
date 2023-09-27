<?php

namespace App\Models\Procurement\Request;

use App\Services\GeneratorService;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Procurement\Request\ProcurementRequestItem;
use App\Traits\DocumentableTrait;

class ProcurementRequest extends Model
{
    use HasFactory,LogsActivity,DocumentableTrait;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Procurement Requests')
            ->dontLogIfAttributesChangedOnly(['updated_at', 'password'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    protected $guarded = [
        'id',
    ];

    public function requestable()
    {
        return $this->morphTo();
    }


    public function items()
    {
        return $this->hasMany(ProcurementRequestItem::class,'procurement_request_id','id');
    }

    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = auth()->id();
                $model->reference_no = GeneratorService::procurementRequestRef();
            });
        }
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
        : static::query()
            ->where('name', 'like', '%'.$search.'%')
            ->orWhere('email', 'like', '%'.$search.'%')
            ->orWhere('category', 'like', '%'.$search.'%');
    }
}
