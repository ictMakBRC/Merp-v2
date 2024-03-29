<?php

namespace App\Models\HumanResource;

use App\Models\Comment;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Models\HumanResource\EmployeeData\Employee;
use App\Models\HumanResource\Settings\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grievance extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'employee_id',
        'emp_id',
        'department_id',
        'grievance_type_id',
        'subject',
        'addressee',
        'description',
        'acknowledged_at',
        'comment',
        'status',
        'created_by'
     ];

    protected $table = 'hr_grievances';

    /**
     * Get the Employee that created this grievance
     * @return BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function acknowledgedBy()
    {
        return $this->belongsTo(User::class, 'acknowledged_by');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    /**
     * Get the Employee that created this grievance
     * @return BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(GrievanceType::class, 'grievance_type_id');
    }

    /**
     * Comments under this grievance
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

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

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->whereHas('type', function ($query) use ($search) {
                return $query->where('name', 'like', '%'.$search.'%');
            });
    }
}
