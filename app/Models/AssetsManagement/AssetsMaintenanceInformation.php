<?php

namespace App\Models\AssetsManagement;

use App\Models\Global\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AssetsMaintenanceInformation extends Model
{
    use HasFactory;

    public $table = 'asset_maintenance_info';

    protected $fillable = [
        'type',
        'authorised_by',
        'issue_ref',
        'vendor',
        'intenal_vendor',
        'description',
        'recommendation',
        'maintenance_date',
        'next_maintenance',
    ];

    public function issue()
    {
        return $this->belongsTo(AssetsIssue::class, 'issue_ref', 'reference');
    }

    public function authorisedby()
    {
        return $this->belongsTo(User::class, 'authorised_by', 'id');
    }

    public function externalvendor()
    {
        return $this->belongsTo(Supplier::class, 'vendor', 'id');
    }

    public function internalvendor()
    {
        return $this->belongsTo(User::class, 'internal_vendor', 'id');
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
