<?php

namespace App\Models\Inventory\Settings;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvSupplier extends Model
{
  use HasFactory,LogsActivity;

  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()
    ->logOnly(['*'])
    ->logFillable()
    ->useLogName('Inventory Suppliers')
    ->dontLogIfAttributesChangedOnly(['updated_at'])
    ->logOnlyDirty()
    ->dontSubmitEmptyLogs();
    // Chain fluent methods for configuration options
  }

  protected $table ='inv_suppliers';
  protected $fillable = [
    'name',
    'description',
    'created_by',
    'is_active',
  ];

  public function user()
  {
    return $this->belongsTo(User::class, 'created_by', 'id');
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
