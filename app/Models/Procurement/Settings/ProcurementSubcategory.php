<?php

namespace App\Models\Procurement\Settings;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Procurement\Settings\Provider;
use App\Services\GeneratorService;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProcurementSubcategory extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded=[];
    protected $table='proc_subcategories';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Procurement Subcategories')
            ->dontLogIfAttributesChangedOnly(['updated_at', 'password'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    public function providers()
    {
        return $this->belongsToMany(Provider::class,'provider_subcategory','subcategory_id','provider_id')
        ->withTimestamps();
    }

    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = auth()->id();
                $model->code = GeneratorService::procurementSubcategoryCode($model->category);
            });
        }
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
        : static::query()
            ->where('name', 'like', '%'.$search.'%')
            ->orWhere('code', 'like', '%'.$search.'%')
            ->orWhere('category', 'like', '%'.$search.'%');
    }

}
