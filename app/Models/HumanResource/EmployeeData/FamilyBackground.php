<?php

namespace App\Models\HumanResource\EmployeeData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyBackground extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'member_type',
        'surname', 'first_name', 'middle_name', 'address', 'contact', 'occupation', 'employer', 'employer_address', 'employer_contact', ];
}
