<?php

namespace App\Http\Livewire\HumanResource\Performance\Termination;

use App\Models\HumanResource\Performance\Termination\HrEmployeeTermination;
use Livewire\Component;

class HrTerminationViewComponent extends Component
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
        $data['info'] = HrEmployeeTermination::where('id', $this->view_id)->with(['employee', 'comments','createdBy'])->first();
        return view('livewire.human-resource.performance.termination.hr-termination-view-component', $data);
    }
}
