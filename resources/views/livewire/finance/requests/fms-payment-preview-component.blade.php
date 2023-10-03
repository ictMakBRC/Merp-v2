<div>
    <style>
        .btop {
            border: solid 0.5px;
        }

        .b-top-row {
            border-top: solid 2px;
            border-top: double;
        }

        .b-bottom-row {
            border-bottom: solid 2px;
            border-bottom: double;
            border-bottom-right-radius: 22px;
        }

        .bleft {
            border-left: solid 0.5px;
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
    </style>
    <div class="card">
        <div class="card-body">

            @include('livewire.partials.brc-header')
            <hr>
            <h3 class="text-center">{{ $request_data->request_type ?? 'REQUEST' }}</h3>
            <table style="border-collapse:collapse;" width="100%" cellspacing="0">
                <tbody>
                    <tr class="b-top-row">
                        <td class="btop t-bold twidth">
                            Unit/Project/Acronym
                        </td>
                        <td class="btop" valign="top">
                            @if ($request_data->requestable)
                                {{ $request_data->requestable->name ?? 'N/A' }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="btop t-bold twidth">
                            Request Description
                        </td>
                        <td class="btop" valign="top">
                            {{ $request_data->request_description ?? 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="btop t-bold twidth">
                            Budget Line to charge
                        </td>
                        <td class="btop" valign="top">
                            {{ $request_data->budgetLine->name ?? 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="btop t-bold twidth">
                            Total Amount Requested in Figures ({{ $request_data->currency->code ?? 'N/A' }})
                        </td>
                        <td class="btop" valign="top">
                            @moneyFormat($request_data->total_amount ?? '0')
                        </td>
                    </tr>
                    <tr class="b-bottom-row">
                        <td class="btop t-bold twidth">
                            Total Amount Requested in Words
                        </td>
                        <td class="btop" valign="top">
                            {{ $request_data->amount_in_words ?? 'N/A' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr>
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
                            <td class="btop t-bold" width="189" rowspan="2" valign="top">
                                More Details (IfAny)
                            </td>
                            <td class="btop t-bold" width="66" rowspan="2" valign="top">
                                Qty
                            </td>
                            <td class="btop t-bold text-center" width="234" colspan="2" valign="top">
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
                                <td class="btop" width="189" valign="top">
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
                            <td class="btop t-bold" width="189" rowspan="2" valign="top">
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
                                <td class="btop" width="189" valign="top">
                                    {{ $attachment->reference ?? 'N/A' }}
                                </td>
                                <td class="btop" width="66" valign="top">
                                    <a href="javascriprt:void()" wire:click='downloadAttachment({{ $attachment->id }})'> <i class="fa fa-download"></i></a>
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
                                Renewal of Ethics Approval fees
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
                
                            </td>
                            <td class="btop" width="130" valign="top">
                
                            </td>
                            <td class="btop" width="66" valign="top">
                               @if ($authorizer->status =='Active')
                               <a href="javascriprt:void()" wire:click='approve({{ $authorizer->id }})'> <i class="fa fa-check"></i>Approve</a>
                               @else
                                   Pending
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
        {{-- end of card body --}}
    </div>
</div>
