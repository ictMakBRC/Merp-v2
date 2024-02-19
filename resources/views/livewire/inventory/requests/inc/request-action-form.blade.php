<div wire:ignore.self class="modal fade" id="actionModal" tabindex="-1" role="dialog"
    aria-labelledby="updateCreateModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="approveRejectRequest">
                    Approve/Reject/Receive/Acknowledge Request
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()"
                    aria-label="Close"></button>
            </div><!--end modal-header-->
            @if ($request_data?->status == 'Submitted')
                @if ($approver == auth()->user()->employee?->id)
                    <form wire:submit.prevent="approveRejectRequest({{ $request_data->id }})">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <p>{{ $request_data->comment ?? ' ' }}</p>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label required">Date {{ $click_action }}:
                                        <b>{{ date('d-m-Y') }}</b></label>
                                </div>
                                <div class="col-6">
                                    <label for="comment" class="form-label">Action </label>
                                    <select class="form-control form-select" wire:model="click_action"
                                        id="click_action">
                                        <option value="">Select</option>
                                        <option value="Approved">Approve</option>
                                        <option value="Declined">Decline</option>
                                    </select>
                                </div>
                                <br>
                                <div class="mb-3 col-md-12">
                                    <label for="comment" class="form-label">Comment @if ($click_action == 'Declined')
                                            <small class="text-danger">Please
                                                give a comment as to why you declined the request</small>
                                        @endif </label>
                                    <textarea type="text" id="comment" class="form-control" name="comment"
                                        @if ($click_action == 'Declined') required @endif wire:model.defer="comment"></textarea>
                                    @error('comment')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"
                                wire:click="close()">{{ __('public.close') }}</button>
                            <x-button type="submit" class="btn-success btn-sm">{{ __('Done') }}</x-button>
                        </div><!--end modal-footer-->
                    </form>
                @else
                    <h5 class="text-center">No action needed</h5>
                @endif
            @elseif($request_data->status == 'Approved')
                @if ($inventory_data?->manager_id == auth()->user()->id||Auth::user()->hasPermission(['approve_inventory_request']))
                    <form wire:submit.prevent="receiveRejectRequest({{ $request_data->id }})">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <p>{{ $request_data->comment ?? ' ' }}</p>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label required">Date {{ $click_action }}:
                                        <b>{{ date('d-m-Y') }}</b></label>
                                </div>
                                <div class="col-6">
                                    <label for="comment" class="form-label">Action </label>
                                    <select class="form-control form-select" wire:model="click_action"
                                        id="click_action">
                                        <option value="">Select</option>
                                        <option value="Received">Receive</option>
                                        <option value="Declined">Decline</option>
                                    </select>
                                </div>
                                <br>
                                <div class="mb-3 col-md-12">
                                    <label for="comment" class="form-label">Comment @if ($click_action == 'Declined')
                                            <small class="text-danger">Please give
                                                a comment as to why you declined the request</small>
                                        @endif </label>
                                    <textarea type="text" id="comment" class="form-control" name="comment"
                                        @if ($click_action == 'Declined') required @endif wire:model.defer="approver_comment"></textarea>
                                    @error('approver_comment')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"
                                wire:click="close()">{{ __('public.close') }}</button>
                            <x-button type="submit" class="btn-success btn-sm">{{ __('Done') }}</x-button>
                        </div><!--end modal-footer-->
                    </form>
                @else
                    <h5 class="text-center">No action needed</h5>
                @endif
            @elseif($request_data->status == 'Proccessed')
            @else
                <h5 class="text-center">No action needed</h5>
            @endif
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->
