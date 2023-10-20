<?php

namespace App\Http\Livewire\HumanResource\Leave;

use App\Models\HumanResource\EmployeeData\Employee;
use App\Models\HumanResource\EmployeeData\LeaveRequest\LeaveRequest;
use App\Models\HumanResource\Settings\LeaveType;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class NewRequest extends Component
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

    protected $rules = [
        'employee_id' => 'required',
        'leave_type_id' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'delegatee_id' => 'required',
        'reason' => 'nullable',
        'delegatee_comment' => 'nullable',
    ];

    public function mount()
    {
        $this->employees = Employee::all();
        $this->leaveTypes = LeaveType::all();
    }

    public function store()
    {
        //validate the requests
        $this->validate();

        //save/persist the data
        $leave = LeaveRequest::create([
            'employee_id' => $this->employee_id,
            'leave_type_id' => $this->leave_type_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'length' => Carbon::parse($this->end_date)->diffInDays(Carbon::parse($this->end_date)),
            'reason' => $this->reason,
        ]);

        //delegate another user to perform duties on your behalf
        $leave->delegateAnotherEmployee($this->delegatee_id, $this->delegatee_comment);

        //redirect the user
        return redirect()->to(route('leave.requests'));
    }

    public function render()
    {
        return view('livewire.human-resource.leave.new-request');
    }
}
