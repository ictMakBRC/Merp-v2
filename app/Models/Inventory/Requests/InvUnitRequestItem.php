<?php

namespace App\Models\Inventory\Requests;

use Illuminate\Database\Eloquent\Model;
use App\Models\Inventory\Item\InvDepartmentItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvUnitRequestItem extends Model
{
    use HasFactory;
    public function departmentItem()
    {
        return $this->belongsTo(InvDepartmentItem::class, 'inv_item_id', 'id');
    }

}
