<?php

namespace App\Models\Finance\Transactions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsTransaction extends Model
{
    use HasFactory;
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
        return empty($search) ? static::query()
        : static::query()
            ->where('trx_ref', 'like', '%'.$search.'%')
            ->where('trx_no', 'like', '%'.$search.'%');
    }

    protected $fillable =[
        'name',           
        'esitmated_income',
        'estimated_expenditure',     
        'fiscal_year',
        'department_id',
        'project_id',
        'account_id',
        'created_by',
        'updated_by',
        'is_active',
    ];
}
