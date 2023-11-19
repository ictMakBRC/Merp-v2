<?php

namespace App\Models\inventory;

use App\Models\Inventory\InvStockDocumentItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invRequestitem extends Model
{
    use HasFactory;

    public function item()
    {
        return $this->belongsTo(invItems::class, 'inv_item_id', 'id');        
    }

    public function stockCards()
    {
        return $this->hasMany(InvStockDocumentItem::class, 'inv_item_id', 'inv_items_id')->where('qyt_remaining','>',0);        
    }

}
