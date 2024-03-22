<?php

namespace App\Http\Livewire\Finance\Payroll;

use App\Models\User;
use Livewire\Component;
use App\Services\GeneratorService;
use App\Models\Grants\Project\EmployeeProject;
use App\Models\Finance\Requests\FmsPaymentRequest;
use App\Models\Finance\Requests\FmsRequestEmployee;
use App\Models\HumanResource\EmployeeData\Employee;
use App\Services\Finance\Requests\FmsPaymentRequestService;
use App\Models\HumanResource\EmployeeData\OfficialContract\OfficialContract;

class FmsPayrollRequestDetailsComponent extends Component
{
    
    public $requestData;
    public $selectedEmployees = [];
    public $entry;
    public $requestCode;
    public $employees;
    public $signatories;

    public $employee_id;
    public $currency_id;
    public $month;
    public $year;
    public $amount;

    public $signatory_level;

    public $confirmingDelete = false;
    public $itemToRemove;
    public $totalAmount = 0;

   
    public function mount($code)
    {
        $this->requestCode = $code;
        $this->employees = collect([]);
        $this->signatories = collect([]);

        $requestData= FmsPaymentRequest::where('request_code', $this->requestCode)->with(['department', 'project', 'requestable', 'budgetLine'])->first();
        if( $requestData){
            $this->requestData = $requestData;
            if ($requestData->requestable_type == 'App\Models\HumanResource\Settings\Department') {
                $this->entry = 'Department';
               $this->employees = Employee::where('department_id', $requestData->requestable_id)->with('officialContract')->get();
                $this->selectedEmployees =$this->employees->pluck('id')->mapWithKeys(function ($employeeId) {
                    return [$employeeId => true];
                })->toArray();
                $this->signatories = User::where('is_active', 1)->where('employee_id', $requestData->requestable?->supervisor)->orWhere('employee_id', $requestData->requestable?->asst_supervisor)->get();
            } elseif ($requestData->requestable_type == 'App\Models\Grants\Project\Project') {
               $this->employees = EmployeeProject::where('project_id', $requestData->requestable_id)->with('employee')->get();
                $this->selectedEmployees =$this->employees->pluck('employee_id')->mapWithKeys(function ($employeeId) {
                    return [$employeeId => true];
                })->toArray();
                $this->entry = 'Project';
                $this->signatories = User::where('is_active', 1)->with('employee')->where('employee_id', $requestData->requestable?->pi)->orWhere('employee_id', $requestData->requestable?->co_pi)->get();
            } else {
               $this->employees = collect([]);
               $this->signatories = collect([]);
            }
            // dd($this->employees);
        }
    }

