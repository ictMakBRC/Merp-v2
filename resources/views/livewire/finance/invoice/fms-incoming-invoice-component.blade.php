<div>
    @include('livewire.finance.invoice.inc.invoice-counts')
    <div class="row" x-data="{ filter_data: @entangle('filter'),create_new: @entangle('createNew') }">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    Incoming Invoices 
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="row mb-0" @if (!$filter) hidden @endif>
                            <h6>Filter Invoices</h6>

                            <div class="mb-3 col-md-3">
                                <label for="is_active" class="form-label">Status</label>
                                <select wire:model="is_active" class="form-select select2" id="is_active">
                                    <option value="">Select</option>
                                    <option value="1">Active</option>
                                    <option value="0">Suspended</option>
                                </select>
                            </div>

                        </div>
                        <div class="row mb-0">
                            <div class="mt-4 col-md-1">
                                <a type="button" class="btn btn-outline-success me-2"
                                    wire:click="export()">Export</a>
                            </div>

                            <div class="mb-3 col-md-2">
                                <label for="from_date" class="form-label">From Date</label>
                                <input id="from_date" type="date" class="form-control"
                                    wire:model.lazy="from_date">
                            </div>

                            <div class="mb-3 col-md-2">
                                <label for="to_date" class="form-label">To Date</label>
                                <input id="to_date" type="date" class="form-control" wire:model.lazy="to_date">
                            </div>

                            <div class="mb-3 col-md-1">
                                <label for="perPage" class="form-label">Per Page</label>
                                <select wire:model="perPage" class="form-select" id="perPage">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-2">
                                <label for="orderBy" class="form-label">OrderBy</label>
                                <select wire:model="orderBy" class="form-select">
                                    <option value="name">Name</option>
                                    <option value="contact">Contact</option>
                                    <option value="email">Email</option>
                                    <option value="id">Latest</option>
                                    <option value="is_active">Status</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-1">
                                <label for="orderAsc" class="form-label">Order</label>
                                <select wire:model="orderAsc" class="form-select" id="orderAsc">
                                    <option value="1">Asc</option>
                                    <option value="0">Desc</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="search" class="form-label">Search</label>
                                <input id="search" type="text" class="form-control"
                                    wire:model.debounce.300ms="search" placeholder="search">
                            </div>
                            <hr>
                        </div>

                        <div class="table-responsive">
                            <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Invice No.</th>
                                        <th>Billed From</th>
                                        <th>Billed To</th>
                                        <th>Total Amount</th>
                                        <th>Due Date</th>
                                        <th>Due Days</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $key => $invoice)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $invoice->invoice_no }}</td>
                                            <td>{{ $invoice->requestable->name??'N/A' }}</td>
                                            <td>{{ $invoice->customer->name??$invoice->department->name??'N/A' }}</td>
                                            <td>@moneyFormat( $invoice->total_amount )</td>
                                            <td>{{ $invoice->due_date }}</td>
                                            <td>
                                                @php
                                                    $days = \Carbon\Carbon::parse($due_date)->diffInDays(\Carbon\Carbon::now(), true);
                                                    if ($days>1) {
                                                        $class = 'bg-light-warning';
                                                    }else{
                                                        $class = '';
                                                    }
                                                @endphp
                                                
                                                <div class="badge  bg-primary">{{ $days }}Days</div>
                                            </td>
                                            <td><x-status-badge :status="$invoice->status" /></td>
                                            <td class="table-action">    
                                                
                                                    <a href="{{URL::signedRoute('finance-invoice_view', $invoice->invoice_no)}}" class="action-ico btn-sm btn btn-outline-success mx-1"><i class="fa fa-eye"></i></a>
                                                                                        
                                                    
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="btn-group float-end">
                                    {{ $invoices->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div> <!-- end tab-content-->
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

   

@push('scripts')
   <script>
       window.addEventListener('close-modal', event => {
           $('#updateCreateModal').modal('hide');
           $('#delete_modal').modal('hide');
           $('#show-delete-confirmation-modal').modal('hide');
       });
       window.addEventListener('delete-modal', event => {
           $('#delete_modal').modal('show');
       });
   </script>
@endpush
</div>

