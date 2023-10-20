<?php

namespace App\Http\Livewire\HumanResource\Leave;

use App\Models\HumanResource\EmployeeData\Employee;
use App\Models\HumanResource\EmployeeData\LeaveRequest\LeaveDelegation;
use App\Models\HumanResource\EmployeeData\LeaveRequest\LeaveRequest;
use App\Models\HumanResource\Settings\LeaveType;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class EditRequest extends Component
{
    public $employee_id;

    public $leave_type_id;

    public $start_date;

    public $end_date;

    public $delegatee_id;

    public $employees;

    public $leaveTypes;

    public $delegatee_comment;

    public $reason;

    public $leaveRequest;

    public $selectedDelegationRequest;

    public $createNew = true;

    public $currentDelegation;

    protected $rules = [
        'employee_id' => 'required',
        'leave_type_id' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'reason' => 'nullable',
    ];

    public function mount(LeaveRequest $leaveRequest)
    {
        $this->employees = Employee::all();
        $this->leaveTypes = LeaveType::all();
        $this->employee_id = $leaveRequest->employee_id;
        $this->leave_type_id = $leaveRequest->leave_type_id;
        $this->start_date = $leaveRequest->start_date;
        $this->end_date = $leaveRequest->end_date;
        $this->reason = $leaveRequest->reason;
    }

    public function store()
    {
        //validate the requests
        $this->validate();

        //save/persist the data
        $this->leaveRequest->update([
            'employee_id' => $this->employee_id,
            'leave_type_id' => $this->leave_type_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'length' => Carbon::parse($this->end_date)->diffInDays(Carbon::parse($this->end_date)),
            'reason' => $this->reason,
        ]);

        //redirect the user
        return redirect()->to(route('leave.requests'));
    }

    /**
     * Detach the delegatee from the leave request
     * This is only / Should only be possible if the delegate request is pending
     * And also if the leave request is pending too
     */
    public function deleteData($delegationId)
    {
        $this->selectedDelegationRequest = $delegationId;
    }

    /**
     * Get the delegation data
     */
    public function editDelegation(LeaveDelegation $delegation)
    {
        $this->createNew = false;
        $this->currentDelegation = $delegation;
        $this->delegatee_comment = $delegation->comment;
        $this->delegatee_id = $delegation->delegated_role_to;
    }

    /**
     * Close the modal
     */
    public function close()
    {
        $this->reset(['delegatee_comment', 'delegatee_id', 'createNew']);
    }

    /**
     * Update the delegatee records
     */
    public function saveDelegate()
    {
        $this->validate([
            'delegatee_id' => 'required|unique:hr_leave_delegations,delegated_role_to,'.$this->currentDelegation->id.'',
            'delegatee_comment' => 'nullable',
        ], [
            'delegatee_id.unique' => 'This employee has already been delegated',
        ]);

        if ($this->createNew == true) {
            //delegate another user to perform duties on your behalf
            $this->leaveRequest->delegateAnotherEmployee($this->delegatee_id, $this->delegatee_comment);
        } else {
            // dd($this->delegatee_comment);
            //delegate another user to perform duties on your behalf
            $this->currentDelegation->update([
                'delegated_role_to' => $this->delegatee_id,
                'comment' => $this->delegatee_comment,
            ]);
        }

        $this->dispatchBrowserEvent('close-modal');
        $this->reset(['delegatee_id', 'delegatee_comment', 'createNew']);
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Delegatee saved successfully!']);

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
        $this->authorize('update', LeaveRequest::class);

        return view('livewire.human-resource.leave.update-request');
    }
}
