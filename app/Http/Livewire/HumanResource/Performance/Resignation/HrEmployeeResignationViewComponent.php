<?php

namespace App\Http\Livewire\HumanResource\Performance\Resignation;

use App\Models\HumanResource\Performance\Resigination\HrEmployeeResignation;
use Livewire\Component;

class HrEmployeeResignationViewComponent extends Component
{
    
    public $view_id; 
    public $additional_comment;

    public $reply;

    public $shouldShowReply = false;

    public $rules = [
        'additional_comment' => 'nullable'
    ];
    function mount($view_id) {
        $this->view_id=$view_id;
    }
    public function render()
    {
        $data['info'] = HrEmployeeResignation::where('id', $this->view_id)->with(['employee', 'comments','createdBy'])->first();
        return view('livewire.human-resource.performance.resignation.hr-employee-resignation-view-component', $data);
    }
}
