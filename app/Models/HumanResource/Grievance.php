<?php

namespace App\Models\HumanResource;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grievance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'emp_id',
        'department_id',
        'grievance_type',
        'addressee',
        'description',
        'support_file',
        'comment',
        'status',
        'created_by'
     ];

    /**
     * Get the Employee that created this grievance
     * @return BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
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
}
