<div>
    <div class="row" x-data="{ filter_data: @entangle('filter'), create_new: @entangle('createNew') }">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    Employee Appraisals (<span
                                        class="text-danger fw-bold">{{ $appraisals->total() }}</span>)
                                    @include('livewire.layouts.partials.inc.filter-toggle')
                                </h5>
                                {{-- @if (Auth::user()->hasPermission(['create_appraisals']))  --}}
                                    @include('livewire.layouts.partials.inc.create-resource-alpine')                                   
                                {{-- @endif --}}

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('livewire.human-resource.performance.appraisal.inc.create-form')
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="row mb-0" @if (!$filter) hidden @endif>
                            <h6>Filter appraisals</h6>

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
                                    <option type="created_at">Date</option>
                                    <option type="id">Latest</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label for="from_date" class="form-label">From Date</label>
                                <input id="from_date" type="date" class="form-control" wire:model.lazy="from_date">
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
                                        <th>Uploaded By</th>
                                        <th>Department</th>
                                        <th>Desigination</th>
                                        <th>Date Submitted</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($appraisals as $key => $appraisal)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $appraisal->employee->fullName ?? 'N/A' }}</td>
                                            <td>{{ $appraisal->employee?->department?->name ?? 'N/A' }}</td>
                                            <td>{{ $appraisal->employee?->designation?->name ?? 'N/A' }}</td>
                                            <td>{{ $appraisal->created_at }}</td>
                                            <td>{{ $appraisal->status }}</td>
                                            <td class="table-action">
                                                <a  href="{{ route('hr_appraisals_view',$appraisal->id) }}" class="btn btn-sm btn-outline-primary">
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
                                    {{ $appraisals->links('vendor.livewire.bootstrap') }}
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
        $(document).ready(function () {
            $('#employee_id').select2();
            $('#employee_id').on('change', function (e) {
                var data = $('#employee_id').select2("val");
            @this.set('employee_id', data);
            });
        });
    </script>
    
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
