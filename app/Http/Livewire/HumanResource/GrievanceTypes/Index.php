<?php

namespace App\Http\Livewire\HumanResource\GrievanceTypes;

use App\Models\HumanResource\GrievanceType;
use Livewire\Component;

class Index extends Component
{
    public $perPage = 10;

    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $grievanceTypes =  GrievanceType::paginate($this->perPage);
        return view('livewire.human-resource.grievance-types.index', ['grievanceTypes' => $grievanceTypes]);
    }
}
