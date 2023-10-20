<?php

namespace App\Models\Grants\Project;

use App\Models\HumanResource\Settings\Designation;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EmployeeProject extends Pivot
{
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
}
