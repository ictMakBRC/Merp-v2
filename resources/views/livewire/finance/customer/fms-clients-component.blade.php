<div>
    <div class="row" x-data="{ filter_data: @entangle('filter'),create_new: @entangle('createNew') }">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    @if (!$toggleForm)
                                        Customers (<span class="text-danger fw-bold">{{ $customers->total() }}</span>)
                                        @include('livewire.layouts.partials.inc.filter-toggle')
                                    @else
                                        Edit Customer
                                    @endif

                                </h5>
                                @include('livewire.layouts.partials.inc.create-resource-alpine')
                                <button data-bs-target="#importModal" data-bs-toggle="modal" class="btn btn-info btn-sm"><i class="fa fa-import"></i> Import</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('livewire.finance.settings.inc.new-customer-form')
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="row mb-0" @if (!$filter) hidden @endif>
                            <h6>Filter Customers</h6>

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
                                        <th>Name</th>
                                        <th>Short Code</th>
                                        <th>Origin</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Company</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $key => $customer)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $customer->name }}</td>
                                            <td>{{ $customer->code }}</td>
                                            <td>{{ $customer->nationality??'N/A' }}</td>
                                            <td>{{ $customer->address??'N/A' }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ $customer->contact }}</td>
                                            <td>{{ $customer->company_name }}</td>
                                            <td class="table-action">                                                  
                                                    {{-- @livewire('fms.partials.status-component', ['model' => $customer, 'field' => 'is_active'], key($customer->id)) --}}
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#updateCreateModal" wire:click="editData({{ $customer->id }})" class="action-ico btn-sm btn btn-outline-success mx-1">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <a href="{{ URL::SignedRoute('finance-customer_view',$customer->id) }}" class="action-ico btn-sm btn btn-outline-info mx-1">
                                                        <i class="fa fa-eye"></i></a>
                                                    <button wire:click="selectCustomer({{ $customer->id }})" data-bs-toggle="modal" data-bs-target="#addOpeningBalance" class="action-ico btn-sm btn btn-outline-info mx-1"><i class="fa fa-bill"></i></button>
                                                    
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="btn-group float-end">
                                    {{ $customers->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div> <!-- end tab-content-->
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    @include('livewire.general.import-data')
   @include('livewire.finance.customer.inc.new-balance-form-modal')

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

