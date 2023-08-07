<?php

namespace App\Models\Grants\Project;


use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\HumanResource\Settings\Designation;

class EmployeeProject extends Pivot
{
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
}
