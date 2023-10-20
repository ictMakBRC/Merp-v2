<?php

namespace App\Models\Procurement\Request;

use App\Models\User;
use App\Traits\DocumentableTrait;
use App\Services\GeneratorService;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Procurement\Request\ProcurementRequestItem;
use App\Models\Procurement\Request\ProcurementRequestApproval;
use App\Traits\CurrencyTrait;

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

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function approvalHistory()
    {
        return $this->hasMany(ApprovalHistory::class, 'request_id');
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
