<?php

namespace App\Http\Livewire\Finance\Payroll;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\Finance\Payroll\FmsPayroll;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Payroll\FmsPayrollData;
use App\Models\Finance\Payroll\FmsPayrollRates;
use App\Models\Finance\Settings\FmsCurrencyUpdate;
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
    public $currency_id;
    public $rate;
    public $employee_id;
    public $payroll_data_id;
    public $payroll_employee_data;
    public $payment_ref;
    public $payment_date;
    public $pay;

    
    public function mount($voucher)
    {
        $this->voucher = $voucher;
        $this->payroll = FmsPayroll::where('payment_voucher', $voucher)->with('currency')->first();

    }
    function close(){
        $this->resetInputs(); 
    }
    public function createPayrollRate()
    {
        $this->validate([
            'currency_id'=>'required',
            'rate'=>'required'
        ]);
        $record = FmsPayrollRates::where([ 'payroll_id' => $this->payroll->id, 'currency_id'=>$this->currency_id])->first();
        if($record){

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
    public function addEmployee($rate_id, $employee_id)
    {
        DB::transaction(function () use ($rate_id, $employee_id) {
            $payroll_rate = FmsPayrollRates::where('id', $rate_id)->first();
            $employee = FmsRequestEmployee::where(['status' => 'Approved', 'id' => $employee_id])->first();            
            // dd($employee);
            if ($employee) {
                $payrollDataExists = FmsPayrollData::where(['status' => 'Pending', 'payroll_rate_id'=>$payroll_rate->id,'employee_id' => $employee->employee_id])->first();
                if($payrollDataExists){
                    $payrollDataExists->salary += $employee->amount;
                    $base_salary = $employee->amount * $payroll_rate->rate;
                    $payrollDataExists->base_salary += $base_salary;
                    // dd($payroll);
                    $payrollDataExists->update();                    
                    $employee->payroll_id = $payrollDataExists->id;
            }else{
                $payrollData = new FmsPayrollData();
                $payrollData->employee_id = $employee->employee_id;
                $payrollData->payroll_rate_id = $payroll_rate->id;
                $payrollData->fms_payroll_id = $payroll_rate->payroll_id;
                $payrollData->month = $employee->month;
                $payrollData->year = $employee->year;
                $payrollData->currency_id = $employee->currency_id;
                $payrollData->salary = $employee->amount;
                $payrollData->rate = $payroll_rate->rate;
                $payrollData->base_salary = $employee->amount * $payroll_rate->rate;;
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
    public $rateData;
    function markAsPaid($id, $type) {
        $this->pay = $type;
        if($type=='Single'){
            $this->payroll_employee_data = FmsPayrollData::where(['id' => $id])->with('employee')->first();
        }elseif($type =='PayrollRate'){
            $this->rateData  = FmsPayrollRates::where('id', $id)->first();
        }elseif($type =='Payroll'){

        }
    }
    function savePaymentRecord() {
        $this->validate([
            'payment_date'=>'required|date',
            'payment_ref'=>'required',
        ]);

        if($this->pay=='Single' && $this->payroll_employee_data){
            DB::transaction(function ()  {
            $data = FmsPayrollData::where(['id' => $this->payroll_employee_data->id])->first();
            if($data){
                $employees = FmsRequestEmployee::where(['payroll_id' => $data->id, 'employee_id' => $data->employee_id, 'currency_id' => $data->currency_id,'status'=>'Pending Payment'])
                ->update(['status'=>'Paid']);  
                $data->status = 'Paid';
                $data->payment_ref = $this->payment_ref;
                $data->payment_date = $this->payment_date;
                $data->update();
                $this->resetInputs(); 
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Employee salary has been successfully marked as paid!']);
            }
        });
        }elseif($this->pay =='PayrollRate' && $this->rateData){
            DB::transaction(function ()  {
                $rateData  = FmsPayrollRates::where('id', $this->rateData->id)->first();
                if($rateData){
                    $payrollRecords = FmsPayrollData::where(['payroll_rate_id' => $this->rateData->id,'status'=>'Pending'])->get();
                    foreach($payrollRecords as $payrollRecord){
                        $data = FmsPayrollData::where(['id' => $payrollRecord->id])->first();
                        if($data){
                            $employees = FmsRequestEmployee::where(['payroll_id' => $data->id, 'employee_id' => $data->employee_id, 'currency_id' => $data->currency_id,'status'=>'Pending Payment'])
                            ->update(['status'=>'Paid']);  
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
        }elseif($this->pay =='Payroll'){

        }
    }
    public function addAllEmployees($rate_id)
    {
        DB::transaction(function () use ($rate_id) {
            $payroll_rate = FmsPayrollRates::where('id', $rate_id)->first();
            $employees = FmsRequestEmployee::where(['status' => 'Approved', 'currency_id' => $payroll_rate->currency_id])->get();            
            // dd($employees);
            foreach($employees as $requestEmployee){
                $employee = FmsRequestEmployee::where(['status' => 'Approved', 'employee_id' => $requestEmployee->employee_id])->first();
                if ($employee) {
                    $payrollDataExists = FmsPayrollData::where(['status' => 'Pending', 'payroll_rate_id'=>$payroll_rate->id,'employee_id' => $employee->employee_id])->first();
                    if($payrollDataExists){
                        $payrollDataExists->salary += $employee->amount;
                        $base_salary = $employee->amount * $payroll_rate->rate;
                        $payrollDataExists->base_salary += $base_salary;
                        $payrollDataExists->update();                    
                        $employee->payroll_id = $payrollDataExists->id;                        
                        $employee->status = 'Pending Payment';
                        $employee->update();
                    }else{
                    $payrollData = new FmsPayrollData();
                    $payrollData->employee_id = $employee->employee_id;
                    $payrollData->payroll_rate_id = $payroll_rate->id;
                    $payrollData->fms_payroll_id = $payroll_rate->payroll_id;
                    $payrollData->month = $employee->month;
                    $payrollData->year = $employee->year;
                    $payrollData->currency_id = $employee->currency_id;
                    $payrollData->salary = $employee->amount;
                    $payrollData->rate = $payroll_rate->rate;
                    $payrollData->base_salary = $employee->amount * $payroll_rate->rate;
                    $payrollData->request_id = $employee->id;
                    $payrollData->save();
                    $employee->payroll_id = $payrollData->id;                    
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
            'currency_id',
            'rate',
            'payment_date',
            'payment_ref',
        ]);
        $this->dispatchBrowserEvent('close-modal');
    }
    public $unit_id, $unit_type;
    function setUnit($id, $type) {
        $this->unit_id = $id;
        $this->unit_type = $type;
        dd($this->unit_type);
    }
    function markPayrollComplete() {
        $payroll = FmsPayroll::where('id', $this->payroll->id)->update(['status'=>'Completed']);
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Payroll completed successfully!']);
    }
    public function render()
    {
        $data['currencies'] = FmsCurrency::where('is_active', 1)->get();
        $data['payroll_rates'] = FmsPayrollRates::where('payroll_id', $this->payroll->id)->with('currency')->get();
        $data['employees'] = FmsRequestEmployee::where(['status' => 'Approved'])->with('employee', 'currency','requestable')
        ->when($this->unit_type != '' && $this->unit_id != '', function ($query) {
            $query->where(['requestable_type'=>$this->unit_type, 'requestable_id'=>$this->unit_id]);
        }, function ($query) {
            return $query;
        })->get();
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $data['unit_groups'] = FmsRequestEmployee::select('status','currency_id','requestable_type', 'requestable_id', DB::raw('count(*) as submission_count'), DB::raw('SUM(amount) as total_amount'))
        ->groupBy('requestable_type', 'requestable_id','currency_id')->where('status','Approved')->with('requestable')->get();
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        $data['payroll_employees'] = FmsPayrollData::where('fms_payroll_id', $this->payroll->id)->with('employee', 'currency')->get();
        return view('livewire.finance.payroll.fms-payroll-schedule-component', $data);
    }
}
