<?php

namespace App\Models\HumanResource\Performance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Termination extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'hr_pf_terminations';

    protected $fillable = [
        'employee_id',
        'reason',
        'letter',
        'termination_date'
    ];

    /**
     * Search the appraisal by department
     */
    public static function search($search)
    {
        return  static::query();
    }
}
