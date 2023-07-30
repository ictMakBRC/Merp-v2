<?php

namespace App\Models\HumanResource\EmployeeData;

use Carbon\Carbon;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\HumanResource\Settings\Station;
use App\Models\HumanResource\Settings\Department;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\HumanResource\Settings\Designation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory,LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Employees')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    protected $guarded = ['id'];

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function station()
    {
        return $this->belongsTo(Station::class, 'station_id', 'id');
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->prefix.' '.$this->surname.' '.$this->first_name.' '.$this->other_name,
        );
    }

    protected function empAge(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::createFromFormat('Y-m-d', $this->birthday)->diffInYears(Carbon::today()),

        );
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
                ->where('surname', 'like', '%'.$search.'%')
                ->orWhere('first_name', 'like', '%'.$search.'%');               
    }
}
