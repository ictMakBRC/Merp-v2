<?php

namespace App\Models\HumanResource\Performance;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Resignation extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'hr_pf_resignations';

    protected $fillable = [
        'employee_id',
        'subject',
        'letter',
        'hand_over_date',
        'acknowledged_at',
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
        return static::query();
    }
}
