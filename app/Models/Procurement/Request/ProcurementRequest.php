<?php

namespace App\Models\Procurement\Request;

use App\Models\User;
use App\Traits\CurrencyTrait;
use App\Traits\DocumentableTrait;
use App\Services\GeneratorService;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Procurement\Settings\Provider;
use App\Models\HumanResource\Settings\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Procurement\Request\ProcurementRequestItem;
use App\Models\Procurement\Request\ProcurementRequestApproval;
use App\Models\Procurement\Request\ProcurementRequestDecision;

class ProcurementRequest extends Model
{
    use HasFactory,LogsActivity,DocumentableTrait,CurrencyTrait;

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

    public function requester()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function approvals()
    {
        return $this->hasMany(ProcurementRequestApproval::class, 'procurement_request_id');
    }

    public function decisions()
    {
        return $this->hasMany(ProcurementRequestDecision::class, 'procurement_request_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function providers()
    {
        return $this->belongsToMany(Provider::class,'selected_providers','procurement_request_id','provider_id')
        ->withTimestamps();
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
            ->where('reference_no', 'like', '%'.$search.'%')
            ->orWhere('request_type', 'like', '%'.$search.'%')
            ->orWhere('subject', 'like', '%'.$search.'%')
            ->orWhere('procurement_sector', 'like', '%'.$search.'%')
            ->orWhere('status', 'like', '%'.$search.'%')
            
            ;
    }
}
