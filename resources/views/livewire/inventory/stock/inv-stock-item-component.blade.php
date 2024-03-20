<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row row-cols-3 d-flex justify-content-md-between">
                    <div class="col-md-6 d-print-flex">
                        <div class="">
                            <h6 class="mb-0"><b>Document Date :</b> {{ $stockLog->date_added }}</h6>
                            <h6><b>Document Code :</b> # {{ $stockLog->stock_code }}</h6>
                            <h6><b>LPO :</b> # {{ $stockLog->lpo }}</h6>
                        </div>
                    </div><!--end col-->
                    <div class="col-md-6 d-print-flex">
                        <div class="">
                            <address class="font-13">
                                <strong class="font-14">Unit Details:</strong><br>
                                    {{ $stockLog->unitable->name ?? 'MAKERERE UNIVERSITY BIOMEDICAL RESEARCH CENTRE' }}<br>
                                    {{ $stockLog->unitable->description ?? '' }}
                            </address>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div>
            @if ($stockLog->status == 'Pending')             
            <div class="card-header">
                <form wire:submit.prevent='storeItem'>
                    @csrf
                    <div class="row mb-2 mt-3">
                        <div class="col-sm-5">
                            <input type="hidden" name="" wire:model='document_id' id="">
                            <label for="inv_item_id">Select Item</label>
                            <select class="form-select select2" id="inv_item_id" wire:model="inv_item_id" required>
                                <option value="">Select item</option>
                                @if (count($items) > 0)
                                    @foreach ($items as $myitem)
                                        <option value="{{ $myitem->id }}">
                                            {{ $myitem?->item->name . '  (' . $myitem->item?->uom?->name ?? (null . ') ' . $myitem->brand ?? null) }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <div class="text-sm">
                                <label>Cost price</label>
                                <input type="text" class="form-control" wire:model="unit_cost" id="icostprice"
                                    required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="inv_store_id">Store</label>
                            <select class="form-select myselect" id="inv_store_id" wire:model="inv_store_id" required>
                                <option value="">Select store</option>
                                @if (count($stores) > 0)
                                    @foreach ($stores as $store)
                                        <option value="{{ $store->id }}">
                                            {{ $store->name . ' ' . $store->location }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row mb-2 mt-3">
                        <div class="col-sm-2">
                            <div class="text-sm">
                                <label>Quantity</label>
                                <input type="number" class="form-control" onchange="exp()" required
                                    wire:model="stock_qty">
                            </div>
                        </div><!-- end col-->
                        <div class="col-sm-2">
                            <div class="text-sm">
                                <label>Batch No.</label>
                                <input type="text" @if ($expires == '1') required @endif
                                    class="form-control" id=";plo " wire:model="batch_no">
                            </div>
                        </div><!-- end col-->
                        <div class="col-sm-1">
                            <div class="text-sm">
                                <label>Expires</label>
                                <input type="text" readonly class="form-control" id="expires"
                                    wire:model="expires">
                            </div>
                        </div><!-- end col-->

                        <div class="col-sm-3">
                            <div class="text-sm">
                                @php($Date = date('Y-m-d'))
                                <label>Expiry date</label>
                                <input type="date" class="form-control"
                                    @if ($expires == '1') required @endif
                                    min="{{ date('Y-m-d', strtotime($Date . ' + 15 days')) }}" id="expiry_date"
                                    wire:model="expiry_date">
                            </div>
                        </div>
                        <div class="col-sm-2">

                            <div class="text-sm">
                                <label>As of</label>
                                <input type="date" class="form-control" wire:model='as_of' name="date_added"
                                    required>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="text-sm-end pt-2">
                                <button type="submit" class="btn btn-primary mb-2 me-1">Add item</button>
                            </div>
                        </div><!-- end col-->
                    </div>
                </form>
            </div>
            @else

            @endif
            <div class="card-body">
                <form method="POST" wire:submit.prevent='SaveStock()'>
                    @csrf
                    <div class="tab-content">
                        <div class="tab-pane show active" id="scroll-horizontal-preview">
                            <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Item name</th>
                                        <th>Store</th>
                                        <th>UOM</th>
                                        <th>Batch No.</th>
                                        <th>Quantity</th>
                                        <th>Cost</th>
                                        <th>Total Cost</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($stock_items) > 0)
                                        @php($i = 1)
                                        @php($display = 'block')
                                        @foreach ($stock_items as $value)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $value->departmentItem->item->name ?? '' }}  {{ $value->inv_item_id }}<input type="hidden"
                                                        name="item[]" required value="{{ $value->inv_item_id }}"></td>
                                                <td>{{ $value->store->name ?? 'N/A' }}</td>
                                                <td>{{ $value->departmentItem->item->uom->name ?? 'N/A' }}</td>
                                                <td>{{ $value->batch_no }}</td>
                                                <td>{{ $value->stock_qty }} <input type="hidden" name="quantity[]"
                                                        value="{{ $value->stock_qty }}"></td>
                                                <td>{{ $value->unit_cost }}</td>
                                                <td>{{ $value->unit_cost * $value->stock_qty }} <input type="hidden"
                                                        name="amount"
                                                        value="{{ $value->unit_cost * $value->stock_qty }} "></td>
                                                <td>
                                                    @if ($stockLog->status == 'Pending') 
                                                    <a href="javascript: void(0);"
                                                        wire:click="confirmDelete({{ $value->id }})"
                                                        title="Delete!" class="action-icon"> <i
                                                            class="mdi mdi-delete"></i></a>
                                                    @else
                                                    NA
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @php($display = 'd-none')
                                    @endif
                                </tbody>
                            </table>
                            <p class="text-end mt-2">Total Amount: <strong><span id="totalamt"></span></strong></p>
                        </div> <!-- end preview-->
                        <input type="hidden" class="form-control" name="stockcode" readonly
                            value="{{ $code }}">
                        <input type="hidden" class="form-control" name="stktotalamt" id="stktotalamt" readonly>
                        @if ($stockLog->status == 'Pending') 
                        <div class="row mt-3">
                            <div class="col mt-1">
                                <div class="input-group">
                                    <span class="input-group-text">LPO</span>
                                    <input type="text" name="lpo" wire:model='lpo' class="form-control" required>
                                </div>
                            </div>
                            <div class="col mt-1">
                                <div class="input-group">
                                    <span class="input-group-text">GRN</span>
                                    <input type="text" name="grn" wire:model='grn'
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col mt-1">
                                <div class="input-group">
                                    <span class="input-group-text">Delivery No</span>
                                    <input type="text" name="delivery_no"
                                         class="form-control" wire:model='delivery_no' required>
                                </div>
                            </div>
                            <div class="text-sm-end col">
                                <button type="submit" id="saveStk" wire:click='SaveStock'
                                    class="btn btn-primary {{ $display }} mb-2 me-1 mt-1 text-sm-end">Save
                                    stock</button>
                                    <a href="javascript:void(0)" id="deleteStk" wire:click='deleteStockDoc("{{ $stockLog->stock_code }}")'
                                    class="btn btn-danger mb-2 me-1 mt-1 text-sm-end">Delete
                                    Doc</a>
                            </div>
                        </div>
                        @endif

                    </div> <!-- end tab-content-->
                </form>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
@include('livewire.inventory.inc.confirm-delete')
      @push('scripts')
      <script>
        window.addEventListener('close-modal', event => {
          $('#deptItemupdateCreateModal').modal('hide');
          $('#delete_modal').modal('hide');
          $('#confirmDelete').modal('hide');
        });
        window.addEventListener('show-modal', event => {
          $('#deptItemupdateCreateModal').modal('show');
        });
        window.addEventListener('delete-modal', event => {
          $('#confirmDelete').modal('show');
        });
      </script>
      
      @endpush