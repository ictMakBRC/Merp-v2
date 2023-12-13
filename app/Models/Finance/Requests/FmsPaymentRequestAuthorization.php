<?php

namespace App\Models\Finance\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsPaymentRequestAuthorization extends Model
{
    use HasFactory;
    function authPosition(){
        return $this->belongsTo(FmsPaymentRequestPosition::class, 'position', 'id');
    }
    function user(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    function approver(){
        return $this->belongsTo(User::class, 'approver_id', 'id');
    }
    protected $fillable = [
        'level',
        'position',
        'approver_id',  
        'signature',
        'signature_date',
        'request_id',
        'request_code',
        'status',
        'created_by',  
        'updated_by',
    ];
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
}
