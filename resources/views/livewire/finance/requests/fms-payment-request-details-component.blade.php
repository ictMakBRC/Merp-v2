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
                    <h6>Details of the Request <span class="text-end float-end text-warning">Balance =
                            @moneyFormat($amountRemaining)</span></h6>
                </div>

                <form wire:submit.prevent="saveExpense({{ $request_data->id }})">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="expenditure">Expenditure Name:</label>
                            <input type="text" class="form-control" id="expenditure" wire:model="expenditure">
                            @error('expenditure')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="description">Description:</label>
                            <input type="text" id="description" required class="form-control"
                                wire:model="description">
                            @error('description')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="quantity">Quantity</label>
                            <input type="number" step='any' required class="form-control" wire:model="quantity">
                            @error('quantity')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="unit_cost">Unit Cost ({{ $request_data->currency->code ?? 'N/A' }}):</label>
                            <input type="number" required class="form-control" wire:model="unit_cost">
                            @error('unit_cost')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="amount">Total Cost ({{ $request_data->currency->code ?? 'N/A' }}):</label>
                            <input type="number" readonly max="{{ $amountRemaining }}" required class="form-control"
                                wire:model="amount">
                            @error('amount')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-2 pt-3 text-end">
                            <button class="btn btn-primary" type="submit">Save Item</button>
                        </div>
                    </div>
                </form>
                <br>

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
                    <h6>Attachment Summary and References <span class="text-end float-end text-warning">Total =
                            {{ $attachments->count() }}</span></h6>
                </div>

                <form wire:submit.prevent="saveAttachment({{ $request_data->id }})">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="name">Attachment Type/Name:</label>
                            <input type="text" class="form-control" id="expenditure" wire:model="name">
                            @error('name')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="v">Reference Number:</label>
                            <input type="text" id="reference" required class="form-control"
                                wire:model="reference">
                            @error('reference')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label for="file">File</label>
                            <input type="file" step='any' id="file_{{ $iteration }}" required class="form-control" wire:model="file">
                            @error('file')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-2 pt-3 text-end">
                            <button class="btn btn-primary" type="submit">Add</button>
                        </div>
                    </div>
                </form>
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
                                    <a href="javascriprt:void()" wire:click='deleteFile({{ $attachment->id }})'> <i class="fa fa-trash"></i></a>
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
                <form wire:submit.prevent='addSignatory({{ $request_data->id }})'>
                    <div class=" add-input">
                        <div class="row">
                            <div class="col-2 mb-1">
                                <div class="form-group">
                                    <label for="title" class="form-label">Level</label>
                                    <input readonly type="number"class="form-control" id="signatory_level" wire:model.lazy="signatory_level" placeholder="Enter level ">
                                    @error('signatory_level') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-1">
                                <div class="form-group">
                                    <label for="title" class="form-label">Position/Office
                                    @if ($position_exists)<small class="text-danger"> This position already exists on this document</small>@endif</label>
                                    <select name="position" class="form-control form-select" id="position" wire:model.lazy="position">
                                        <option value="">Select...</option>
                                        @forelse ($positions as $uposition)
                                            <option value="{{$uposition->id}}">{{$uposition->name}}</option>
                                        @empty
                                            <option value="">No info</option>
                                        @endforelse
                                    </select>
                                    @error('position') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-1">
                                <div class="form-group">
                                    <label for="title" class="form-label">Signatory</label>
                                    <select name="approver_id" class="form-control form-select" id="approver_id" wire:model.lazy="approver_id">
                                        <option value="">Select...</option>
                                        @forelse ($signatories as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @empty
                                            <option value="">No user</option>
                                        @endforelse
                                    </select>
                                    @error('approver_id') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-2 mt-2">
                                <button type="submit"  class="btn text-white btn-info float-end">Add</button>
                            </div>
                        </div>
                    </div>
                </form> 
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
                                <a href="javascriprt:void()" wire:click='deleteFile({{ $attachment->id }})'> <i class="fa fa-trash"></i></a>
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
        <div class="card-footer">
            @php
                $num = 4;
            @endphp
            @if ($request_data->requestable_type === 'App\Models\Grants\Project\Project') 
                @php $num = 5;@endphp
            @elseif ($request_data->requestable_type === 'App\Models\HumanResource\Settings\Department') 
                @php $num = 4;@endphp
            @endif

            @if (count($authorizations)<$num)
               <p class="text-danger">Please make sure you have attached all signatories</p>
               @endif
               @if($amountRemaining !=0)
               <p class="text-danger">Please make sure that the amount requested is equal  to the request details total amount </p>
                                
               @endif
               @if ($amountRemaining ==0 && count($authorizations)>=$num)
                   <button wire:click="submitRequest({{ $request_data->id }})" class="btn btn-success float-end">Submit Request</button>
               @endif
        </div>
    </div>
</div>
