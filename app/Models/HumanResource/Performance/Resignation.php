<?php

namespace App\Models\HumanResource\Performance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resignation extends Model
{
    use HasFactory;

    /**
     * Search the appraisal by department
     */
    public static function search($search)
    {
        return  static::query();
    }
}
