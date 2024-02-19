<?php

namespace App\Models\Assets;

use App\Traits\CurrencyTrait;
use App\Models\Assets\AssetLog;
use App\Traits\DocumentableTrait;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Assets\Settings\AssetCategory;
use App\Models\Procurement\Settings\Provider;
use App\Models\Procurement\Request\ProcurementRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetsCatalog extends Model
{
    use HasFactory,LogsActivity,DocumentableTrait,CurrencyTrait;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Assets Catalog')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    protected $table='asset_catalog';

    protected $guarded =['id'];

    public function assetable()
    {
        return $this->morphTo();
    }

    public function category()
    {
        return $this->belongsTo(AssetCategory::class, 'asset_category_id', 'id');
    }

    public function procurement_request()
    {
        return $this->belongsTo(ProcurementRequest::class, 'procurement_request_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Provider::class, 'supplier_id', 'id');
    }

    public function service_provider()
    {
        return $this->belongsTo(Provider::class, 'service_provider', 'id');
    }

    public function logs()
    {
        return $this->hasMany(AssetLog::class, 'asset_catalog_id', 'id')->latest();
    }
    
    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = auth()->id();
            });
        }
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()           
                ->where('name', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%');
               
    }
}
