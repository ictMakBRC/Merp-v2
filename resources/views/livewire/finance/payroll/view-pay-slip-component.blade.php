<style>
    .btop{
        border:solid 0.5px;
    }
    .brow{
        border:solid 1.4px;
    }
    .bleft{
        border-left:solid 0.5px;
    }
    .t-right{
        text-align: right;
    }
    .t-bold{
        font-weight: bold;
    }
    .twidth{
        width: 30%;
    }
    .txt-center{
        text-align: center;
        font-size: 22px;
        color: #f8f8f897;
    }
</style>
@include('livewire.partials.brc-header')
@php
$currency = $baseCurrency->code??'UGX';
@endphp
<table width="99%" style="border:solid 2px;border-collapse:collapse;margin-left:5.5566pt;border:solid;" cellspacing="0">
    <tr>
        <td class="btop t-bold">Payslip For</td>
        <td class="btop">{{ \Carbon\Carbon::parse($month)->format('M-y') }}</td>
        <td  class="btop" colspan="2">
            <table width="100%" style="border-collapse:collapse; border:solid 0px;">
                <tr class="btop">
                    <td class="btop t-bold twidth">
                    <p class="s2" style="text-indent: 0pt;text-align: left;">Name:</p>
                    </td>
                    <td class="btop ">
                        <p class="s3" style="padding-left: 1pt;text-indent: 0pt;text-align: left;">{{ $employee_data->employee->fullName }}</p>
                    </td>
                </tr>
                <tr class="btop">
                    <td class="btop t-bold twidth">
                        <p class="s2" style="text-indent: 0pt;text-align: left;">Position:</p>
                    </td>
                    <td class="btop">
                        <p class="s3" style="padding-left: 1pt;text-indent: 0pt;text-align: left;">{{ $employee_data->employee->designation?->name??'N/A' }}</p>
                    </td>
                </tr>
                <tr class="btop">                                            
                    <td class="btop t-bold twidth">
                        <p class="s2" style="padding-top: 1pt;padding-left: 1pt;text-indent: 0pt;text-align: left;">Unit:</p>
                    </td>
                    <td class="btop">
                        <p class="s3" style="padding-top: 1pt;padding-left: 1pt;text-indent: 0pt;text-align: left;">
                            {{ $employee_data->employee->department?->department_name??'N/A' }}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr class="brow t-bold">
        <td  class="btop" colspan="3">
            Details
        </td>
        <td  class="btop t-right">
            {{$currency}}
        </td>
    </tr>
    @if (count($employee_data->employeeRequest)>0)
    @foreach ($employee_data->employeeRequest as $empSalary)
        {{-- @if ($empSalary->requestable_type == 'App\Models\Grants\Project\Project') --}}
        <tr>
            <td colspan="3">
                {{ $empSalary->requestable?->name??'Unit'  }} For {{ $empSalary->month.'/'.$empSalary->year  }}
            </td>
            <td  class="bleft t-right">
               @php
                   $salaryBase = $employee_data->rate*$empSalary->amount;
               @endphp
                {{$currency}} @moneyFormat($salaryBase)
            </td>
        </tr>
        {{-- @else --}}
            
        {{-- @endif --}}
    @endforeach
        
    @endif
    <tr>
        <td colspan="3">
            Total Gross Salary  <br>
        </td>
        <td  class="bleft t-right">
           
            {{$currency}} @moneyFormat($employee_data->base_salary)
        </td>
    </tr>
    <tr>
        
        @php
        $paye = calculatePAYE($employee_data->base_salary);
    @endphp
        <td  class="btopp" colspan="3">  Less: Statutory Remittances PAYE (Flat Rate-{{getRate($employee_data->base_salary)*100}}%) <br>
        </td>
        <td  class="bleft t-right">
            -{{$currency}} @moneyFormat($paye)
        </td>
    </tr>
    <tr>
        <td  class="btobp" colspan="3">
            NSSF (5%)
        </td>
        <td  class="bleft t-right">
            @php
                $employeNssf = getEmployeeNssf($employee_data->base_salary);
            @endphp
            -{{$currency}} @moneyFormat($employeNssf) 
        </td>
    </tr>
    <tr class="brow t-bold">
        <td  class="btop" colspan="3">
            Net Payable
        </td>
        <td  class="btop t-right">
            @php
                $totalDeduction = $employeNssf + $paye;
                $netSalary = $employee_data->base_salary - $totalDeduction;
            @endphp
           {{$currency}} @moneyFormat($netSalary) 
            
        </td>
    </tr>
    <tr>
        <td colspan="2">Remittance Method:</td>
        <td colspan="2">Electonic Funds Transfer</td>
    </tr>
    {{-- <tr>
        <td colspan="2">Account Name:</td>
        <td colspan="2">{{$bank_account->account_name??'No bank data'}}</td>
    </tr> --}}
    <tr>
        <td colspan="2">Bank Name:</td>
        <td colspan="2">{{$bank_account->bank_name??'No bank data'}}</td>
    </tr>
    <tr>
        <td  colspan="2">Branch Name:</td>
        <td  colspan="2">{{$bank_account->branch??'No bank data'}} </td>
    </tr>
    <tr>
        <td  colspan="2">Account No:</td>
        <td  colspan="2">{{$bank_account->account_number??'No bank data'}}</td>
    </tr>
    <tr class="brow">
        <td colspan="2" class="btop">
            <strong> Received by:</strong> {{ $employee_data->employee?->fullName }}
        </td>
        <td colspan="2"  class="btop">
           <strong>Date:</strong> {{ \Carbon\Carbon::parse($month)->format('d-F-Y') }}
        </td>
    </tr>
   
    <tr>
        <td colspan="2" class="btop">
            <br>
            <br>
            <h1 class="txt-center">STAMP</h1>
            <br>
            <br>
        </td>
        <td colspan="2">
            <P><strong>Signature:</strong>................................................</P>
            <P><strong>Date:</strong> &nbsp;&nbsp; {{ \Carbon\Carbon::parse($month)->format('d-F-Y') }}</P>
        </td>
    </tr>
    <tr class="brow">
        <td colspan="4" class="btop">
            <strong>Issued by: </strong>
            @if ($prepper==0)
             Head Human Resources
            @else
             {{$prepper}}
            @endif
        </td>
        {{-- <td  class="btop">
            
        </td> --}}
        {{-- <td  class="btop t-bold">
            Date
        </td>
        <td  class="btop">
            {{ \Carbon\Carbon::parse($month)->format('d-F-Y') }}
        </td> --}}
    </tr>
</table>