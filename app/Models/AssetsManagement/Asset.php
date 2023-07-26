<?php

namespace App\Models\AssetsManagement;

use App\Models\Global\Department;
use App\Models\Global\InsuranceType;
use App\Models\Global\Station;
use App\Models\Global\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_name',
        'asset_category_id',
        'asset_subcategory_id',
        'brand',
        'model',
        'serial_number',
        'barcode',
        'engraved_label',
        'status',
        'user_id',
        'station_id',
        'department_id',
        'condition',
        'vendor_id',
        'purchase_price',
        'purchase_date',
        'purchase_order_number',
        'warranty_end',
        'depreciation_method',
        'depreciation_rate',
        'expected_useful_years',
        'insurance_company',
        'insurance_type',
        'insurance_end',
        'remarks',

    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function category()
    {
        return $this->belongsTo(AssetsCategory::class, 'asset_category_id');
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(AssetsSubcategory::class, 'asset_subcategory_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function insurer()
    {
        return $this->belongsTo(Supplier::class, 'insurance_company', 'id');
    }

    public function insurancetype()
    {
        return $this->belongsTo(InsuranceType::class, 'insurance_type', 'id');
    }

    public function assignmenthistory()
    {
        return $this->hasMany(AssetsAssignmentHistory::class, 'asset_id', 'id')->orderBy('created_at', 'desc');
    }

    public function issues()
    {
        return $this->hasMany(AssetsIssue::class);
    }

    public function maintenanceinfo()
    {
        return $this->hasManyThrough(AssetsMaintenanceInformation::class, AssetsIssue::class, 'asset_id', 'issue_ref', 'id', 'reference')->orderBy('created_at', 'desc');
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
}
