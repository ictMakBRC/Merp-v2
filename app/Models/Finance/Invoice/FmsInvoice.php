<?php

namespace App\Models\Finance\Invoice;

use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsCustomer;
use App\Models\Grants\Project\Project;
use App\Models\HumanResource\Settings\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class FmsInvoice extends Model
{
    use HasFactory, LogsActivity;

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
    public function payments()
    {
        return $this->hasMany(FmsInvoicePayment::class, 'invoice_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
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

    public function biller()
    {
        return $this->belongsTo(Department::class, 'invoice_from', 'id');
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
    ];
}
