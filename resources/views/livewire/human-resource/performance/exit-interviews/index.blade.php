<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">

                                    Exit Interviews (<span class="text-danger fw-bold">{{ $exitInterviews->total()
                                        }}</span>)


                                </h5>
                                <div class="ms-auto">
                                    <a type="button" class="btn btn-sm btn-outline-primary me-2"
                                        wire:click="export()">Export</a>
                                    <a type="button" class="btn btn-sm btn-outline-primary me-2"
                                        wire:click="refresh()"><i class="mdi mdi-refresh"></i></a>
                                    <a href="{{route('exit-interviews.create')}}" class="btn btn-sm me-2 btn-primary">
                                        <i class="fa fa-plus"></i>New
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="row mb-0" @if (!$filter) hidden @endif>
                            <h6>Filter stations</h6>

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
                            <div class="mb-3 row col-md-9">
                                <div class="mb-3 col-md-2">
                                    <label for="from_date" class="form-label">From Date</label>
                                    <input id="from_date" type="date" class="form-control" wire:model.lazy="from_date">
                                </div>

                                <div class="mb-3 col-md-2">
                                    <label for="to_date" class="form-label">To Date</label>
                                    <input id="to_date" type="date" class="form-control" wire:model.lazy="to_date">
                                </div>

                                <div class="mb-3 col-md-2">
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

                                <div class="mb-3 col-md-2">
                                    <label for="orderAsc" class="form-label">Order</label>
                                    <select wire:model="orderAsc" class="form-select" id="orderAsc">
                                        <option value="1">Ascending</option>
                                        <option value="0">Descending</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="search" class="form-label">Search</label>
                                <input id="search" type="text" class="form-control" wire:model.debounce.300ms="search"
                                    placeholder="search">
                            </div>
                            <hr>
                        </div>

                        <div class="table-responsive">
                            <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Employee Name</th>
                                        <th>Department</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($exitInterviews as $key => $exitInterview)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $exitInterview->employee->name ?? 'N/A' }}</td>
                                        <td>{{ $exitInterview->department->name ?? 'N/A' }}</td>
                                        <td>@formatDate($exitInterview->created_at)</td>
                                        <td class="table-action d-flex">
                                            <a href="{{route('exit-interviews.show', $exitInterview->id)}}"
                                                class="action-ico btn-sm text-primary mx-1">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{route('exit-interviews.update', $exitInterview->id)}}"
                                                class="action-ico btn-sm text-primary mx-1">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <div wire:click="deleteData({{ $exitInterview->id }})"
                                                data-bs-toggle="modal" data-bs-target="#delete_modal"
                                                class="action-ico text-primary btn-outline-success mx-1">
                                                <i class="las la-trash-alt text-danger font-16"></i>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No exit Interviews recorded yet ...</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="btn-group float-end">
                                    {{ $exitInterviews->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div> <!-- end tab-content-->
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    <!-- delete modal -->
    <div wire:ignore.self class="modal fade" id="delete_modal" tabindex="-1" role="dialog"
        aria-labelledby="deleteModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title m-0" id="deleteModalTitle">
                        Delete Existing exit Interview
                    </h6>
                    <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()"
                        aria-label="Close"></button>
                </div>
                <!--end modal-header-->
                <div class="modal-body">
                    <div class="row">
                        Are you sure you want to delete this record
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-bs-dismiss="modal" wire:click="close()">{{
                        __('public.close') }}</button>

                    <x-button type="click" wire:click="delete" class="btn-danger btn-sm">Confirm</x-button>

                </div>
                <!--end modal-footer-->
            </div>
            <!--end modal-content-->
        </div>
        <!--end modal-dialog-->
    </div>
    <!--end modal-->

    @push('scripts')
    <script>
        window.addEventListener('close-modal', event => {
                    $('#delete_modal').modal('hide');
                    $('#show-delete-confirmation-modal').modal('hide');
                });
                window.addEventListener('delete-modal', event => {
                    $('#delete_modal').modal('show');
                });
    </script>
    @endpush
</div>