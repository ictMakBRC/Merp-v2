<div>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card overflow-hidden">
                <div class="row g-0">
                    <div class="col-md-6 col-lg-3 border-b border-e border-bo">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center text-info">
                                <div class="col">
                                    <div class="media">
                                        <div class="bg-light-alt d-flex justify-content-center align-items-center thumb-md  rounded-circle">
                                            <i data-feather="package" class="align-self-center  icon-sm"></i>  
                                        </div>
                                        <div class="media-body align-self-center ms-2"> 
                                            <p class=" mb-1 fw-semibold">Total</p>                                                            
                                            <p class="mb-0 text-truncate ">Estimates</p>                                                                                   
                                        </div><!--end media body-->
                                    </div><!--end media-->                                                    
                                </div><!--end col-->
                                <div class="col-auto align-self-center">
                                    <h5 class="my-1">@moneyFormat($invoices->where('status','!=','Canceled')->sum('total_amount'))</h5>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->                                            
                    </div> <!--end col--> 
                    <div class="col-md-6 col-lg-3 border-b border-e border-bo">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center text-primary">                                                
                                <div class="col">
                                    <div class="media">
                                        <div class="bg-light-alt d-flex justify-content-center align-items-center thumb-md  rounded-circle">
                                            <i class="align-self-center  icon-sm fas fa-money-bill-wave"></i>  
                                        </div>
                                        <div class="media-body align-self-center ms-2"> 
                                            <p class=" mb-1 fw-semibold">Total</p>                                                            
                                            <p class="mb-0 text-truncate ">Paid</p>
                                        </div><!--end media body-->
                                    </div><!--end media-->                                                    
                                </div><!--end col-->
                                <div class="col-auto align-self-center">
                                    <h4 class="my-1">  <h5 class="my-1">@moneyFormat($invoices->where('status','Paid')->sum('total_amount'))</h5></h4>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->                                            
                    </div> <!--end col-->                         
                    <div class="col-md-6 col-lg-3 border-b border-e">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center text-warning">
                                <div class="col">  
                                    <div class="media">
                                        <div class="bg-light-alt d-flex justify-content-center align-items-center thumb-md  rounded-circle">
                                            <i data-feather="alert-octagon" class="align-self-center  icon-sm"></i>
                                        </div>
                                        <div class="media-body align-self-center ms-2"> 
                                            <p class=" mb-1 fw-semibold">Total</p>                                                             
                                            <p class="mb-0 text-truncate ">Unpaid</p>
                                        </div><!--end media body-->
                                    </div><!--end media-->                                                    
                                </div><!--end col-->
                                <div class="col-auto align-self-center">
                                    <h5 class="my-1">@moneyFormat($invoices->whereIn('status',['Partially Paid','Approved'])->sum('total_amount'))</h5>                                                     
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->                                            
                    </div> <!--end col--> 
                    <div class="col-md-6 col-lg-3 ps-lg-0">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center text-danger">                                                
                                <div class="col">
                                    <div class="media">
                                        <div class="bg-light-alt d-flex justify-content-center align-items-center thumb-md  rounded-circle">
                                            <i data-feather="alert-triangle" class="align-self-center  icon-sm"></i> 
                                        </div>
                                        <div class="media-body align-self-center ms-2"> 
                                            <p class=" mb-1 fw-semibold">Total</p>                                                      
                                            <p class="mb-0 text-truncate ">Overdue</p>
                                        </div><!--end media body-->
                                    </div><!--end media-->                                                     
                                </div><!--end col-->
                                <div class="col-auto align-self-center">
                                    <h5 class="my-1">@moneyFormat($invoices->whereIn('status',['Partially Paid','Approved'])->where('as_of','>=',date('Y-m-d'))->sum('total_amount'))</h5>                       
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->                                            
                    </div> <!--end col-->
                </div><!--end row--> 
            </div><!--end card-->
        </div><!--end col-->           
    </div><!--end row-->
    <div class="row" x-data="{ filter_data: @entangle('filter'),create_new: @entangle('createNew') }">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    @if (!$toggleForm)
                                        Invoices (<span class="text-danger fw-bold">{{ $invoices->total() }}</span>)
                                        @include('livewire.layouts.partials.inc.filter-toggle')
                                    @else
                                        Edit Invoice
                                    @endif

                                </h5>
                                @include('livewire.layouts.partials.inc.create-resource-alpine')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('livewire.finance.invoice.inc.new-invoice-form')
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
                                            <td>{{ $invoice->invoice_date }}</td>
                                            <td>{{ $invoice->status }}</td>
                                            <td class="table-action">     
                                                @if ($invoice->status=='Pending')
                                                    
                                                    <a href="{{URL::signedRoute('finance-invoice_items', $invoice->invoice_no)}}" class="action-ico btn-sm btn btn-outline-success mx-1"><i class="fa fa-edit"></i></a>
                                                @else
                                                
                                                    <a href="{{URL::signedRoute('finance-invoice_view', $invoice->invoice_no)}}" class="action-ico btn-sm btn btn-outline-success mx-1"><i class="fa fa-eye"></i></a>
                                                    
                                                @endif                                       
                                                    
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

