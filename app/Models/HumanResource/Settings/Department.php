<?php

namespace App\Models\HumanResource\Settings;

use App\Models\User;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use App\Models\AssetsManagement\Asset;
use App\Models\HumanResource\EmployeeData\Employee;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory,LogsActivity;

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
    protected $fillable =['asst_supervisor','supervisor','name','created_by','is_active'];
    /**
     * The attributes that are not mass assignable.
     *
     * @var string[]
     */
    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_department', 'id');
    }

    public function child()
    {
        return $this->hasMany(Department::class, 'parent_department', 'id');
    }
    public function supervisor()
    {
        return $this->hasOne(Employee::class,'id', 'supervisor');
    }

    public function ast_supervisor()
    {
        return $this->hasOne(Employee::class, 'id', 'asst_supervisor');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    // protected $parentColumn = 'parent_id';

    // public function parent()
    // {
    //     return $this->belongsTo(Test::class,$this->parentColumn);
    // }

    // public function children()
    // {
    //     return $this->hasMany(Test::class, $this->parentColumn);
    // }

    // public function allChildren()
    // {
    //     return $this->children()->with('allChildren');
    // }

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