    public function generatePayroll()
    {
        // Process selected employees
        foreach ($this->selectedEmployees as $employeeId => $selected) {
            // dd($employeeId);
            if ($selected) {
                $employee = [];
                if($this->entry == 'Department'){
                    $employee = OfficialContract::where(['employee_id'=> $employeeId, 'status'=>1])->first();
                }elseif($this->entry == 'Project'){
                    $employee = EmployeeProject::where(['employee_id'=> $employeeId, 'status'=>'Running'])->first();
                }
                // dd($employee);s
                if($employee){
                    $record = FmsRequestEmployee::where(['employee_id' => $employee->employee_id, 'month' => $this->requestData->month,
                        'year' => $this->requestData->year, 'requestable_type' => $this->requestData->requestable_type, 'requestable_id' => $this->requestData->requestable_id])->first();
                        // dd($record);
                    if (!$record) {            
                        $requestEmployee = new FmsRequestEmployee();
                        $requestEmployee->request_id =  $this->requestData->id;
                        $requestEmployee->request_code = $this->requestData->requestCode;
                        $requestEmployee->employee_id = $employee->employee_id;
                        $requestEmployee->amount = $employee->gross_salary;
                        $requestEmployee->month = $this->requestData->month;
                        $requestEmployee->year =  $this->requestData->year;
                        $requestEmployee->currency_id = $this->requestData->currency_id;
                        $requestEmployee->requestable_type = $this->requestData->requestable_type;
                        $requestEmployee->requestable_id = $this->requestData->requestable_id;
                        $requestEmployee->contractable()->associate($employee); 
                        $requestEmployee->save();
                        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Added!']);

                    }else{
                        $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Exists failed!']);

                    }
                }
                
            }
        }
        // Reset selected employees after processing
        $this->selectedEmployees = [];

        session()->flash('success', 'Payroll generated successfully!');
    }
    public $selectedEmployee = null;
    public function updatedEmployeeId()
    {
        if ($this->employee_id) {
            $this->selectedEmployee = null;
            if ($this->entry == 'Project') {
                $this->selectedEmployee = EmployeeProject::where(['project_id' => $this->requestData->requestable_id, 'employee_id' => $this->employee_id])->with('employee')->first();
                $this->amount = $this->selectedEmployee->gross_salary ?? 0;
            } elseif ($this->entry == 'Department') {
                $this->selectedEmployee = OfficialContract::where('employee_id', $this->employee_id)->with('employee')->first();
                $this->amount = $this->selectedEmployee->gross_salary ?? 0;
            }
        }
    }
    public function saveEmployee($id)
    {
        $this->validate([
            'employee_id' => 'required',
            'month' => 'required',
            'year' => 'required',
            'amount' => 'required|numeric',
            'selectedEmployee' => 'required',
        ]);
        $record = FmsRequestEmployee::where(['employee_id' => $this->employee_id, 'month' => $this->month,
            'year' => $this->year, 'requestable_type' => $this->requestData->requestable_type, 'requestable_id' => $this->requestData->requestable_id])->first();
        if ($record) {

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Payment already exists!',
                'text' => 'Moths already paid or in queue',
            ]);
            return false;

        }
        $requestEmployee = new FmsRequestEmployee();
        $requestEmployee->request_id = $id;
        $requestEmployee->request_code = $this->requestCode;
        $requestEmployee->employee_id = $this->employee_id;
        $requestEmployee->month = $this->month;
        $requestEmployee->year = $this->year;
        $requestEmployee->currency_id = $this->requestData->currency_id;
        $requestEmployee->amount = $this->amount;
        $requestEmployee->requestable_type = $this->requestData->requestable_type;
        $requestEmployee->requestable_id = $this->requestData->requestable_id;
        $requestEmployee->contractable()->associate($this->selectedEmployee);       
        $requestEmployee->save();
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'request item created successfully!']);
    }
    function deleteRecord($id) {
        $requestEmployee = FmsRequestEmployee::where('id',$id)->first();
        $requestEmployee->delete();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'request item deleted successfully!']);
    }
    public function resetInputs()
    {
        $this->reset([
            'year',
            'month',
            'amount',
            'employee_id',
        ]);
    }
    
    public function submitRequest(){
        try{
            if($this->totalAmount && $this->totalAmount>0){
            $request= FmsPaymentRequest::where('request_code', $this->requestCode)->first();
            $request->total_amount = $this->totalAmount;
            $request->requester_signature = 'SN_' . GeneratorService::getNumber(8);
            $request->update();
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Transaction amount added! please proceed',]);
            return redirect()->SignedRoute('finance-request_detail', $request->request_code);
            }else{
                $this->dispatchBrowserEvent('swal:modal', [
                    'type' => 'warning',
                    'message' => 'Oops! Something went wrong!',
                    'text' => 'Amount must be greater than 0 ',
                ]);
            }
        } catch (\Exception $e) {
            // If the transaction fails, we handle the error and provide feedback
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Something went wrong!',
                'text' => 'Failed to save due to this error '.$e->getMessage(),
            ]);
        }
    }
    public function render()
    {
       $data['request_data'] = $this->requestData;
       $data['req_employees'] = FmsRequestEmployee::where('request_id', $this->requestData?->id)->with('employee')->get();
       $this->totalAmount = $data['req_employees']->sum('amount');
        return view('livewire.finance.payroll.fms-payroll-request-details-component', $data);
    }
}
