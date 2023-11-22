<?php

namespace App\Models\HumanResource\Settings;

use App\Traits\ProcurementRequestableTrait;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use App\Models\AssetsManagement\Asset;
use App\Models\Grants\Project\Project;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\HumanResource\EmployeeData\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Department extends Model
{
    use HasFactory,LogsActivity, ProcurementRequestableTrait;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Departments')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
    protected $guarded =['id'];

    protected $parentColumn = 'parent_department';

    // public function requests(): MorphMany
    // {
    //     return $this->morphMany(Request::class, 'requestable');
    // }

    public function parent()
    {
        return $this->belongsTo(Department::class,$this->parentColumn);
    }

    public function children()
    {
        return $this->hasMany(Department::class, $this->parentColumn);
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function supervisor()
    {
        return $this->hasOne(Employee::class,'supervisor','id');
    }

    public function ast_supervisor()
    {
        return $this->hasOne(Employee::class,'asst_supervisor','id');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class,'department_project','department_id','project_id')
        ->withTimestamps();
    }

    public function ledger()
    {
        return $this->HasOne(FmsLedgerAccount::class, 'department_id', 'id');
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

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
                ->where('name', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%');

    }
}
