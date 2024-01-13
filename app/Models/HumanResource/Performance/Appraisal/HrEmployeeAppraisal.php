<?php

namespace App\Models\HumanResource\Performance\Appraisal;

use App\Models\User;
use App\Models\Comment;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Models\HumanResource\EmployeeData\Employee;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HrEmployeeAppraisal extends Model implements HasMedia
    {
        use HasFactory;
        use InteractsWithMedia;
    
        protected $fillable = [
            'employee_id',
            'from_date',
            'department_id',
            'to_date',
            'status',
            'comment',
            'created_by',
            'updated_by',
        ];
    
        /**
        * Bootstrap any model services plus the model events here.
        */
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
    
        /**
        * Comments under this grievance
        */
        public function comments(): MorphMany
        {
            return $this->morphMany(Comment::class, 'commentable');
        }
    
        public function commentable(): MorphTo
        {
            return $this->morphTo();
        }
        public function employee()
        {
            return $this->belongsTo(Employee::class, 'employee_id');
        }
        public function acknowledgedBy()
        {
            return $this->belongsTo(User::class, 'created_by');
        }
        public function createdBy()
        {
            return $this->belongsTo(User::class, 'created_by');
        }
    
        /**
         * Search the appraisal by department
         */
        public static function search($search)
        {
            return  static::query();
        }
    }
