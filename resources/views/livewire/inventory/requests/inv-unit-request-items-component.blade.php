<div>
    
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
            <td><x-status-badge :status="$request_data->status" /></td>
            <br>
            <b>Requested By: </b>{{ $request_data->createdBy->name }}<br>

        </div>
        <!-- /.col -->
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">

                    <form wire:submit.prevent="addItem()" name="myForm" class="needs-validation">
                        @csrf
                        <div class="row mb-2 mt-3">

                            <input type="hidden" class="form-control" name="inv_requests_id" wire:model='inv_requests_id'
                                readonly>

                            <input type="hidden" class="form-control" name="request_code" wire:model='request_code'
                                readonly value="{{ $request_code }}">
                            <div class="col-sm-5">
                                <div class="text-sm">
                                    <label>Item</label>
                                    <select class="form-control " name="inv_item_id" wire:model.lazy="inv_item_id"
                                        id="item" required>
                                        <option value="">Select item</option>
                                        @foreach ($items as $dptitem)
                                            <option value="{{ $dptitem->id }}">
                                                {{ $dptitem?->item->name . '  (' . $dptitem?->item?->uom?->name . ')' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" readonly class="form-control" name="inv_item_id"
                                        id="inv_item_id" required>
                                </div>
                            </div><!-- end col-->
                            <div class="col-sm-2">
                                <div class="text-sm">
                                    <label>Qyantity Left</label>
                                    <input type="text" readonly value="0" class="form-control" name="qty_left"
                                        wire:model='qty_left' id="qtyleft" required>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="text-sm">
                                    <label>Quantity required</label>
                                    <input type="number" min="1" class="form-control" wire:model='request_qty'
                                        required name="request_qty">
                                </div>
                            </div><!-- end col-->

                            <div class="col-sm-2">
                                <div class="text-sm-end pt-2">
                                    @if ($request_qty > $qty_left)
                                        <small class="text-danger">The required quantity can not be greater than the
                                            available quantity</small>
                                    @else
                                        <button type="submit" class="btn btn-primary mb-2 me-1">Add item</button>
                                    @endif

                                </div>
                            </div><!-- end col-->
                        </div>
                    </form>

                </div>
                <div class="card-body">
                    <form method="POST" action="{{ url('inventory/request/delete') }}">
                        @csrf
                        <div class="tab-content">
                            <div class="tab-pane show active" id="scroll-horizontal-preview">
                                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Item name</th>
                                            <th>Description</th>
                                            <th>UOM</th>
                                            <th>Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($request_items) > 0)
                                            @php($i = 1)
                                            @php($display = 'd-none')
                                            @foreach ($request_items as $value)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $value->departmentItem->item->name ?? '' }}<input
                                                            type="hidden" name="item[]" value="{{ $value->id }}">
                                                    </td>
                                                    <td>{{ $value->departmentItem->item->description }}</td>
                                                    <td>{{ $value->departmentItem->item->uom->name ?? 'N/A' }}</td>
                                                    <td>{{ $value->qty_requested }} <input type="hidden" id="totaltqty"
                                                            name="quantity[]" value="{{ $value->qty_requested }}"></td>
                                                    {{-- <td> <a onclick="return confirm('Are you sure you want to delete?');" href="{{ url('inventory/request/delete-item/?id='.$value->ritem_id.'&qty='.$value->request_qty) }}"  data-toggle="tooltip" title="Delete!" class="action-icon"> <i class="mdi mdi-delete"></i></a></td> --}}
                                                    <td> <a onclick="return confirm('Are you sure you want to delete?');"
                                                            href="javacript:void()" data-toggle="tooltip"
                                                            title="Delete!"
                                                            wire:click="destroyItem({{ $value->id }})"
                                                            class="action-icon"> <i class="mdi mdi-delete"></i></a></td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @php($display = 'block')
                                        @endif
                                    </tbody>
                                </table>

                            </div> <!-- end preview-->
                            <input type="hidden" class="form-control" name="requestcode" readonly
                                value="{{ $request_code }}">

                            <div class="text-sm-end mt-3">
                                @if ($display == 'd-none')
                                    <button wire:click="submitRequest('{{ $request_code }}')" type="button" data-toggle="tooltip"
                                        title="Submit request request!" class="btn btn-success mb-2 me-1 text-sm-end">
                                        <i class="mdi mdi-check"> Submit request</i></button>
                                @else
                                    <button
                                        onclick="return confirm('Are you sure you want to delete the entire request with its details?');"
                                        type="submit" id="cancelbtn" data-toggle="tooltip" title="Delete request!"
                                        class="btn btn-danger mb-2 me-1 text-sm-end {{ $display }}"> <i
                                            class="mdi mdi-cancel"> Cancel request</i></button>
                                @endif

                            </div>
                        </div> <!-- end tab-content-->
                    </form>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div>
    </div>
