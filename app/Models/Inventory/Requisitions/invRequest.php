<?php

namespace App\Models\inventory\Requisitions;

use App\Models\User;
use App\Models\Department;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class invRequest extends Model
{
    use HasFactory;

    use HasFactory, LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Inventory Requests')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
    
    public function unitable(): MorphTo
    {
        return $this->morphTo();
    }
    public function loantable(): MorphTo
    {
        return $this->morphTo();
    }
    public function requester()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id', 'id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    public function borrower()
    {
        return $this->belongsTo(Department::class, 'borrower_id', 'id');
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
        : static::query()
            ->where('request_code', 'like', '%'.$search.'%')
            ->where('request_type', 'like', '%'.$search.'%');
    }

}
