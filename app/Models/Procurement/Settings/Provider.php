<?php

namespace App\Models\Procurement\Settings;

use App\Traits\DocumentableTrait;
use App\Services\GeneratorService;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Procurement\Request\ProcurementRequest;
use App\Models\Procurement\Request\SelectedProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provider extends Model
{
    use HasFactory , LogsActivity, DocumentableTrait;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Providers')
            ->dontLogIfAttributesChangedOnly(['updated_at', 'password'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }


    public function procurementSubcategories()
    {
        return $this->belongsToMany(ProcurementSubcategory::class,'provider_subcategory','provider_id','subcategory_id')
        ->withTimestamps();
    }

    public function preferred_currency()
    {
        return $this->belongsTo(FmsCurrency::class, 'preferred_currency');
    }

    public function procurement_requests()
    {
        return $this->belongsToMany(ProcurementRequest::class,'selected_providers','provider_id','procurement_request_id')
        ->withTimestamps();
    }

    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = auth()->id();
                $model->provider_code = GeneratorService::providerNo();
            });
        }
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
        : static::query()
            ->where('name', 'like', '%'.$search.'%')
            ->orWhere('phone_number', 'like', '%'.$search.'%')
            ->orWhere('provider_type', 'like', '%'.$search.'%')
            ->orWhere('country', 'like', '%'.$search.'%');
    }
}
