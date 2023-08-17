<?php

namespace App\Models\HumanResource\Performance;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appraisal extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'hr_pf_appraisals';

    protected $fillable = [
        'department_id',
        'employee_id',
        'start_date',
        'end_date'
    ];
    /**
    * Bootstrap any model services plus the model events here.
    */
    public static function boot()
    {
        parent::boot();
        // if (Auth::check()) {
        //     self::creating(function ($model) {
        //         $model->updated_by = auth()->id();
        //     });
        // }
    }
    /**
     * Search the appraisal by department
     */
    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->whereHas('department', function ($query) use ($search) {
                return $query->where('name', 'like', '%'.$search.'%');
            });
    }
}
