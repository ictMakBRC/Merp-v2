<?php

namespace App\Http\Livewire\Inventory\Requests;

use Livewire\Component;
use App\Models\Grants\Project\Project;
use App\Models\HumanResource\Settings\Department;

class InvUnitItemsRequestComponent extends Component
{
    public $entry_type = 'Department';
    public $unit_type = 'department';
    public $unit_id = 0;
    public $unitable_type;
    public $unitable_id;
    public $unitable;
    function mount() {
        if (session()->has('unit_type') && session()->has('unit_id') && session('unit_type') == 'project') {
            $this->unit_id = session('unit_id');
            $this->unit_type = session('unit_type');
            $this->unitable = $unitable = Project::find($this->unit_id);
            $this->entry_type = 'Project';
        } else {
            $this->unit_id = auth()->user()->employee->department_id ?? 0;
            $this->unit_type = 'department';
            $this->unitable = $unitable = Department::find($this->unit_id);
            $this->entry_type = 'Department';
        }
        if ($unitable) {
            $this->unitable_type = get_class($unitable);
            $this->unitable_id = $this->unit_id;
        }else{
            abort(403, 'Unauthorized access or action.'); 
        }
    }
    public function render()
    {
        return view('livewire.inventory.requests.inv-unit-items-request-component');
    }
}
