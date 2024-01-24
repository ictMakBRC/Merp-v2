<?php

namespace App\Models\Inventory\Stock;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvStockLog extends Model
{
    use HasFactory;

    protected $fillable = [
            'entry_type', 
            'procurement_id', 
            'stock_code',  
            'grn',  
            'delivery_no',  
            'lpo',  
            'date_added',  
            'status',            
            'created_by', 
            'acknowledged_by',
            'acknowledged_at',  
            'updated_by',       
    ];
    public function unitable(): MorphTo
    {
        return $this->morphTo();
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
                ->orWhereHas('unitable', function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                })

                ;
    }
}
