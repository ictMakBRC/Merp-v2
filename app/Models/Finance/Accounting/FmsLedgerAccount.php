<?php

namespace App\Models\Finance\Accounting;

use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Grants\Project\Project;
use App\Models\HumanResource\Settings\Department;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsLedgerAccount extends Model
{
    use HasFactory,LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Ledger Accounts')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
    protected $fillable = [
        'name',
        'descriptions',
        'account_number',
        'department_id',
        'project_id',
        'opening_balance',
        'current_balance',
        'account_type',
        'as_of',
        'created_by',  
        'updated_by', 
        'is_active',
        'currency_id',
    ];

    public function project()
    {
       return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function currency()
    {
       return $this->belongsTo(FmsCurrency::class, 'currency_id', 'id');
    }

    public function department()
    {
       return $this->belongsTo(Department::class, 'department_id', 'id');
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
        return empty($search) ? static::query()
        : static::query()
            ->where('name', 'like', '%'.$search.'%')
            ->where('account_number', 'like', '%'.$search.'%')
            ->orWhere('code', 'like', '%'.$search.'%');
    }

}
