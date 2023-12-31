<?php

namespace App\Models\HumanResource\Performance;

use App\Models\Comment;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Termination extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'hr_pf_terminations';

    protected $fillable = [
        'employee_id',
        'reason',
        'letter',
        'termination_date',
        'acknowledged_at'
    ];

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
        return  static::query();
    }
}
