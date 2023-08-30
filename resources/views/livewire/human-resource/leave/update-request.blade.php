<div>
    @include('livewire.human-resource.leave.breadcrumps', [
    'heading' => 'Edit',
    ])
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">

                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <form wire:submit.prevent="store">
                                <div class="row">

                                    <div class="mb-3 col-md-4">
                                        <label class="mb-3 required">Type of/Purpose for being Unavailable</label>
                                        <div class="selectr-container selectr-desktop has-selected"
                                            style="width: 100%;">
                                            <div class="" style="width: 100%;">
                                                <select class="form-select" wire:model="leave_type_id">
                                                    <option value="">Select ...</option>
                                                    @foreach ($leaveTypes as $leaveType)
                                                    <option value="{{$leaveType->id}}" selected="">
                                                        {{$leaveType->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('leave_type_id')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label class="mb-3">Employee</label>
                                        <div class="selectr-container selectr-desktop has-selected"
                                            style="width: 100%;">
                                            <div class="" style="width: 100%;">
                                                <select class="form-select" wire:model="employee_id">
                                                    <option value="">Select ...</option>
                                                    @foreach ($employees as $employee)
                                                    <option value="{{$employee->id}}" selected="">
                                                        {{$employee->full_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('employee_id')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-5">
                                        <label for="start_date" class="form-label required">From</label>
                                        <input type="date" id="start_date" class="form-control"
                                            wire:model.defer="start_date" required>
                                        @error('start_date')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-5">
                                        <label for="end_date" class="form-label required">To</label>
                                        <input type="date" id="end_date" class="form-control"
                                            wire:model.defer="end_date" required>
                                        @error('end_date')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-10">
                                        <label for="reason" class="form-label">Reason</label>
                                        <textarea type="text" id="reason" rows="4" class="form-control"
                                            wire:model.defer="reason" placeholder="reason">
                                        </textarea>

                                        @error('reason')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="{{route('leave.requests')}}" class="btn btn-danger me-2">{{
                                        __('public.cancel') }}</a>
                                    <x-button class="btn-primary">{{ __('public.save') }}</x-button>
                                </div>
                            </form>
                        </div>
                    </div>


                </div> <!-- end card body-->
            </div> <!-- end card -->


            <div class="d-flex align-center justify-content-between align-items-center mx-4">
                <h3>My delegations</h3>
                <div>
                    <x-button class="btn-outline-primary" data-bs-toggle="modal" data-bs-target="#new_delegation_modal">
                        Delegate another employee</x-button>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Employee Name</th>
                                    <th>Status</th>
                                    <th>Comment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($leaveRequest->delegations as $key => $delegation)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $delegation->employee->full_name ?? 'N/A' }}</td>
                                    <td>
                                        @if ( $delegation->status == DECLINED)
                                        <span class="badge bg-danger">Declined</span>
                                        @elseif ( $delegation->status == PENDING)
                                        <span class="badge bg-warning">Pending</span>
                                        @else
                                        <span class="badge bg-primary">{{APPROVED}}</span>
                                        @endif
                                    </td>
                                    <td>{{ $delegation->comment ?? 'N/A' }}</td>
                                    <td class="table-action d-flex">
                                        <a href="" wire:click="editDelegation({{ $delegation->id }})"
                                            class="action-ico btn-sm text-primary mx-1" data-bs-toggle="modal"
                                            data-bs-target="#new_delegation_modal">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <div wire:click="deleteData({{ $delegation->id }})" data-bs-toggle="modal"
                                            data-bs-target="#delete_modal"
                                            class="action-ico text-primary btn-outline-success mx-1">
                                            <i class="las la-trash-alt text-danger font-16"></i>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">You have not yet delegated anyone yet...</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- delete modal -->
            <div wire:ignore.self class="modal fade" id="delete_modal" tabindex="-1" role="dialog"
                aria-labelledby="deleteModalTitle" data-bs-backdrop="static" data-bs-keyboard="false"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h6 class="modal-title m-0" id="deleteModalTitle">
                                Delete this delegation request..
                            </h6>
                            <button type="button" class="btn-close text-danger" data-bs-dismiss="modal"
                                wire:click="close()" aria-label="Close"></button>
                        </div>
                        <!--end modal-header-->
                        <div class="modal-body">
                            <div class="row">
                                Are you sure you want to delete this record
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm" data-bs-dismiss="modal"
                                wire:click="close()">{{
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
            <!-- new delegation modal -->
            <div wire:ignore.self class="modal fade" id="new_delegation_modal" tabindex="-1" role="dialog"
                aria-labelledby="deleteModalTitle" data-bs-backdrop="static" data-bs-keyboard="false"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h6 class="modal-title m-0" id="deleteModalTitle">
                                Select New Employee
                            </h6>
                            <button type="button" class="btn-close text-danger" data-bs-dismiss="modal"
                                wire:click="close()" aria-label="Close"></button>
                        </div>
                        <!--end modal-header-->
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="mb-3 required">Select Staff to Delegate roles to</label>
                                    <div class="selectr-container selectr-desktop has-selected" style="width: 100%;">
                                        <div class="" style="width: 100%;">
                                            <select class="form-select" wire:model="delegatee_id">
                                                <option value="">Select ...</option>
                                                @foreach ($employees as $employee)
                                                <option value="{{$employee->id}}" selected="">
                                                    {{$employee->full_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('delegatee_id')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label for="delegatee_comment" class="form-label">Any comment to the
                                        delegatee?</label>
                                    <textarea type="text" id="delegatee_comment" rows="4" class="form-control"
                                        wire:model="delegatee_comment" placeholder="eg I will be offline for a bit.">
                                    </textarea>

                                    @error('delegatee_comment')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm" data-bs-dismiss="modal"
                                wire:click="close()">{{
                                __('public.close') }}</button>

                            <x-button type="click" wire:click="saveDelegate" class="btn-danger btn-sm">Save
                            </x-button>

                        </div>
                        <!--end modal-footer-->
                    </div>
                    <!--end modal-content-->
                </div>
                <!--end modal-dialog-->
            </div>
            <!--end modal-->

        </div><!-- end col-->
    </div>
</div>