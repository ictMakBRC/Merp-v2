<?php

namespace App\Models\Finance\Invoice;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use App\Models\Grants\Project\Project;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsFinancialYear;
use App\Models\Finance\Settings\FmsService;
use App\Models\Finance\Settings\FmsUnitService;
use App\Models\HumanResource\Settings\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsInvoiceItem extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Invoice Items')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

        public function uintService()
    {
        return $this->belongsTo(FmsUnitService::class, 'item_id', 'id');
    }
    public function invoice()
    {
        return $this->belongsTo(FmsInvoice::class, 'invoice_id', 'id');
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
            ->where('description', 'like', '%' . $search . '%');
    }

    protected $fillable = [
        'invoice_id',
        'item_id',
        'tax_id',
        'quantity',
        'unit_price',
        'line_total',
        'description',
        'created_by',
        'updated_by',
    ];

}
