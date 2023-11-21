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
            @include('livewire.finance.requests.inc.request-header')
            @if($request_data->request_type == 'Payment')              
                @include('livewire.finance.requests.inc.req-payement-details')
                <hr>
            @endif
            @if($request_data->request_type == 'Salary')              
                @include('livewire.finance.requests.inc.req-salary-details')
                <hr>
            @endif
           
            @include('livewire.finance.requests.inc.req-attachments')
            <hr>
           @include('livewire.finance.requests.inc.req-auth-section')
        </div>
        {{-- end of card body --}}
        <div class="card-footer">
            @php
                $num = 5;
            @endphp
            @if ($request_data->requestable_type === 'App\Models\Grants\Project\Project') 
                @php 
                    if ($request_data->request_type == 'Internal Transfer') {                    
                        $num = 5;
                    } else {
                        $num = 6;
                    }                
                @endphp
            @elseif ($request_data->requestable_type === 'App\Models\HumanResource\Settings\Department') 
                @php 
                    if ($request_data->request_type == 'Internal Transfer') {                    
                        $num = 4;
                    } else {
                        $num = 5;
                    }    
                @endphp
            @endif

            @if (count($authorizations)<$num)
               <p class="text-danger">Please make sure you have attached all signatories</p>
               @endif
               @if($amountRemaining !=0 && $request_data->request_type == 'Payment')
               <p class="text-danger">Please make sure that the amount requested is equal  to the request details total amount </p>                                
               @endif  

               @if ($amountRemaining ==0 && count($authorizations)>=$num && $request_data->request_type == 'Payment')
                   <button wire:click="submitRequest({{ $request_data->id }})" class="btn btn-success float-end">Submit Request</button>
               @endif

               @if (count($req_employees)>0 && count($authorizations)>=$num && $request_data->request_type == 'Salary')
                    <button wire:click="submitRequest({{ $request_data->id }})" class="btn btn-success float-end">Submit Request</button>
               @endif

               @if(count($attachments)<=0 && $request_data->request_type == 'Internal Transfer')
               <p class="text-danger">Please make sure that you have atleast put one attachement or invoice </p>                                
               @endif          

               @if (count($attachments)>0 && count($authorizations)>=$num && $request_data->request_type == 'Internal Transfer')
                    <button wire:click="submitRequest({{ $request_data->id }})" class="btn btn-success float-end">Submit Request</button>
                @endif

                @if (count($authorizations)>0 && $request_data->request_type == 'Cash Imprest' || $request_data->request_type == 'Petty Cash')
                    <button wire:click="submitRequest({{ $request_data->id }})" class="btn btn-success float-end">Submit Request</button>
                @endif
        </div>
    </div>
    @include('livewire.partials.delete')
</div>
