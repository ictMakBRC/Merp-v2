<?php

namespace App\Models\HumanResource;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrievanceType extends Model
{
    use HasFactory;

    protected $table = 'hr_grievance_types';

    protected $fillable = ['name', 'slug', 'description'];

}
