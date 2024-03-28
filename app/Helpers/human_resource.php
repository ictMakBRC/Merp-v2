<?php

use Illuminate\Support\Collection;
use App\Models\HumanResource\EmployeeData\Employee;



function myTeam($supervisorId)
{
    $myTeam=Employee::where('reporting_to',$supervisorId)->where('is_active',true)->value('id')->toArray();
    return $myTeam;
    
}