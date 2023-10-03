<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                   My official Contracts (<span class="text-danger fw-bold">{{ $contracts->total() }}</span>)

                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="row mb-0" @if (!$filter) hidden @endif>
                            <h6>Filter contracts</h6>

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
                            <div class="mb-1 col-md-2">
                                <label for="orderBy" class="form-label">OrderBy</label>
                                <select wire:model="orderBy" class="form-select">
                                    <option type="name">Name</option>
                                    <option type="id">Latest</option>
                                </select>
                            </div>
                        </x-table-utilities>

                        <div class="table-responsive">
                            <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Employee Name</th>
                                        <th>Date Range</th>
                                        <th>Gross</th>
                                        <th>Status</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contracts as $key => $contract)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $contract->employee->fullname??'N/A' }}</td>
                                            <td>{{ $contract->start_date ?? 'N/A' }} To {{ $contract->end_date ?? 'N/A' }}</td>
                                            <td>{{ $contract->gross_salaray ?? 'N/A' }}</td>
                                            @if ($contract->status == 'Running')
                                                <td><span class="badge bg-success">{{ $contract->status }}</span></td>
                                            @else
                                                <td><span class="badge bg-warning">{{ $contract->status }}</span></td>
                                            @endif
                                            <td>{{ date('d-m-Y', strtotime($contract->created_at)) }}</td>
                                            <td class="table-action">
                                                <button   class="action-ico btn-sm btn btn-outline-success mx-1">
                                                    <i class="fa fa-eye"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="btn-group float-end">
                                    {{ $contracts->links('vendor.livewire.bootstrap') }}
                                </div>
                            </div>
                        </div>
                    </div> <!-- end tab-content-->
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    
</div>
