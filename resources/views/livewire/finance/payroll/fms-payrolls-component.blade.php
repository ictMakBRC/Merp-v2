<div>
    <div class="row" x-data="{ filter_data: @entangle('filter'), create_new: @entangle('createNew') }">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    All Payrolls (<span class="text-danger fw-bold">{{ $payrolls->total() }}</span>)
                                    @include('livewire.layouts.partials.inc.filter-toggle')
                                </h5>
                                @include('livewire.layouts.partials.inc.create-resource-alpine')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="createPayroll()">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="month">Month:</label>
                                <select class="form-select" wire:model="month" id="month">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ \Carbon\Carbon::create(null, $i, 1)->format('F') }}</option>
                                    @endfor
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label  for="year">Year:</label>
                                <select class="form-select" wire:model="year" id="year">
                                    @for ($i = date('Y'); $i >= (date('Y') - 10); $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>     
                            <div class="col-2">
                                <label  for="year">Currency:</label>
                                <select class="form-select" wire:model="currency_id" id="currency_id">
                                    <option value="">select</option>
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}">{{ $currency->code }}</option>
                                    @endforeach
                                </select>
                            </div>    
                            
                            <div class="col-md-2">
                                <label  for="year">Rate:</label>
                                <input type="number" step="any" class="form-control" wire:model="rate" id="rate">
                            </div>                

                            <div class="col-2 pt-3 text-end">
                                <button class="btn btn-primary" type="submit">Create Payroll</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="row mb-0" @if (!$filter) hidden @endif>
                            <h6>Filter requests</h6>

                            <div class="mb-3 col-md-3">
                                <label for="is_active" class="form-label">Status</label>
                                <select wire:model="is_active" class="form-select select2" id="is_active">
                                    <option value="">Select</option>
                                    <option value="1">Active</option>
                                    <option value="0">Suspended</option>
                                </select>
                            </div>

                        </div>
                        <x-table-utilities>
                            <div class="mb-1 col">
                                <label for="orderBy" class="form-label">OrderBy</label>
                                <select wire:model="orderBy" class="form-select">
                                    <option type="date">Date</option>
                                    <option type="id">Latest</option>
                                </select>
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
                        </x-table-utilities>

                        <div class="table-responsive">
                            <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Year</th>
                                        <th>Month</th>
                                        <th>Date created</th>
                                        <th>Voucher</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payrolls as $key => $payroll)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $payroll->year }}</td>
                                            <td>{{ $payroll->month }}</td>
                                            <td>{{ $payroll->created_at ?? 'N/A' }}</td>
                                            <td>{{ $payroll->payment_voucher ?? 'N/A' }}</td>
                                            <td><span class="badge bg-success">{{ $payroll->status }}</span></td>
                                            <td class="table-action">
                                                <a href="{{ URL::signedRoute('finance-payroll_data', $payroll->payment_voucher) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="btn-group float-end">
                                    {{ $payrolls->links('vendor.pagination.bootstrap-5') }}
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
