<?php

namespace App\Models\HumanResource\Performance;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExitInterview extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'hr_pf_exit_interviews';

    protected $guarded = [];

    protected $cast = ['can_recommend_us' => 'bool'];

    /**
     * Search the appraisal by department
     */
    public static function search($search)
    {
        return  static::query();
    }
}
