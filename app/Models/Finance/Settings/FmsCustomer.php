<?php

namespace App\Models\Finance\Settings;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsCustomer extends Model
{
    use HasFactory,LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Chart Of Accounts Sub types')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    protected $fillable = [ 
    'account_number',
    'title',
    'surname',
    'first_name',
    'other_name', 
    'gender', 
    'nationality',            
    'address', 
    'city', 
    'email', 
    'alt_email',
    'contact', 
    'fax', 
    'alt_contact', 
    'website', 
    'company_name', 
    'payment_terms', 
    'payment_methods', 
    'opening_balance',
    'sales_tax_registration', 
    'as_of', 
    'is_active',
    'created_by', ];

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
            ->where('surname', 'like', '%'.$search.'%')
            ->where('first_name', 'like', '%'.$search.'%')
            ->where('other_name', 'like', '%'.$search.'%')
            ->where('company_name', 'like', '%'.$search.'%')
            ->where('email', 'like', '%'.$search.'%')
            ->where('contact', 'like', '%'.$search.'%')
            ->orWhere('description', 'like', '%'.$search.'%');
    }
}
