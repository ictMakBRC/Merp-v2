<?php

namespace App\Models\HumanResource\Performance;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ExitInterview extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'hr_pf_exit_interviews';

    protected $guarded = [];

    protected $cast = ['can_recommend_us' => 'bool'];

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
