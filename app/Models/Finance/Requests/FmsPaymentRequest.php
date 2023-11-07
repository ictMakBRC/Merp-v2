<?php

namespace App\Models\Finance\Requests;

use App\Models\User;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use App\Models\Grants\Project\Project;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\HumanResource\Settings\Department;
use App\Models\Finance\Accounting\FmsLedgerAccount;
use App\Models\Finance\Budget\FmsBudgetLine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class FmsPaymentRequest extends Model
{
    use HasFactory, LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Payment Requests')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
     public function requestable(): MorphTo
    {
        return $this->morphTo();
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function toProject()
    {
        return $this->belongsTo(Project::class, 'to_project_id', 'id');
    }

    public function budgetLine()
    {
        return $this->belongsTo(FmsBudgetLine::class, 'budget_line_id', 'id');
    }

    public function fromAccount()
    {
        return $this->belongsTo(FmsLedgerAccount::class, 'from_account', 'id');
    }

    public function toAccount()
    {
        return $this->belongsTo(FmsLedgerAccount::class, 'to_account', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function toDepartment()
    {
        return $this->belongsTo(Department::class, 'to_department_id', 'id');
    }
    function user() {
        return $this->belongsTo(User::class, 'created_by', 'id');
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
        'request_description',
        'request_type',
        'total_amount',
        'ledger_amount',
        'budget_amount',
        'amount_in_words',
        'requester_signature',
        'date_submitted', 
        'date_approved', 
        'rate',           
        'currency_id',
        'notice_text',
        'department_id',
        'project_id',
        'budget_line_id',
        'from_account',
        'status',
        'created_by',   
        'updated_by',             
        'request_table',
        'subject_id',
    ];
}
