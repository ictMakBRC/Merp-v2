<?php

namespace App\Models\HumanResource\Performance;

use App\Models\User;
use App\Models\Comment;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Models\HumanResource\EmployeeData\Employee;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warning extends Model implements HasMedia
{
    use HasFactory;
    use  InteractsWithMedia;

    protected $table = 'hr_pf_warnings';

    protected $fillable = [
        'employee_id',
        'subject',
        'reason',
        'tags',
        'letter',
        'created_by',
        'acknowledged_at'
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
        }
    }

    /**
    * Comments under this grievance
    */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function acknowledgedBy()
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
