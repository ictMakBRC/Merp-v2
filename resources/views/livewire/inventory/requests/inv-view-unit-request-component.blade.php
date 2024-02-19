<div>
    <x-general-view>
        <h4 class="text-center">INVENTORY ITEM REQUEST</h4>
        <div class="row invoice-info">
            <div class="col-sm-6 invoice-col">
                <strong>Request From</strong>
                <address>
                    <strong class="text-success">{{ $request_data->unitable->name }}</strong><br>
                    <strong>Date submitted: </strong>{{ $request_data->created_at }}<br>
                    <strong>Request type: </strong>{{ $request_data->request_type }}
                </address>
            </div>
            <!-- /.col -->
    
            <!-- /.col -->
            <div class="col-sm-6 invoice-col text-end">
                <b>Request State: </b>
                <x-status-badge :status="$request_data->status" />
                <b>Requested By: </b>{{ $request_data->createdBy->name }}<br>
                <b>Approved By: </b>{{ $request_data->createdBy->name }}<br>    
            </div>
            <!-- /.col -->
        </div>
        <div class="table-responsive">
            <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Item name</th>
                        <th>Description</th>
                        <th>UOM</th>
                        <th>Qty Requested</th>
                        <th>Qty Given</th>
                        @if (Auth::user()->hasPermission(['issue_item']) && $request_data->status=='Received')
                            <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if (count($request_items) > 0)
                        @php($i = 1)
                        @php($display = '')
                        @foreach ($request_items as $value)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $value->departmentItem->item->name ?? '' }}
                                </td>
                                <td>{{ $value->departmentItem->item->description }}</td>
                                <td>{{ $value->departmentItem->item->uom->name ?? 'N/A' }}</td>
                                <td>{{ $value->qty_requested }}</td>
                                <td>{{ $value->qty_given }}</td>
                                @if (Auth::user()->hasPermission(['issue_item']) && $request_data->status=='Received')
                                    <td>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#issueModal" wire:click="fetchBatches({{ $value->id }})"> <i class="fas fa-cart-plus"></i></a>
                                        @if ($value->qty_given < 1)
                                            @php($display = 'd-none')
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        @php($display = 'block')
                    @endif
                </tbody>
            </table>
        </div>
        @if ($request_data->status=='Received')            
            <button class="btn btn-sm btn-success {{ $display }}" wire:click='closeRequest'>Close Request</button>
        @endif
    </x-general-view>
    @include('livewire.inventory.requests.inc.request-action-form')
    
        
    @include('livewire.inventory.requests.inc.issue-stock-form')
    @push('scripts')
    <script>
      window.addEventListener('close-modal', event => {
        $('#actionModal').modal('hide');
        $('#delete_modal').modal('hide');
        $('#confirmDelete').modal('hide');
      });
      window.addEventListener('show-modal', event => {
        $('#actionModal').modal('show');
      });
      window.addEventListener('delete-modal', event => {
        $('#confirmDelete').modal('show');
      });
    </script>
    
    @endpush
</div>
