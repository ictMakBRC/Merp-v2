<?php

namespace App\Models\Inventory\Stock;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inventory\Item\InvDepartmentItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvStockLogItem extends Model
{
    use HasFactory;
    
    public function item()
    {
        return $this->belongsTo(InvDepartmentItem::class, 'inv_item_id', 'id');
    }

    protected $fillable = [
        'inv_stock_log_id',
        'inv_item_id',
        'stock_qty',
        'qyt_given',
        'batch_no',
        'expiry_date',
        'unit_cost',
        'total_cost',
        'inv_store_id',
        'created_by',
    ];
    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = auth()->id();
            });
        }
    }
    public function createdBy()
        {
            return $this->belongsTo(User::class, 'created_by');
        }

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
                ->where('brand', 'like', '%'.$search.'%')
                ->orWhereHas('item', function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                })
                ->orWhereHas('unitable', function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                })

                    ;
    }
}
