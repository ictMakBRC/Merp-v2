<div>
    <div class="row" x-data="{ filter_data: @entangle('filter'), create_new: @entangle('createNew') }">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    Salary Payement Requests (<span class="text-danger fw-bold">{{ $requests->total() }}</span>)
                                    @include('livewire.layouts.partials.inc.filter-toggle')
                                </h5>
                                @include('livewire.layouts.partials.inc.create-resource-alpine')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('livewire.finance.payroll.inc.new-salary-request-form')
                </div>
                @include('livewire.finance.requests.inc.request_counts')
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
                                        <th>Type</th>
                                        <th>Ref</th>
                                        <th>Date</th>
                                        <th>From Account</th>
                                        <th>Trx Amount</th>
                                        <th>Rate</th>
                                        <th>Currency</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requests as $key => $request)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $request->request_type }}</td>
                                            <td>{{ $request->request_code }}</td>
                                            <td>{{ $request->created_at ?? 'N/A' }}</td>
                                            <td>{{ $request->project->name ?? ($request->department->name ?? 'N/A') }}</td>
                                            <td>@moneyFormat($request->total_amount)</td>
                                            <td>@moneyFormat($request->rate)</td>
                                            <td>{{ $request->currency->code ?? 'N/A' }}</td>
                                            <td><x-status-badge :status="$request->status" /></td>
                                            <td class="table-action">
                                                {{-- @livewire('fms.partials.status-component', ['model' => $account, 'field' => 'is_active'], key($account->id)) --}}
                                                @if ($request->status =='Pending' || $request->status =='Rejected')
                                                <a href="{{ URL::signedRoute('finance-payroll_unit_details', $request->request_code) }}"
                                                    class="btn btn-sm btn-outline-secondary">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                    
                                                @else
                                                <a href="{{ URL::signedRoute('finance-request_preview', $request->request_code) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                    
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
                                    {{ $requests->links('vendor.livewire.bootstrap') }}
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
