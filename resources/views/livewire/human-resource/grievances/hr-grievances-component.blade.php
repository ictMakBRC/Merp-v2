<div>
    <div class="row" x-data="{ filter_data: @entangle('filter'), create_new: @entangle('createNew') }">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    @if (!$toggleForm)
                                        Grievances (<span class="text-danger fw-bold">{{ $grievances->total() }}</span>)
                                        @include('livewire.layouts.partials.inc.filter-toggle')
                                    @else
                                        Edit grievance
                                    @endif

                                </h5>
                                @include('livewire.layouts.partials.inc.create-resource-alpine')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="row mb-0" @if (!$filter) hidden @endif>
                            <h6>Filter grievances</h6>

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
                                <a type="button" class="btn btn-outline-success me-2" wire:click="export()">Export</a>
                            </div>

                            <div class="mb-3 col-md-2">
                                <label for="from_date" class="form-label">From Date</label>
                                <input id="from_date" type="date" class="form-control" wire:model.lazy="from_date">
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
                                        <th>Sent By</th>
                                        <th>Subject</th>
                                        <th>Department</th>
                                        <th>Desigination</th>
                                        <th>Grievance Type</th>
                                        <th>Date Submitted</th>
                                        <th>Viewed By</th>
                                        <th>Date Viewed</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($grievances as $key => $grievance)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $grievance->employee->fullName ?? 'N/A' }}</td>
                                            <td>{{ $grievance->subject }}</td>
                                            <td>{{ $grievance->department->name ?? 'N/A' }}</td>
                                            <td>{{ $grievance->employee?->designation?->name ?? 'N/A' }}</td>
                                            <td>{{ $grievance->type?->name ?? 'N/A' }}</td>
                                            <td>{{ $grievance->created_at }}</td>
                                            <td>{{ $grievance->acknowledgedBy->name ?? 'N/A' }}</td>
                                            <td>{{ $grievance->acknowledged_at ?? 'N/A' }}</td>
                                            <td>{{ $grievance->status }}</td>
                                            <td class="table-action">


                                                <a data-bs-toggle="modal" data-bs-target="#submit_modal"
                                                    wire:click='showGrievance({{ $grievance->id }})'
                                                    href="javascript:void(0)" class="btn btn-sm btn-outline-primary">
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
                                    {{ $grievances->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div> <!-- end tab-content-->
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    <!-- submit_modal -->
    <div wire:ignore.self class="modal fade" id="submit_modal" tabindex="-1" role="dialog"
        aria-labelledby="submitModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title m-0" id="submitModalTitle">
                        Submitted to: {{ $addressee }}
                    </h6>
                    <button type="button" class="btn-close text-danger" data-bs-dismiss="modal"
                        @if (!$toggleForm) wire:click='close' @endif aria-label="Close"></button>
                </div>
                <!--end modal-header-->
                <div class="modal-body">
                    <div class="row">
                        <h5 class="text-center"> <b>Subject:</b>{{ $subject }} </h5><br>
                        <p>{{ $comment }}</p> <br>
                        @if ($acknowledged_by_comment)
                            <small><b>Comment:</b> {{ $acknowledged_by_comment }} </small>
                        @endif
                        @if ($status == 'Submitted')
                        <div class="form-group">
                            <label for="address" class="form-label">Comment</label>
                            <textarea id="acknowledged_by_comment" class="form-control text-uppercase"
                                wire:model.defer='acknowledged_by_comment'></textarea>
                            @error('acknowledged_by_comment')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" @if (!$toggleForm) wire:click='close' @endif
                        class="btn btn-default btn-sm" data-bs-dismiss="modal">{{ __('public.close') }}</button>
                    @if ($status == 'Submitted')
                        <x-button type="click" wire:click="markGrievance({{ $edit_id }})"
                            class="btn-success btn-sm">Mark As Seen</x-button>
                    @endif

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
                $('#updateCreateModal').modal('hide');
                $('#submit_modal').modal('hide');
                $('#show-delete-confirmation-modal').modal('hide');
            });
            window.addEventListener('delete-modal', event => {
                $('#delete_modal').modal('show');
            });
            window.addEventListener('submit_modal', event => {
                $('#submit_modal').modal('show');
            });
        </script>
    @endpush
</div>
