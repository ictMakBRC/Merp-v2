<?php

namespace App\Models\HumanResource\Performance;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Warning extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'hr_pf_warnings';

    protected $fillable = [
        'employee_id',
        'subject',
        'letter',
        'created_by',
        'acknowledged_at',
    ];

    /**
     * Bootstrap any model services plus the model events here.
     */
    public static function boot()
    {
        parent::boot();
        if (\Auth::check()) {
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

    /**
     * Search the appraisal by department
     */
    public static function search($search)
    {
        return static::query();
    }
}
