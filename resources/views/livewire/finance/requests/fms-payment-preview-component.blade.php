<div>
    {{-- <style>
        .btop {
            border: solid 0.5px;
            border-color: #dcd9d9;
        }

        .b-top-row {
            border-top: solid 2px;
            border-top: double;
            border-color: #dcd9d9;
        }

        .b-bottom-row {
            border-bottom: solid 2px;
            border-bottom: double;
            border-bottom-right-radius: 22px;
            border-color: #dcd9d9;
        }

        .bleft {
            border-left: solid 0.5px;
            border-color: #dcd9d9;
        }

        .t-right {
            text-align: right;
        }

        .t-bold {
            font-weight: bold;
        }

        .twidth {
            width: 30%;
        }

        .txt-center {
            text-align: center;
            font-size: 22px;
            color: #f8f8f897;
        }
    </style> --}}
    <div class="card">
        <div class="card-body">

            @include('livewire.partials.brc-header')
            <hr>
                @include('livewire.finance.requests.inc.request-header')
            <hr>
            @if($request_data->request_type == 'Payment')
            <div class="details">

                <div class="header">
                    <h6>Details of the Request</h6>
                </div>


                <table class="b-top-row" style="border-collapse:collapse;" width="100%" cellspacing="0">
                    <tbody>
                        <tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes;height:15.75pt">
                            <td class="btop t-bold" width="149" rowspan="2" valign="top">
                                Description of expenditure
                            </td>
                            <td class="btop t-bold"  rowspan="2" valign="top">
                                More Details (IfAny)
                            </td>
                            <td class="btop t-bold" width="66" rowspan="2" valign="top">
                                Qty
                            </td>
                            <td class="btop t-bold text-center"  valign="top">
                                Amount (Currency)
                            </td>
                        </tr>
                        <tr style="mso-yfti-irow:1;height:11.25pt">
                            <td class="btop t-bold" width="113" valign="top">
                                Unit Cost ({{ $request_data->currency->code ?? 'N/A' }})
                            </td>
                            <td class="btop t-bold" width="121" valign="top">
                                Amount ({{ $request_data->currency->code ?? 'N/A' }})
                            </td>
                        </tr>
                        @forelse ($items as $item)
                            <tr>
                                <td class="btop" width="149">
                                    {{ $item->expenditure ?? 'N/A' }}
                                </td>
                                <td class="btop"  valign="top">
                                    {{ $item->description ?? 'N/A' }}
                                </td>
                                <td class="btop text-end" width="66" valign="top">
                                    {{ $item->quantity ?? '0' }}
                                </td>
                                <td class="btop text-end" width="113">
                                    @moneyFormat($item->unit_cost)
                                </td>
                                <td class="btop text-end" width="121">
                                    @moneyFormat($item->amount)
                                </td>
                            </tr>
                        @empty
                            <tr class="btop">
                                <td colspan="4" class="text-center text-danger">No entries yet</td>
                            </tr>
                        @endforelse

                        <tr>
                            <td class="btop t-bold" width="518" colspan="4" valign="top">
                                Total
                            </td>
                            <td class="btop t-bold text-end">
                                @moneyFormat($totalAmount)
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr>
            @endif
            @if($request_data->request_type == 'Salary')              
            <table class="b-top-row" style="border-collapse:collapse; " width="100%" cellspacing="0">
                <thead>                            
                    <tr>
                        <th class="btop t-bold"  valign="top">
                            Employee
                        </th>
                        <th class="btop t-bold" valign="top">
                            Month
                        </th>
                        <th class="btop t-bold"  valign="top">
                            Year
                        </th>
                        <th class="btop t-bold"  valign="top">
                            Status
                        </th>
                        <th class="btop t-bold text-center"  valign="top">
                            Amount
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($req_employees as $req_employee)
                        <tr>
                            <td class="btop" >
                                {{ $req_employee->employee->fullName ?? 'N/A' }}
                            </td>
                            <td class="btop"  valign="top">
                                {{ $req_employee->month ?? 'N/A' }}
                            </td>
                            <td class="btop"  valign="top">
                                {{ $req_employee->year ?? 'N/A' }}
                            </td>
                            <td class="btop"  valign="top">
                                 <span class="badge badge-outline-info">{{ $req_employee->status ?? 'N/A' }}</span>
                            </td>
                            <td class="btop text-end" width="121">
                                @moneyFormat($req_employee->amount)
                            </td>
                        </tr>
                    @empty
                        <tr class="btop">
                            <td colspan="5" class="text-center text-danger">No entries yet</td>
                        </tr>
                    @endforelse

                    <tr>
                        <td class="btop t-bold"  colspan="4" valign="top">
                            Total
                        </td>
                        <td class="btop t-bold text-end">
                            @moneyFormat($req_employees->sum('amount'))
                        </td>
                    </tr>
                </tbody>
            </table>
                <hr>
            @endif
            <div class="attachments">

                <div class="header">
                    <h6>Attachment Summary and References</h6>
                </div>
                <br>

                <table style="border-collapse:collapse;" width="100%" cellspacing="0">
                   <thead>
                        <tr class="b-top-row" style="mso-yfti-irow:0;mso-yfti-firstrow:yes;height:15.75pt">
                            <td class="btop t-bold" width="149" rowspan="2" valign="top">
                                Attachment Type/Name
                            </td>
                            <td class="btop t-bold"  rowspan="2" valign="top">
                                Reference Number (IfAny)
                            </td>
                            <td class="btop t-bold" width="66" rowspan="2" valign="top">
                                Action
                            </td>
                        </tr>
                   </thead>
                        <tbody>
                        @forelse ($attachments as $attachment)
                            <tr>
                                <td class="btop" width="149">
                                    {{ $attachment->name ?? 'N/A' }}
                                </td>
                                <td class="btop"  valign="top">
                                    {{ $attachment->reference ?? 'N/A' }}
                                </td>
                                <td class="btop" width="66" valign="top">
                                    @if ($attachment->file == null && $request_data->invoice_id)
                                    <a target="_blank" href="{{URL::signedRoute('finance-invoice_view', $attachment->reference)}}" class="action-ico  mx-1"><i class="fa fa-eye"></i></a>
                                    
                                @else                                        
                                <a href="javascriprt:void()" wire:click='downloadAttachment({{ $attachment->id }})'> <i class="fa fa-download"></i></a>
                                @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center text-danger">
                                <td colspan="3">No Attachments found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="Requestor Details ">

                <div class="header">
                    <h6>Requestor Details </h6>
                </div>
                <br>

                <table style="border-collapse:collapse;" width="100%" cellspacing="0">
                   <thead>
                        <tr class="b-top-row" style="mso-yfti-irow:0;mso-yfti-firstrow:yes;height:15.75pt">
                            <td class="btop t-bold" width="149"  valign="top">
                                Name
                            </td>
                            <td class="btop t-bold"   valign="top">
                                {{ $request_data->user?->employee?->fullName??'N/A' }}
                            </td>
                            <td class="btop t-bold" width="66"  valign="top">
                                Postion
                            </td>
                            <td class="btop t-bold"   valign="top">
                                {{ $request_data->user?->employee?->designation?->name??'N/A' }}
                            </td>
                        </tr>
                        <tr class="b-top-row" style="mso-yfti-irow:0;mso-yfti-firstrow:yes;height:15.75pt">
                            <td class="btop t-bold" width="149"  valign="top">
                                Signature
                            </td>
                            <td class="btop t-bold"   valign="top">
                                <img src="{{  asset('storage/' . $request_data->user?->signature)  }}"
                                    width="120px"  alt="">
                                    {{ $request_data->requester_signature??'N/A' }}
                            </td>
                            <td class="btop t-bold" width="66"  valign="top">
                                Date
                            </td>
                            <td class="btop t-bold"   valign="top">
                                {{ $request_data->date_submitted??'N/A' }}
                            </td>
                        </tr>
                        <tr class="b-top-row" style="mso-yfti-irow:0;mso-yfti-firstrow:yes;height:15.75pt">
                            <td class="btop t-bold" width="149"  valign="top">
                                Contact
                            </td>
                            <td class="btop t-bold"   valign="top">
                                {{ $request_data->user?->employee?->contact??'N/A' }}
                            </td>
                            <td class="btop t-bold" width="66"  valign="top">
                                Email
                            </td>
                            <td class="btop t-bold"   valign="top">
                                {{ $request_data->user?->email??'N/A' }}
                            </td>
                        </tr>
                   </thead>
                </table>
            </div>
            <hr>
            <div class="authorization">
                <h4>Authorization: </h4>
                <small><em>
                    For Control Purposes, Request Description has to be retyped here  
                </em></small>
               
                <table style="border-collapse:collapse;" width="100%" cellspacing="0">
                    <thead>
                        <tr class="b-top-row btop">
                            <td class="btop" width="158" valign="top" >
                                Request Description
                            </td>
                            <td class="btop" width="480" colspan="3" valign="top" >
                                {{ $request_data->request_description ?? 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="btop" width="158" valign="top" >
                                Position/Office
                            </td>
                            <td class="btop" width="198" valign="top" >
                                Name
                            </td>
                            <td class="btop" width="151" valign="top" >
                                Signature
                            </td>
                            <td class="btop" width="130" valign="top" >
                                Date
                            </td>
                            <td class="btop" width="10" valign="top" >
                                Action
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($authorizations as $authorizer)
                        <tr>
                            <td class="btop" width="158" valign="top">
                                {{ $authorizer->authPosition->name ?? 'N/A' }}
                            </td>
                            <td class="btop" width="198" valign="top">
                                {{ $authorizer->approver->employee->fullName ?? $authorizer->approver->name??'N/A' }}
                            </td>
                            <td class="btop" width="151" valign="top">
                                {{-- @if ($authorizer->signature)
                                    
                                <img src="{{  asset('storage/' . $authorizer->approver?->signature)  }}"
                                    width="120px"  alt="">
                                @endif --}}
                                <small>{{ $authorizer->signature ?? 'N/A' }}</small>
                            </td>
                            <td class="btop" width="130" valign="top">
                                {{ $authorizer->signature_date ?? 'N/A' }}
                            </td>
                            <td class="btop" width="66" valign="top" class="table-action">
                               @if ($authorizer->status =='Active' && $authorizer->approver_id == auth()->user()->id)
                               <div class="btn-group m-1" role="group" aria-label="Basic example">
                                    <button  data-bs-toggle="modal" data-bs-target="#approveRejectRequest-modal" type="button" title="Approve" class="btn btn-xs btn-outline-success" wire:click="$set('click_action','Signed')"><i class="far fa-check-circle"></i></button>
                                    <button data-bs-toggle="modal" data-bs-target="#approveRejectRequest-modal"  type="button" title="Decline" class="btn btn-xs btn-outline-danger" wire:click="$set('click_action','Declined')"><i class="fas fa-frown"></i></button>
                                </div> 
                               @else
                               
                               <x-status-badge :status="$authorizer->status ?? 'N/A' " />
                                @if ($authorizer->comments)
                                    
                                    <a href="javascript:void()" wire:click='viewComment("{{ $authorizer->comments }}")' data-bs-target="#viewComment" data-bs-toggle="modal"
                                       >
                                        <i class="fa fa-comments"></i>
                                    </a>
                                @endif
                               @endif
                                
                                
                            </td>

                        </tr>
                    @empty
                        <tr class="text-center text-danger">
                            <td colspan="3">No data found</td>
                        </tr>
                    @endforelse
                       
                    </tbody>
                </table>
                
                <i><span lang="EN-US" style="font-size:8.0pt;">
                All persons in the approval chain must satisfy that the content in the request form is complete, accurate &amp; serves value for money </span>
                </i>
                    <br>
            </div>
        </div>
        @if ($request_data->status =='Approved' && Auth::user()->hasPermission(['approve_transaction']) )
            <div class="card-footer d-grid">
                <button  data-bs-toggle="modal" data-bs-target="#markPaid" class="btn btn-success btn-xs">Process Request</button>
            </div>        
        @endif
        
        <div class="card-footer d-grid">
            <a href="javascript:window.print()" class="btn btn-de-info btn-sm">Print</a>
        </div>
        {{-- end of card body --}}
    </div>
    @include('livewire.finance.requests.inc.request-action-form')
    @include('livewire.finance.requests.inc.payement-ref')
    @include('livewire.finance.requests.inc.view-comment')
    @push('scripts')
            <script>
                window.addEventListener('close-modal', event => {
                    $('#approveRejectRequest-modal').modal('hide');
                    $('#markPaid').modal('hide');
                });
                window.addEventListener('delete-modal', event => {
                    $('#delete_modal').modal('show');
                });
            </script>
    @endpush
</div>
