<?php

namespace App\Http\Livewire\Finance\Payroll;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\Finance\Payroll\FmsPayroll;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Payroll\FmsPayrollData;
use App\Models\Finance\Requests\FmsRequestEmployee;

class FmsPayrollScheduleComponent extends Component
{
    use WithPagination;
    public $from_date;

    public $to_date;

    public $serviceIds;

    public $perPage = 10;

    public $search = '';
    public $searchEmployee = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $delete_id;

    public $edit_id;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public $is_active = 1;
    public $voucher;
    public $payroll;
    public $months;

    public function export()
    {
        if ($this->payroll) {
            // return (new servicesExport($this->serviceIds))->download('services_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No services selected for export!',
            ]);
        }
    }
    public function mount($voucher)
    {
        $this->voucher = $voucher;
        $this->payroll = FmsPayroll::where('payment_voucher', $voucher)->with('currency')->first();

    }
    public function addEmployee($id)
    {
        DB::transaction(function () use ($id) {
            $employee = FmsRequestEmployee::where(['status' => 'Approved', 'id' => $id])->first();
            if ($employee) {
                $payroll = FmsPayrollData::where(['status' => 'Pending', 'employee_id' => $employee->employee_id])->first();
                if($payroll){
                    $payroll->salary += $employee->amount;
                    $base_salary = $employee->amount * $this->payroll->rate;
                    $payroll->base_salary += $base_salary;
                    // dd($payroll);
                    $payroll->update();                    
                    $employee->payroll_id = $payroll->id;
            }else{
                $payrollData = new FmsPayrollData();
                $payrollData->employee_id = $employee->employee_id;
                $payrollData->fms_payroll_id = $this->payroll->id;
                $payrollData->month = $employee->month;
                $payrollData->year = $employee->year;
                $payrollData->currency_id = $employee->currency_id;
                $payrollData->salary = $employee->amount;
                $payrollData->rate = $this->payroll->rate;
                $payrollData->base_salary = $employee->amount * $this->payroll->rate;
                // $payrollData->deductions = $employee->deductions;
                // $payrollData->employee_nssf = $employee->employee_nssf;
                // $payrollData->employer_nssf = $employee->employer_nssf;
                // $payrollData->other_deductions = $employee->other_deductions;
                // $payrollData->deduction_description = $employee->deduction_description;
                // $payrollData->net_salary = $employee->net_salary;
                $payrollData->request_id = $employee->id;
                $payrollData->save();
                $employee->payroll_id = $payrollData->id;
                }
                $employee->status = 'Pending Payment';
                $employee->update();

                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Employee salary submitted successfully!']);
            }
        });
    }
    public function removeEmployee($id)
    {
        DB::transaction(function () use ($id) {
            $payroll = FmsPayrollData::where(['status' => 'Pending', 'id' => $id])->first();
            if($payroll){
            $employee = FmsRequestEmployee::where(['status' => 'Pending Payment', 'payroll_id' => $payroll->id, 'employee_id' => $payroll->employee_id])
            ->update(['status' => 'Approved', 'payroll_id' => null]);
            $payroll->delete();
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Employee deleted successfully!']);
        }
        });
    }
    public function resetInputs()
    {
        $this->reset([
            'employee_id',
            'created_by',
            'updated_by',
            'status',
            'fms_payroll_id',
            'month',
            'year',
            'currency_id',
            'employee_id',
            'salary',
            'base_salary',
            'deductions',
            'employee_nssf',
            'employer_nssf',
            'other_deductions',
            'deduction_description',
            'net_salary',
            'request_id',
        ]);
    }
    public function render()
    {
        $data['currencies'] = FmsCurrency::where('is_active', 1)->get();
        $data['employees'] = FmsRequestEmployee::where(['status' => 'Approved', 'currency_id' => $this->payroll->currency_id])->with('employee', 'currency','requestable')->get();
        $data['payroll_employees'] = FmsPayrollData::where('fms_payroll_id', $this->payroll->id)->with('employee', 'currency')->get();
        return view('livewire.finance.payroll.fms-payroll-schedule-component', $data);
    }
}
