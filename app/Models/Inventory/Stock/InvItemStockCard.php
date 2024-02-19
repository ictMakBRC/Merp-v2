<?php

namespace App\Models\Inventory\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
