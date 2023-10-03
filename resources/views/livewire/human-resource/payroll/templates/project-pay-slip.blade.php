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
    .table-container {
    background-image: url("images/logos/makbrcbg.png");
    background-repeat: no-repeat;
    background-size: 70%;
    background-position: center;
}
</style>
<table style="border-collapse:collapse;margin-left:5.5566pt" width="100%"  cellspacing="0">
    <tbody>
        <tr>
            <td style="width: 10%">
                <img src="{{ asset('images/logos/brc.png') }}" alt="MAk log" type="image/svg+xml" width="120px" alt="SVG Image">
            </td>
            <td class="text-center">
                <div class="w-100 overflow-hidde">
                    <p style="text-indent: 0pt;text-align: center;" class="t-bold"><a name="bookmark0">
                        {{ $facilityInfo?->facility_name }}</a></p>
                    <p style="text-align: center;">{{ $facilityInfo?->address2 }}
                        <span> || {{ $facilityInfo?->physical_address}}</span> <br>
                        <span><strong>Tel:</strong> {{ $facilityInfo?->contact }}
                            @if ($facilityInfo?->contact2)
                            /{{ $facilityInfo?->contact2 }}
                            @endif
                        </span>
                        ||
                        @if ($facilityInfo?->fax)
                            <span><strong>Fax:</strong> {{ $facilityInfo?->fax }}</span> <br>
                        @endif
                        @if ($facilityInfo?->email)
                            <span><strong>Email:</strong> {{ $facilityInfo?->email }}</span>
                        @endif
                        ||
                        @if ($facilityInfo?->website)
                        <span><strong>Web:</strong> {{ $facilityInfo?->website }}</span>
                        @endif
                    </p>
                </div>
            </td>
            <td style="width: 10%">                
                <img src="{{ asset('images/logos/mak.png') }}" alt="BRC logo" type="image/svg+xml" width="120px" alt="SVG Image">
            </td>
        </tr>
    </tbody>
</table>
<table width="99%" class="table-container" style="border:solid 2px;border-collapse:collapse;margin-left:5.5566pt;border:solid;" cellspacing="0">
    <tr>
        <td class="btop t-bold">Payslip For</td>
        <td class="btop">{{ \Carbon\Carbon::parse($month_value)->format('F-Y') }}</td>
        <td  class="btop" colspan="2">
            <table width="100%" style="border-collapse:collapse; border:solid 0px;">
                <tr >
                    <td class="btop t-bold twidth">
                    <p class="s2" style="text-indent: 0pt;text-align: left;">Name:</p>
                    </td>
                    <td class="btop ">
                        <p class="s3" style="padding-left: 1pt;text-indent: 0pt;text-align: left;">{{ $employee->employee?->fullName }}</p>
                    </td>
                </tr>
                <tr >
                    <td class="btop t-bold twidth">
                        <p class="s2" style="text-indent: 0pt;text-align: left;">Position:</p>
                    </td>
                    <td class="btop">
                        <p class="s3" style="padding-left: 1pt;text-indent: 0pt;text-align: left;">{{ $employee->position?->name??'N/A' }}</p>
                    </td>
                </tr>
                <tr class="btop">                                            
                    <td class="btop t-bold twidth">
                        <p class="s2" style="padding-top: 1pt;padding-left: 1pt;text-indent: 0pt;text-align: left;">Project:</p>
                    </td>
                    <td class="btop">
                        <p class="s3" style="padding-top: 1pt;padding-left: 1pt;text-indent: 0pt;text-align: left;">
                            {{ $employee->project?->department_name??'N/A' }}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr class="brow t-bold">
        <td  class="btop" colspan="3">
            Detials
        </td>
        <td  class="btop t-right">
            {{$currency}}
        </td>
    </tr>
    <tr>
        <td colspan="3">
            Basic Monthly Salary - Administration <br>
        </td>
        <td  class="bleft t-right">
       
        @php
               $salary = 0;
               $usd_rate = $global->usd_rate;
           if ($currency=='UGX')  {
               if ($employee?->currency =='USD') {
                   $salary =  $employee->gross_salary * $usd_rate;
                   }
               else {
                   $salary = $employee->gross_salary??'0';
               }
           }else{
                $salary = $employee?->gross_salary??'0';
           }
           @endphp
            {{$currency}} @moneyFormat($salary)
        </td>
    </tr>
    <tr>
        <td  class="btopp" colspan="3">  Less: Statutory Remittances PAYE (Flat Rate-{{$global->paye}}%) <br>
        </td>
        <td  class="bleft t-right">
            @php
            $paye =  $global->paye/100;
            $paye_deduct = $salary * $paye;
          @endphp
            -{{$currency}} @moneyFormat($paye_deduct)
        </td>
    </tr>
    <tr>
        <td  class="btobp" colspan="3">
           NSSF ({{$global->employee_nssf}}%)
        </td>
        <td  class="bleft t-right">
            @php
                $nssf =  $global->employee_nssf/100;
                $nssf_deduct = $salary * $nssf;
            @endphp
            -{{$currency}} @moneyFormat($nssf_deduct)
        </td>
    </tr>
    <tr>
        <td  class="btobp" colspan="3">
            NSSF ({{$global->employer_nssf}}%)
        </td>
        <td  class="bleft t-right">
            @php
                $enssf =  $global->employer_nssf/100;
                $enssf_deduct = $salary * $enssf;
            @endphp
            -{{$currency}} @moneyFormat($enssf_deduct)
        </td>
    </tr>
    <tr class="brow t-bold">
        <td  class="btop" colspan="3">
            Net Payable
        </td>
        <td  class="btop t-right">
            @php
                $net_deduct = $nssf_deduct+$paye_deduct+$enssf_deduct;
                $net_pay = $salary-$net_deduct;
            @endphp
            {{$currency}} @moneyFormat($net_pay)
        </td>
    </tr>
     {{-- <tr>
        <td colspan="2">Remittance Method:</td>
        <td colspan="2">Electonic Funds Transfer</td>
    </tr> --}}
    <tr>
        <td colspan="2">Account Name:</td>
        <td colspan="2">{{$bank_account->account_name??'No bank data'}}</td>
    </tr>
    <tr>
        <td colspan="2">Bank Name:</td>
        <td colspan="2">{{$bank_account->bank_name??'No bank data'}}</td>
    </tr>
    {{-- <tr>
        <td  colspan="2">Branch Name:</td>
        <td  colspan="2">{{$bank_account->branch??'No bank data'}} </td>
    </tr> --}}
    <tr>
        <td  colspan="2">Account No:</td>
        <td  colspan="2">{{$bank_account->account_number??'No bank data'}}</td>
    </tr> 
    {{-- <tr class="brow">
        <td  class="btop t-bold">
            Prepared by:
        </td>
        <td  class="btop">
            {{$prepper->fullname??'Nalwadda Geraldine'}}
        </td>
        <td  class="btop t-bold">
            Date
        </td>
        <td  class="btop">
            {{ \Carbon\Carbon::parse($month)->format('d-M-Y') }}
        </td>
    </tr> --}}
    
    <tr class="brow">
        <td colspan="2" class="btop">
            <strong> Received by:</strong> {{ $employee->employee?->fullName }}
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

