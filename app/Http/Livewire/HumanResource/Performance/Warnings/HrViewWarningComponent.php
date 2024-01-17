<?php

namespace App\Http\Livewire\HumanResource\Performance\Warnings;

use Livewire\Component;
use App\Models\HumanResource\Performance\Warnings\HrEmployeeWarning;

class HrViewWarningComponent extends Component
{
    public $warning_id; 
    public $additional_comment;

    public $reply;

    public $shouldShowReply = false;

    public $rules = [
        'additional_comment' => 'nullable'
    ];
    function mount($warning_id) {
        $this->warning_id=$warning_id;
    }
    public function render()
    {
        $data['info'] = HrEmployeeWarning::where('id', $this->warning_id)->with(['employee', 'comments','createdBy'])->first();
        return view('livewire.human-resource.performance.warnings.hrview-warning-component', $data);
    }
}
