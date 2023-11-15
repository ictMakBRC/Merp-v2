<?php

namespace App\Models\Procurement\Request;

use App\Models\User;
use App\Traits\CurrencyTrait;
use App\Traits\DocumentableTrait;
use App\Services\GeneratorService;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Procurement\Settings\Provider;
use App\Models\HumanResource\Settings\Department;
use App\Models\Procurement\Request\SelectedProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Procurement\Request\ProcurementRequestItem;
use App\Models\Procurement\Request\ProcurementRequestApproval;
use App\Models\Procurement\Request\ProcurementRequestDecision;
use App\Models\Procurement\Settings\ProcurementCategorization;
use App\Models\Procurement\Settings\ProcurementMethod;
use App\Models\Procurement\Settings\ProcurementSubcategory;
use App\Traits\BudgetLineTrait;
use App\Traits\FinancialYearTrait;

class ProcurementRequest extends Model
{
    use HasFactory,LogsActivity,DocumentableTrait,CurrencyTrait,BudgetLineTrait,FinancialYearTrait;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Procurement Requests')
            ->dontLogIfAttributesChangedOnly(['updated_at', 'password'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    protected $guarded = [
        'id',
    ];

    public function requestable()
    {
        return $this->morphTo();
    }


    public function items()
    {
        return $this->hasMany(ProcurementRequestItem::class,'procurement_request_id','id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function approvals()
    {
        return $this->hasMany(ProcurementRequestApproval::class, 'procurement_request_id');
    }

    public function decisions()
    {
        return $this->hasMany(ProcurementRequestDecision::class, 'procurement_request_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function procurement_method()
    {
        return $this->belongsTo(ProcurementMethod::class, 'procurement_method_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(ProcurementSubcategory::class,'subcategory_id');
    }

    public function procurement_categorization()
    {
        return $this->belongsTo(ProcurementCategorization::class, 'procurement_categorization_id');
    }

    public function contracts_manager()
    {
        return $this->belongsTo(User::class, 'contracts_manager_id');
    }

    public function providers()
    {
        return $this->belongsToMany(Provider::class,'selected_providers','procurement_request_id','provider_id')
        ->using(SelectedProvider::class) // Use the pivot model
        ->withPivot(['is_best_bidder','bidder_contract_price','bidder_revised_price','payment_status','date_paid','quality_rating','timeliness_rating','cost_rating','average_rating','contracts_manager_comment','created_by'])
        ->withTimestamps();
    }

    public function bestBidders()
    {
        // return $this->providers
        return $this->belongsToMany(Provider::class, 'selected_providers', 'procurement_request_id', 'provider_id')
        ->using(SelectedProvider::class)
        ->withPivot(['is_best_bidder', 'bidder_contract_price', 'bidder_revised_price', 'payment_status', 'date_paid', 'quality_rating', 'timeliness_rating', 'cost_rating', 'average_rating', 'contracts_manager_comment', 'created_by'])
        ->wherePivot('is_best_bidder', true);
    }

    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = auth()->id();
                $model->reference_no = GeneratorService::procurementRequestRef($model->procurement_sector);
                $model->sequence_number = GeneratorService::procurementRequestRef($model->procurement_sector);
            });
        }
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
        : static::query()
            ->where('reference_no', 'like', '%'.$search.'%')
            ->orWhere('request_type', 'like', '%'.$search.'%')
            ->orWhere('subject', 'like', '%'.$search.'%')
            ->orWhere('procurement_sector', 'like', '%'.$search.'%')
            ->orWhere('status', 'like', '%'.$search.'%');
    }
}
