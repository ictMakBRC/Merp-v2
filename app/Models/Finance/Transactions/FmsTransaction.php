<?php

namespace App\Models\Finance\Transactions;

use Illuminate\Support\Facades\Auth;
use App\Models\Grants\Project\Project;
use Illuminate\Database\Eloquent\Model;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsCustomer;
use App\Models\HumanResource\Settings\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FmsTransaction extends Model
{
    use HasFactory;
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(FmsCustomer::class, 'customer_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    public function currency()
    {
        return $this->belongsTo(FmsCurrency::class, 'currency_id', 'id');
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
            ->where('trx_ref', 'like', '%'.$search.'%')
            ->where('trx_no', 'like', '%'.$search.'%');
    }

    protected $fillable =[
        'trx_no',
        'trx_ref',
        'trx_date',
        'total_amount',
        'rate',
        'department_id',    
        'project_id',
        'billed_department',    
        'billed_project',
        'customer_id',
        'currency_id',
        'budget_line_id',
        'account_id',
        'trx_type',
        'entry_type',
        'status',
        'description',           
        'created_by',
        'updated_by',
        'is_active',
        'is_department',
    ];
}
