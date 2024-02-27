<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    @if (!$toggleForm)
                                        Chart of Accounts (<span class="text-danger fw-bold">{{ $accounts->total() }}</span>)
                                        @include('livewire.layouts.partials.inc.filter-toggle')
                                    @else
                                        Edit Chart of Accounts 
                                    @endif

                                </h5>
                                @include('livewire.layouts.partials.inc.create-resource')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="row mb-0" @if (!$filter) hidden @endif>
                            <h6>Filter Chart of Accounts</h6>

                            <div class="mb-3 col-md-3">
                                <label for="is_active" class="form-label">Status</label>
                                <select wire:model="is_active" class="form-select select2" id="is_active">
                                    <option value="">Select</option>
                                    <option value="1">Active</option>
                                    <option value="0">Suspended</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="countryName" class="form-label required">Account Type</label>
                                <select name="" id="f_account_type" class="form-control" wire:model="f_account_type">
                                    <option value="">select...</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
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
                                        <th>Code</th>
                                        <th>Type</th>
                                        <th>Detail Type</th>
                                        {{-- <th>Tax Rate</th>
                                        <th>Balance</th>
                                        <th>Bank Balance</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accounts as $key => $account)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $account->name }} 
                                            @if ($account->parent_account)
                                                Parent ({{ $account->parent->name }})
                                            @endif
                                            </td>
                                            <td>{{ $account->code??'N/A' }}</td>
                                            <td>{{ $account->type->name??'N/A' }}</td>
                                            <td>{{ $account->subType->name??'N/A' }}</td>
                                            {{-- <td>{{ $account->type_id }}</td>
                                            <td>{{ $account->primary_balance }}</td>
                                            <td>{{ $account->bank_balance }}</td> --}}
                                            <td class="table-action">                                                  
                                                    {{-- @livewire('fms.partials.status-component', ['model' => $account, 'field' => 'is_active'], key($account->id)) --}}
                                                    <div class="btn-group btn-sm">
                                                        <div class="btn-group dropstart" role="group">
                                                          <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split me-0" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="visually-hidden">Toggle Dropstart</span>
                                                            <i class="mdi mdi-chevron-left"></i>
                                                          </button>
                                                          <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#">Account History</a>
                                                            <a class="dropdown-item" href="#">Run Report</a>
                                                            
                                                        </div>
                                                        </div>
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#updateCreateModal" wire:click="editdata({{ $account->id }})" class="btn btn-outline-secondary">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    </div>
                                                    
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="btn-group float-end">
                                    {{ $accounts->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div> <!-- end tab-content-->
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    @include('livewire.finance.accounting.inc.new-chart-of-accounts-form')
   {{-- Add/update modal --}}
   

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

