<?php

namespace App\Http\Livewire\HumanResource\Payroll;

use App\Models\Finance\Settings\FmsCurrency;
use App\Models\HumanResource\EmployeeData\Employee;
use App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\Settings\Office;
use Livewire\Component;

class HrGenerateOfficialPayrollComponent extends Component
{
    public $showList = false, $allEmployees = false;
    public $from_date, $to_date, $department_id, $employee_id;
    public $usd_rate, $show_month, $global = null;
    public $emp_payroll;
    public $employeeIds = [];
    public $selectedEmployeeIds = [];
    public $approver_id = 0;
    public $prepper_id = 0;

    public function mount()
    {
        if ($this->show_month == null) {
            $this->show_month = date('Y-m');
        }
        if ($this->usd_rate == '') {
            $this->global = FmsCurrency::latest()->first();
            $this->usd_rate = 3700;
        }

        $this->emp_payroll = collect([]);
    }

    public function generatePayroll()
    {
        $this->emp_payroll = Employee::with(['department', 'officialContract'])
            ->when($this->employee_id, function ($query) {$query->where('id', $this->employee_id);})
            ->when($this->department_id, function ($query) {$query->where('department_id', $this->department_id);})
            ->get() ?? collect([]);

        $this->employeeIds = $this->emp_payroll->pluck('id')->toArray();
    }

    public function sendPayslip()
    {
        if (count($this->selectedEmployeeIds) > 0) {

            try {
                SendPaySlip::dispatch($this->selectedEmployeeIds);
                // $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Payslip sent successfully']);
                $this->dispatchBrowserEvent('swal:modal', [
                    'type' => 'success',
                    'message' => 'Payslip sent',
                    'text' => 'Payslip have/has been sent successfully',
                ]);

            } catch (\Throwable $th) {
                $this->dispatchBrowserEvent('swal:modal', [
                    'type' => 'error',
                    'message' => 'Oops! Sending failed!',
                    'text' => 'Something went wrong and Payslip could not be sent. Please try again.',
                ]);
            }

        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No Employees selected for this operation!',
            ]);
        }
    }

    public function render()
    {
        $data['issuers'] = Office::all();
        $data['employees'] = Employee::where('is_active', '1')->when($this->department_id, function ($query) {$query->where('department_id', $this->department_id);})
            ->orderBy('surname', 'asc')->get();
        $data['departments'] = Department::orderBy('name', 'asc')->get();

        return view('livewire.human-resource.payroll.hr-generate-official-payroll-component', $data);
    }
}
