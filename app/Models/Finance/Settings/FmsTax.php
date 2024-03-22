<?php

namespace App\Models\Finance\Settings;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Finance\Transactions\FmsTransaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsTax extends Model
{
    use HasFactory,LogsActivity;

    protected $fillable =[

        'name',
        'rate',
        'is_active',
        'created_by'
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Financial Years')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    public function transactions()
    {
        return $this->hasMany(FmsTransaction::class,'tax_id');
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
            ->where('name', 'like', '%'.$search.'%')
            ->where('rate', 'like', '%'.$search.'%');
    }
}
