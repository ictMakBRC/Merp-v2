<?php

namespace App\Http\Livewire\Grants\Projects\Inc;

use Livewire\Component;
use App\Models\Grants\Project\Project;
use App\Models\HumanResource\Settings\Designation;
use App\Models\HumanResource\EmployeeData\Employee;

class ProjectEmployeesComponent extends Component
{
    public function render()
    {
        $data['projects'] = Project::where('end_date','>',today())->get();
        $data['designations'] = Designation::where('is_active',true)->get();
        $data['employees'] = Employee::where('is_active',true)->get();
        return view('livewire.grants.projects.inc.project-employees-component',$data);
    }
}
