<?php

namespace App\Models\Inventory\Item;

use App\Models\Inventory\Settings\InvCategory;
use App\Models\Inventory\Settings\InvUnitOfMeasure;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvItem extends Model
{
  protected $fillable = [
    'name',
    'category_id',
    'cost_price',
    'uom_id',
    'max_qty',
    'min_qty',
    'sku',
    'description',
    'is_active',
    'expires',
    'item_code',
    'created_by',
  ];

  public function category()
  {
    return $this->belongsTo(InvCategory::class, 'category_id', 'id');
  }


  public function uom()
  {
    return $this->belongsTo(InvUnitOfMeasure::class, 'uom_id', 'id');
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

  public static function search($search)
  {
    return empty($search) ? static::query()
    : static::query()
    ->where('name', 'like', '%'.$search.'%')
    ->orWhere('item_code', 'like', '%'.$search.'%')
    ->orWhere('description', 'like', '%'.$search.'%')
    ->orWhereHas('category', function ($query) use ($search) {
      $query->where('name', 'like', '%'.$search.'%');
    })
    ->orWhereHas('uom', function ($query) use ($search) {
      $query->where('name', 'like', '%'.$search.'%');
    })

    ;
  }
}
