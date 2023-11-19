<?php

namespace App\Http\Controllers\Finance;

use Carbon\Carbon;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Finance\Payroll\FmsPayrollData;
use App\Models\HumanResource\EmployeeData\BankingInformation;

class FinanceGeneralController extends Controller
{
    public function downloadPayslip($payroll_id)
    {
        
        $data['employee_data'] =$emp= FmsPayrollData::where('id', $payroll_id)->with('employee', 'currency','employee.designation','employee.department','employeeRequest','employeeRequest.requestable')->first();
        $data['bank_account'] = BankingInformation::where(['employee_id'=> $emp->employee_id, 'is_default'=>1])->latest()->first();
        if(!$data['bank_account']){            
            $data['bank_account'] = BankingInformation::where('employee_id', $emp->employee_id)->latest()->first();
        }     
        $data['month'] = $month = $emp->year.'-'.$emp->month;
        $print_month= Carbon::parse($month)->format('F-Y');
        $month_date = Carbon::parse($month)->format('Y-m-d');  
        // $data['approvaler']=Employee::where('id', $approver_id)->first();
        $data['prepper']= 'HR/Legal Office';
        return View('livewire.finance.payroll.view-pay-slip-component', $data);
        $pdf = PDF::loadView('downloads.view-pay-slip-component', $data);
        $pdf->setPaper('a4', 'portrait');   //horizontal
        $pdf->getDOMPdf()->set_option('isPhpEnabled', true);

        return  $pdf->stream($data['employee']->surname.'.pdf');


        // return $pdf->download($testResult->sample->participant->identity.rand().'.pdf');
    }
}
