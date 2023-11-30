<?php

namespace App\Models\Inventory\Stockcard;

use App\Models\User;
use App\Models\Inventory\Item\InvItem;
use App\Models\Inventory\Settings\InvStorageBin;
use App\Models\HumanResource\Settings\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvStockcard extends Model
{
  use HasFactory,LogsActivity;

  protected $fillable = [
    'item_id',
    'created_by',
    'department_id',
    'barcode',
    'voucher_number',
    'quantity',
    'action',
    'batch_number',
    'batch_balance',
    'expiry_date',
    'received_date',
    'initials',
    'comment',
    'previous_balance',
    'balance',
    'transaction_date',
    'quantity_in',
    'quantity_out',
    'opening_balance',
    'physical_count',
    'discrepancy',
    'quantity_resolved',
    'created_at',
    'updated_at',
    'losses_adjustments',
    'transaction_type',
    'to_from',
  ];

  public function item()
  {
    return $this->belongsTo(InvItem::class, 'item_id', 'id');
  }

  public function department()
  {
    return $this->belongsTo(Department::class, 'department_id', 'id');
  }

  public function supplier()
  {
    return $this->belongsTo(Institution::class, 'supplier_id', 'id');
  }

  public function storageBin()
  {
    return $this->belongsTo(StorageBin::class,'storage_bin_id','id');
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'created_by', 'id');
  }


  public static function boot()
  {
    parent::boot();
    if (\Auth::check()) {
      self::creating(function ($model) {
        $model->created_by = auth()->id();
      });
    }
  }

  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()
    ->logOnly(['*'])
    ->logFillable()
    ->useLogName('Stock Cards')
    ->dontLogIfAttributesChangedOnly(['updated_at'])
    ->logOnlyDirty()
    ->dontSubmitEmptyLogs();
    // Chain fluent methods for configuration options
  }

  public static function search($search)
  {
    return empty($search) ? static::query()
    : static::query()
    ->where('voucher_number', 'like', '%'.$search.'%')
    ->orWhereHas('commodity', function ($query) use ($search) {
      $query->where('name', 'like', '%'.$search.'%');
    });
  }

}
