<?php

namespace App\Models\Inventory\Item;

use App\Models\HumanResource\Settings\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvDepartmentItem extends Model
{
    use HasFactory;

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(InvItem::class, 'inv_item_id', 'id');
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
                ->where('brand', 'like', '%'.$search.'%')
                ->orWhereHas('item', function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                })
                ->orWhereHas('department', function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                })

                    ;
    }
}
