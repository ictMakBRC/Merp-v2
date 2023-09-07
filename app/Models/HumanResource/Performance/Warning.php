<?php

namespace App\Models\HumanResource\Performance;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warning extends Model implements HasMedia
{
    use HasFactory;
    use  InteractsWithMedia;

    protected $table = 'hr_pf_warnings';

    protected $fillable = [
        'employee_id',
        'reason',
        'letter',
        'created_by'
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
     * Search the appraisal by department
     */
    public static function search($search)
    {
        return  static::query();
    }
}
