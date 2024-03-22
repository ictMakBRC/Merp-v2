<?php

namespace App\Models\Inventory\Stock;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inventory\Item\InvDepartmentItem;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvItemStockCard extends Model
{
    use HasFactory;
    protected $fillable = [
        'batch_id',
        'request_id',
        'inv_item_id',
        'voucher_number',
        'quantity',
        'comment',
        'quantity_in',
        'quantity_out',
        'opening_balance',
        'losses_adjustments',
        'physical_count',
        'discrepancy',
        'quantity_resolved',
        'batch_balance',
        'item_balance',
        'initial_quantity',
        'transaction',
        'transaction_type',
    ];
    // public function unitable(): MorphTo
    // {
    //     return $this->morphTo();
    // }
    public function departmentItem()
    {
        return $this->belongsTo(InvDepartmentItem::class, 'inv_item_id', 'id');
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
    public function createdBy()
        {
            return $this->belongsTo(User::class, 'created_by');
        }
        

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
                ->where('voucher_number', 'like', '%'.$search.'%')
                ->orWhereHas('departmentItem', function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                })

                    ;
    }
}
