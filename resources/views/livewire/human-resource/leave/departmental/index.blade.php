<div>
    @include('livewire.human-resource.leave.breadcrumps', [
    'heading' => 'leaveRequests',
    ])
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Leave Type</th>
                                    <th>Employee Name</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Status</th>
                                    <th>Comment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($leaveRequests as $leaveRequest)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $leaveRequest->leaveType->name }}</td>
                                    <td>{{ $leaveRequest->employee->full_name ?? 'N/A' }}</td>
                                    <td>@formatDate($leaveRequest->start_date)</td>
                                    <td>@formatDate($leaveRequest->end_date)</td>
                                    <td>
                                        @if ( $leaveRequest->status == DECLINED)
                                        <span class="badge bg-danger">Declined</span>
                                        @elseif ( $leaveRequest->status == PENDING)
                                        <span class="badge bg-warning">Pending</span>
                                        @else
                                        <span class="badge bg-primary">{{APPROVED}}</span>
                                        @endif
                                    </td>
                                    <td>{{ $leaveRequest->comment ?? 'N/A' }}</td>
                                    <td class="table-action d-flex">
                                        @if ($leaveRequest->status == PENDING && ($leaveRequest->status ==
                                        PENDING || $leaveRequest->status == DECLINED))
                                        <a href="" wire:click="selectThisleaveRequest({{ $leaveRequest->id }})"
                                            class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#accept_modal">
                                            Accept
                                        </a>
                                        @endif
                                        @if ($leaveRequest->status == PENDING && ($leaveRequest->status ==
                                        PENDING || $leaveRequest->status == APPROVED))

                                        <a href="" data-bs-toggle="modal" data-bs-target="#delete_modal"
                                            class="btn btn-xs btn-outline-danger mx-1"
                                            wire:click="selectThisleaveRequest({{ $leaveRequest->id }})">Decline</a>
                                        @endif
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

            <!-- accept modal -->
            <div wire:ignore.self class="modal fade" id="accept_modal" tabindex="-1" role="dialog"
                aria-labelledby="deleteModalTitle" data-bs-backdrop="static" data-bs-keyboard="false"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h6 class="modal-title m-0" id="deleteModalTitle">
                                Accept this leaveRequest request..
                            </h6>
                            <button type="button" class="btn-close text-danger" data-bs-dismiss="modal"
                                wire:click="close()" aria-label="Close"></button>
                        </div>
                        <!--end modal-header-->
                        <div class="modal-body">
                            <div class="row">

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

                            <x-button type="click" wire:click="declineleaveRequest" class="btn-danger btn-sm">Confirm
                            </x-button>

                        </div>
                        <!--end modal-footer-->
                    </div>
                    <!--end modal-content-->
                </div>
                <!--end modal-dialog-->
            </div>
            <!--end modal-->
            <!-- delete modal -->
            <div wire:ignore.self class="modal fade" id="delete_modal" tabindex="-1" role="dialog"
                aria-labelledby="deleteModalTitle" data-bs-backdrop="static" data-bs-keyboard="false"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h6 class="modal-title m-0" id="deleteModalTitle">
                                Decline this leaveRequest request..
                            </h6>
                            <button type="button" class="btn-close text-danger" data-bs-dismiss="modal"
                                wire:click="close()" aria-label="Close"></button>
                        </div>
                        <!--end modal-header-->
                        <div class="modal-body">
                            <div class="row">

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

                            <x-button type="click" wire:click="declineleaveRequest" class="btn-danger btn-sm">Decline
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