<?php

namespace App\Http\Controllers\HumanResource\Payroll;

use Carbon\Carbon;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\HumanResource\EmployeeData\Employee;
use App\Models\HumanResource\EmployeeData\BankingInformation;

class PayrollController extends Controller
{
    public function downloadPayslip($emp_id,$month,$prepared_by)
    {
        
        $data['employee'] = Employee::with(['designation','department','officialContract'])->where('id', $emp_id)->first();
        $data['bank_account'] = BankingInformation::where(['employee_id'=> $emp_id, 'is_default'=>1])->latest()->first();
        if(!$data['bank_account']){            
            $data['bank_account'] = BankingInformation::where('employee_id', $emp_id)->latest()->first();
        }
        $print_month= Carbon::parse($month)->format('F-Y');
        $month_date = Carbon::parse($month)->format('Y-m-d');
        $data['month_value'] = $month;
        $data['month'] = Carbon::today()->format('Y-m-d');
        $data['currency'] =$data['employee']->officialContract->currency??'N/A';
        $data['global'] = FmsCurrency::latest()->first();        
        // $data['approvaler']=Employee::where('id', $approver_id)->first();
        $data['prepper']=$prepared_by;
        return View('livewire.human-resource.payroll.templates.view-pay-slip-component', $data);
        $pdf = PDF::loadView('downloads.view-pay-slip-component', $data);
        $pdf->setPaper('a4', 'portrait');   //horizontal
        $pdf->getDOMPdf()->set_option('isPhpEnabled', true);

        return  $pdf->stream($data['employee']->surname.'.pdf');


        // return $pdf->download($testResult->sample->participant->identity.rand().'.pdf');
    }

    public function downloadProjectPayslip($contract_id,$currency,$month,$prepared_by)
    {
        $emp_id = null;
        $print_month= Carbon::parse($month)->format('F-Y');
        $month_date = Carbon::parse($month)->format('Y-m-d');
        $data['month_value'] = $month;
        $data['month'] = Carbon::today()->format('Y-m-d');
        $data['currency'] =$currency;
        $data['global'] = GeneralSetting::latest()->first();        
        // $data['approvaler']=Employee::where('id', $approver_id)->first();
        $data['prepper']=$prepared_by;
        $data['employee'] =$employee= ProjectContract::with('employee','project','position')->where('id', $contract_id)->where('start_date','<=', $month_date)->where('end_date','>=', $month_date)->first();
        if($employee){
            $emp_id=$employee->employee_id;
            $data['bank_account']= $bank_account = BankingInformation::where(['employee_id'=> $emp_id, 'is_default'=>1])->latest()->first();
            if(!$bank_account){            
                $data['bank_account'] = BankingInformation::where('employee_id', $emp_id)->latest()->first();
            }
            // return View('downloads.project-pay-slip', $data);
            $pdf = PDF::loadView('downloads.project-pay-slip',$data);
            $pdf->setPaper('a4', 'portrait');   //horizontal
            $pdf->getDOMPdf()->set_option('isPhpEnabled', true);

            return  $pdf->stream($employee->employee?->fullname.' '.$print_month.' Payslip.pdf');

         }else{
            return 'Sorry no employee contract record between that particular time period selected';
         }
        // hey u r ur  ru hrk ir irjj vn   ej  
        
    }
}
