<?php

namespace App\Http\Livewire\HumanResource\Leave;

use App\Models\HumanResource\EmployeeData\Employee;
use App\Models\HumanResource\EmployeeData\LeaveRequest\LeaveDelegation;
use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\HumanResource\Settings\LeaveType;
use App\Models\HumanResource\EmployeeData\LeaveRequest\LeaveRequest;

class DepartmentalRequests extends Component
{
    public $delegatee_comment;

    public $selectedDelegation;

    public function mount()
    {

    }

    public function selectThisDelegation(LeaveDelegation $delegation)
    {
        $this->selectedDelegation = $delegation;
    }

    /**
     * Accept the leave delegation
     */
    public function acceptDelegation()
    {
        $this->selectedDelegation->accept($this->delegatee_comment);
        $this->dispatchBrowserEvent('close-modal');
        $this->reset(['delegatee_comment']);
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Request declined successfully!']);

    }

    /**
     * Accept the leave delegation
     */
    public function declineDelegation()
    {
        $this->selectedDelegation->decline($this->delegatee_comment);

        $this->dispatchBrowserEvent('close-modal');
        $this->reset(['delegatee_comment']);
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Request declined successfully!']);
    }

    /**
     * Close the modal
     */
    public function close()
    {
        $this->reset(['delegatee_comment']);
    }


    /**
     * Delete the Leave request if its pending
     */
    public function delete()
    {
        $delegation = LeaveDelegation::findOrFail($this->selectedDelegationRequest);
        $delegation->delete();

        return redirect()->to(route('leaves.edit-request', $this->leaveRequest->id));
    }

    /**
     * Render the leave request view
     */
    public function render()
    {
        $user = auth()->user();

        $allIds = Employee::where('reporting_to', $user->id)->pluck('id');

        $leaveRequests = LeaveRequest::query()
                                        ->whereIn('employee_id', $allIds)
                                        ->where('status', PENDING)
                                        ->get();

        return view('livewire.human-resource.leave.departmental.index', [
            'leaveRequests' => $leaveRequests
        ]);
    }
}
