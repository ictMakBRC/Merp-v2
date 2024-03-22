<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                   Positions
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="table-responsive">
                            <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Level</th>
                                        <th>Assigned TO</th>
                                        <th>Updated at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($positions as $key => $position)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $position->name }}</td>
                                            <td>{{ $position->level ?? 'N/A' }}</td>
                                            <td>{{ $position->assignedTo->employee->fullName ?? 'N/A' }}</td>
                                           
                                            <td>{{ date('d-m-Y', strtotime($position->updated_at)) }}</td>
                                            <td class="table-action">
                                                <button  wire:click="editData({{ $position->id }})" data-bs-toggle="modal" data-bs-target="#updateCreateModal" class="action-ico btn-sm btn btn-outline-success mx-1">
                                                    <i class="fa fa-edit"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                    </div> <!-- end tab-content-->
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    @include('livewire.finance.requests.inc.assignee-form')
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
