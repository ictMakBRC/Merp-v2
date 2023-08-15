<?php

namespace App\Models\HumanResource;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\GrievanceTypeFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GrievanceType extends Model
{
    use HasFactory;

    protected $table = 'hr_grievance_types';

    protected $fillable = ['name', 'slug', 'description'];

    /**
 * Create a new factory instance for the model.
 */
    protected static function newFactory(): Factory
    {
        return GrievanceTypeFactory::new();
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
                ->where('name', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%');
    }

}
