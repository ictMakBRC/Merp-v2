<?php

namespace App\Models\Finance\Invoice;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsInvoicePayment extends Model
{
    use HasFactory;
   
    public function invoice()
    {
        return $this->belongsTo(FmsInvoice::class, 'invoice_id', 'id');
    }
    public function requestable(): MorphTo
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
            self::updating(function ($model) {
                $model->updated_by = auth()->id();
            });
        }
    }

    public static function search($search)
    {
        return empty($search)?static::query()
        : static::query()
            ->where('payment_reference', 'like', '%' . $search . '%');
    }

    protected $fillable = [

        'invoice_id',
        'payment_reference',
        'as_of',
        'payment_amount',
        'payment_balance',
        'payment_reference',
        'description',
        'created_by',
        'updated_by',
        'status',
    ];
}
