<?php

namespace App\Models\Inventory\Item;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\HumanResource\Settings\Department;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvDepartmentItem extends Model
{
    use HasFactory;

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

      public function unitable(): MorphTo
    {
        return $this->morphTo();
    }

    public function item()
    {
        return $this->belongsTo(InvItem::class, 'inv_item_id', 'id');
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
