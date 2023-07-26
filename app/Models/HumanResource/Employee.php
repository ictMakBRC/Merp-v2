<?php

namespace App\Models\HumanResource;

use App\Models\Global\Department;
use App\Models\Global\Station;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['emp_id', 'nin_number', 'prefix', 'surname', 'first_name', 'other_name',
        'gender', 'nationality', 'birthday', 'age', 'birth_place', 'religious_affiliation',
        'height', 'weight', 'blood_type', 'civil_status', 'address',
        'email', 'alt_email', 'contact', 'alt_contact', 'designation_id', 'station_id', 'department_id', 'department_unit_id',
        'reporting_to', 'work_type', 'join_date', 'status', 'tin_number', 'nssf_number',
        'photo', 'signature', 'created_by', ];

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

    public function departmentunit()
    {
        return $this->belongsTo(Department::class, 'department_unit_id', 'id');
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
}
