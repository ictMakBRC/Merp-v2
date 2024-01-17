<?php

namespace App\Http\Livewire\Finance\Payroll;

use App\Models\Finance\Payroll\FmsPayroll;
use App\Models\Finance\Payroll\FmsPayrollRates;
use App\Models\Finance\Payroll\FmsPayrollSchedule;
use App\Models\Finance\Requests\FmsRequestEmployee;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsCurrencyUpdate;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class FmsGeneratePayrollComponent extends Component
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
    public $currency_id;
    public $rate;
    public $employee_id;
    public $payroll_data_id;
    public $payroll_employee_data;
    public $payment_ref;
    public $payment_date;
    public $pay;
    public $active_currency;

    public function mount($voucher)
    {
        $this->voucher = $voucher;
        $this->payroll = FmsPayroll::where('payment_voucher', $voucher)->with('currency')->first();

    }
    public function close()
    {
        $this->resetInputs();
    }
    public function createPayrollRate()
    {
        $this->validate([
            'currency_id' => 'required',
            'rate' => 'required',
        ]);
        $record = FmsPayrollRates::where(['payroll_id' => $this->payroll->id, 'currency_id' => $this->currency_id])->first();
        if ($record) {

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! payroll already exists!',
                'text' => 'Months already paid or in queue',
            ]);
            return false;

        }
        $payroll = new FmsPayrollRates();
        $payroll->payroll_id = $this->payroll->id;
        $payroll->currency_id = $this->currency_id;
        $payroll->rate = $this->rate;
        $payroll->save();
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Payroll created successfully!']);
    }

    public function updatedCurrencyId()
    {
        if ($this->currency_id) {
            $latestRate = FmsCurrencyUpdate::where('currency_id', $this->currency_id)->latest()->first();

            if ($latestRate) {
                $this->rate = $latestRate->exchange_rate;
            }
        }
    }

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
    public $rateData;
    public function markAsPaid($id, $type)
    {
        $this->pay = $type;
        if ($type == 'Single') {
            $this->payroll_employee_data = FmsPayrollSchedule::where(['id' => $id])->with('employee')->first();
        } elseif ($type == 'PayrollRate') {
            $this->rateData = FmsPayrollRates::where('id', $id)->first();
        } elseif ($type == 'Payroll') {

        }
    }
    public function savePaymentRecord()
    {
        $this->validate([
            'payment_date' => 'required|date',
            'payment_ref' => 'required',
        ]);

        if ($this->pay == 'Single' && $this->payroll_employee_data) {
            DB::transaction(function () {
                $data = FmsPayrollSchedule::where(['id' => $this->payroll_employee_data->id])->first();
                if ($data) {
                    $employees = FmsRequestEmployee::where(['schedule_id' => $data->id, 'employee_id' => $data->employee_id, 'currency_id' => $data->currency_id, 'status' => 'Pending Payment'])
                        ->update(['status' => 'Paid']);
                    $data->status = 'Paid';
                    $data->payment_ref = $this->payment_ref;
                    $data->payment_date = $this->payment_date;
                    $data->update();
                    $this->resetInputs();
                    $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Employee salary has been successfully marked as paid!']);
                }
            });
        } elseif ($this->pay == 'PayrollRate' && $this->rateData) {
            DB::transaction(function () {
                $rateData = FmsPayrollRates::where('id', $this->rateData->id)->first();
                if ($rateData) {
                    $payrollRecords = FmsPayrollSchedule::where(['payroll_rate_id' => $this->rateData->id, 'status' => 'Pending'])->get();
                    foreach ($payrollRecords as $payrollRecord) {
                        $data = FmsPayrollSchedule::where(['id' => $payrollRecord->id])->first();
                        if ($data) {
                            $employees = FmsRequestEmployee::where(['schedule_id' => $data->id, 'employee_id' => $data->employee_id, 'currency_id' => $data->currency_id, 'status' => 'Pending Payment'])
                                ->update(['status' => 'Paid']);
                            $data->status = 'Paid';
                            $data->payment_ref = $this->payment_ref;
                            $data->payment_date = $this->payment_date;
                            $data->update();
                            $this->resetInputs();
                            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Employee salary has been successfully marked as paid!']);
                        }
                    }
                }

            });
        } elseif ($this->pay == 'Payroll') {

        }
    }
    public function addEmployee($rate_id, $employee_id)
    {
        DB::transaction(function () use ($rate_id, $employee_id) {
            $payroll_rate = FmsPayrollRates::where('id', $rate_id)->first();
            $employee = FmsRequestEmployee::where(['status' => 'Approved', 'id' => $employee_id])->first();
            // dd($employee);
            if ($employee) {                
                $base_salary = $employee->amount * $payroll_rate->rate;
                $payrollDataExists = FmsPayrollSchedule::where(['status' => 'Pending', 'payroll_rate_id' => $payroll_rate->id, 'employee_id' => $employee->employee_id])->first();                
                $worker_nssf = getEmployeeNssf($base_salary);
                $emp_nssf = getEmployeerNssf($base_salary);
                $paye = calculatePAYE($base_salary);
                $deductions = $worker_nssf + $paye;
                $net_salary = $base_salary - $deductions;
                if ($payrollDataExists) {
                    $payrollDataExists->salary += $employee->amount;
                    $payrollDataExists->base_salary += $base_salary;
                    $payrollDataExists->worker_nssf += $worker_nssf;
                    $payrollDataExists->paye += $paye;
                    $payrollDataExists->emp_nssf += $emp_nssf;
                    $payrollDataExists->deductions +=  $deductions;
                    $payrollDataExists->net_salary += $net_salary;
                    $payrollDataExists->update();
                    $employee->schedule_id = $payrollDataExists->id;
                } else {
                    $payrollData = new FmsPayrollSchedule();
                    $payrollData->employee_id = $employee->employee_id;
                    $payrollData->payroll_rate_id = $payroll_rate->id;
                    $payrollData->fms_payroll_id = $payroll_rate->payroll_id;
                    $payrollData->currency_id = $employee->currency_id;
                    $payrollData->salary = $employee->amount;
                    $payrollData->rate = $payroll_rate->rate;
                    $payrollData->base_salary = $base_salary;
                    $payrollData->worker_nssf = $worker_nssf;
                    $payrollData->paye = $paye;
                    $payrollData->emp_nssf = $emp_nssf;
                    $payrollData->deductions =  $deductions;
                    $payrollData->net_salary = $net_salary;
                    $payrollData->bonuses =0;
                    // $payrollData->request_id = $employee->id;
                // dd($payrollData);
                $payrollData->save();
                    $employee->schedule_id = $payrollData->id;
                }
                $employee->worker_nssf =  $worker_nssf/$payroll_rate->rate;
                $employee->emp_nssf = $emp_nssf/$payroll_rate->rate;
                $employee->deductions = $deductions;
                $employee->paye_rate = getRate($base_salary);
                $employee->net_salary = $net_salary/$payroll_rate->rate;
                $employee->status = 'Pending Payment';
                $employee->update();

                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Employee salary submitted successfully!']);
            }
        });
    }
    public function addAllEmployees($rate_id)
    {
        DB::transaction(function () use ($rate_id) {
            $payroll_rate = FmsPayrollRates::where('id', $rate_id)->first();
            // dd($payroll_rate);
            $employees = $this->mainEmpQuery()->where(['status' => 'Approved', 'currency_id' => $payroll_rate->currency_id])->get();
            // dd($employees);
            foreach ($employees as $requestEmployee) {
                $employee = FmsRequestEmployee::where(['status' => 'Approved', 'employee_id' => $requestEmployee->employee_id])->first();
                if ($employee) {                    
                    $base_salary = $employee->amount * $payroll_rate->rate;
                    $worker_nssf = getEmployeeNssf($base_salary);
                    $emp_nssf = getEmployeerNssf($base_salary);
                    $paye = calculatePAYE($base_salary);
                    $deductions = $emp_nssf + $paye;
                    $net_salary = $base_salary - $deductions;
                    $payrollDataExists = FmsPayrollSchedule::where(['status' => 'Pending', 'payroll_rate_id' => $payroll_rate->id, 'employee_id' => $employee->employee_id])->first();
                    if ($payrollDataExists) {
                        $payrollDataExists->salary += $employee->amount;
                        $payrollDataExists->base_salary += $base_salary;
                        $payrollDataExists->worker_nssf += $worker_nssf;
                        $payrollDataExists->paye += $paye;
                        $payrollDataExists->emp_nssf += $emp_nssf;
                        $payrollDataExists->deductions +=  $deductions;
                        $payrollDataExists->net_salary += $net_salary;
                        $payrollDataExists->update();
                        $employee->schedule_id = $payrollDataExists->id; 
                        $employee->worker_nssf =  $worker_nssf/$payroll_rate->rate;
                        $employee->emp_nssf = $emp_nssf/$payroll_rate->rate;
                        $employee->deductions = $deductions/$payroll_rate->rate;
                        $employee->paye_rate = getRate($base_salary);
                        $employee->net_salary = $net_salary/$payroll_rate->rate;
                        $employee->status = 'Pending Payment';
                        $employee->update();  
                    } else {
                        $base_salary = $employee->amount * $payroll_rate->rate;
                        $payrollData = new FmsPayrollSchedule();
                        $payrollData->employee_id = $employee->employee_id;
                        $payrollData->payroll_rate_id = $payroll_rate->id;
                        $payrollData->fms_payroll_id = $payroll_rate->payroll_id;
                        $payrollData->currency_id = $employee->currency_id;
                        $payrollData->salary = $employee->amount;
                        $payrollData->rate = $payroll_rate->rate;
                        $payrollData->base_salary = $base_salary;
                        $payrollData->worker_nssf = $worker_nssf;
                        $payrollData->paye = $paye;
                        $payrollData->emp_nssf = $emp_nssf;
                        $payrollData->deductions =  $deductions;
                        $payrollData->net_salary = $net_salary;
                        $payrollData->bonuses =0;
                        $payrollData->save();
                        $employee->schedule_id = $payrollData->id;
                        // $employee->payroll_id = $this->payroll->id;
                        $employee->worker_nssf =  $worker_nssf/$payroll_rate->rate;
                        $employee->emp_nssf = $emp_nssf/$payroll_rate->rate;
                        $employee->deductions = $deductions;
                        $employee->paye_rate = getRate($base_salary);
                        $employee->net_salary = $net_salary/$payroll_rate->rate;
                        $employee->status = 'Pending Payment';
                        $employee->update();
                        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Employee salary submitted successfully!']);
                    }

                }
            }
        });
    }
    public function removeEmployee($id)
    {
        DB::transaction(function () use ($id) {
            // Retrieve the payroll schedule with 'Pending' status and the given $id
            $payroll = FmsPayrollSchedule::where(['status' => 'Pending', 'id' => $id])->first();        
            // Check if a matching payroll schedule was found
            if ($payroll) {
                // Update records in the FmsRequestEmployee table
                $employee = FmsRequestEmployee::where([
                    'status' => 'Pending Payment',
                    'schedule_id' => $payroll->id,
                    'employee_id' => $payroll->employee_id
                ])->update([
                    'status' => 'Approved',
                    'payroll_id' => null,
                    'schedule_id' => null,
                    'net_salary' => 0,
                    'paye_rate' => 0,
                    'deductions' => 0,
                    'emp_nssf' => 0,
                    'worker_nssf' => 0
                ]);
        
                // Delete the payroll schedule
                $payroll->delete();
        
                // Dispatch a browser event to show a success alert
                $this->dispatchBrowserEvent('alert', [
                    'type' => 'success',
                    'message' => 'Employee deleted successfully!'
                ]);
            }
        });
        

        
    }
    public function resetInputs()
    {
        $this->reset([
            'employee_id',
            'currency_id',
            'rate',
            'payment_date',
            'payment_ref',
        ]);
        $this->dispatchBrowserEvent('close-modal');
    }
    function updatedActiveCurrency() {
        $this->unit_id = 0;
        $this->unit_type = 0;
        $this->mainEmpQuery();
    }
    public $unit_id, $unit_type;
    public function setUnit($id, $type)
    {
        $this->unit_id = $id;
        $this->unit_type = $type;
        $this->mainEmpQuery();
        // dd($this->unit_type);
    }
    public function markPayrollComplete()
    {
        $payroll = FmsPayroll::where('id', $this->payroll->id)->update(['status' => 'Completed']);
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Payroll completed successfully!']);
    }
    public function mainEmpQuery()
    {
        if($this->unit_type && $this->unit_id){
            $employees = FmsRequestEmployee::where(['status' => 'Approved','currency_id'=>$this->active_currency])->with('employee', 'currency', 'requestable')->where(['requestable_type' => $this->unit_type, 'requestable_id' => $this->unit_id]);
        }else{
            $employees = FmsRequestEmployee::where(['status' => 'Approved','currency_id'=>$this->active_currency])->with('employee', 'currency', 'requestable');
        }
        return $employees;
    }
    public function render()
    {
        $data['currencies'] = FmsCurrency::where('is_active', 1)->get();
        $data['payroll_rates'] = FmsPayrollRates::where(['payroll_id'=> $this->payroll->id])->with('currency')->get();
        $data['employees'] = $this->mainEmpQuery()->get();
        
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $data['unit_groups'] = FmsRequestEmployee::select('status', 'currency_id', 'requestable_type', 'requestable_id', DB::raw('count(*) as submission_count'), DB::raw('SUM(amount) as total_amount'))
            ->groupBy('requestable_type', 'requestable_id', 'currency_id')->where(['status'=> 'Approved', 'currency_id'=>$this->active_currency])->with('requestable')->get();
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        $data['payroll_employees'] = FmsPayrollSchedule::where(['fms_payroll_id'=> $this->payroll->id, 'currency_id'=>$this->active_currency])->with('employee', 'currency')->get();

        return view('livewire.finance.payroll.fms-generate-payroll-component', $data);
    }
}
