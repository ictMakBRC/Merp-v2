<?php

namespace App\Models\Finance\Invoice;

use App\Models\Comment;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use App\Models\Grants\Project\Project;
use App\Models\Finance\Banking\FmsBank;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsCustomer;
use App\Models\HumanResource\Settings\Department;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsInvoice extends Model implements HasMedia
{
    use HasFactory, LogsActivity;
    
    use InteractsWithMedia;

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Invoice')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
    public function requestable(): MorphTo
    {
        return $this->morphTo();
    }
    public function billtable(): MorphTo
    {
        return $this->morphTo();
    }
    public function payments()
    {
        return $this->hasMany(FmsInvoicePayment::class, 'invoice_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    public function bank()
    {
        return $this->belongsTo(FmsBank::class, 'bank_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(FmsCustomer::class, 'customer_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    public function currency()
    {
        return $this->belongsTo(FmsCurrency::class, 'currency_id', 'id');
    }

    public function billedDepartment()
    {
        return $this->belongsTo(Department::class, 'billed_department', 'id');
    }

    public function billedProject()
    {
        return $this->belongsTo(Department::class, 'billed_project', 'id');
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
        return empty($search)?static::query()
        : static::query()
            ->where('invoice_no', 'like', '%' . $search . '%');
    }

    protected $fillable = [

        'invoice_no',
        'invoice_date',
        'total_amount',
        'total_paid',
        'invoice_from',
        'department_id',
        'project_id',
        'customer_id',
        'currency_id',
        'tax_id',
        'terms_id',
        'description',
        'created_by',
        'updated_by',
        'status',
        'reminder_sent_at',
        'billed_project',
        'billed_department',
        'adjustment',  
        'discount_type',
        'discount',
        'discount_total',  
        'discount_percent',
        'due_date',  
        'adjustment', 
        'discount_type',  
        'discount',   
        'discount_total',  
        'discount_percent',
        'invoice_type',
        'billed_by',
        'billed_to',
        'approved_by',
        'acknowledged_by',
        'paid_by',
        'approved_at',   
        'acknowledged_at',   
        'paid_at',  
        'reviewed_at',
        'reviewed_by'
    ];
}
