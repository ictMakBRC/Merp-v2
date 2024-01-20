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

    
    public function category()
    {
        return $this->belongsTo(AssetCategory::class, 'asset_categories_id', 'id');
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
