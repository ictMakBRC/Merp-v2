<?php

namespace App\Models\Assets\Settings;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetClassification extends Model
{
  use HasFactory,LogsActivity;

  protected $fillable = [
    'name',
    'description',
  ];

  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()
    ->logOnly(['*'])
    ->logFillable()
    ->useLogName('Asset Classifications')
    ->dontLogIfAttributesChangedOnly(['updated_at'])
    ->logOnlyDirty()
    ->dontSubmitEmptyLogs();
    // Chain fluent methods for configuration options
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
