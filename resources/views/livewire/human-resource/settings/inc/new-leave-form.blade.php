<div wire:ignore.self class="modal fade" id="updateCreateModal" tabindex="-1" role="dialog"
    aria-labelledby="updateCreateModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="updateCreateModalTitle">
                    @if (!$toggleForm)
                        New Leave
                    @else
                        Edit Leave
                    @endif
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()"
                    aria-label="Close"></button>
            </div>
            <!--end modal-header-->
            <form @if ($toggleForm) wire:submit.prevent="updateLeave" @else wire:submit.prevent="storeLeave" @endif>
                <div class="modal-body">                    
                    <div class="row">
                        <div class="row col-md-12">
                            <div class="mb-3 col-md-4">
                                <label for="leaveName" class="form-label required">Name</label>
                                <input type="text" id="leaveName" class="form-control"  wire:model.defer="name" required>
                                @error('name')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-2">
                                <label for="duration" class="form-label required">Days</label>
                                <input type="number" id="duration" class="form-control"  wire:model.defer="duration" required>
                                @error('duration')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="carry_forward" class="form-label required">Carry Foward</label>
                                <select class="form-select" id="carry_forward"  wire:model.defer="carriable" required>
                                    <option selected value="">Select</option>
                                    <option value='No'>No</option>
                                    <option value='Yes'>Yes</option>
                                </select>
                                @error('carry_forward')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="is_payable" class="form-label required">Paid?</label>
                                <select class="form-select" id="is_payable"  wire:model.defer="is_payable" required>
                                    <option selected value="">Select</option>
                                    <option value='Yes'>Yes</option>
                                    <option value='No'>No</option>
                                </select>
                                @error('is_payable')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>

                        </div> <!-- end col -->
                        <div class="row col-md-12">
                            <div class="mb-3 col-md-3">
                                <label for="payment_type" class="form-label required">Payment Type</label>
                                <select class="form-select" id="payment_type"  wire:model.defer="payment_type" required>
                                    <option selected value="">Select</option>
                                    <option value='Full Pay'>Full Pay</option>
                                    <option value='Half Pay'>Half Pay</option>
                                    <option value='Quarter Pay'>Quarter Pay</option>
                                    <option value='No Pay'>No Pay</option>
                                </select>
                                @error('payment_type')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="given_to" class="form-label required">Given To</label>
                                <select class="form-select" id="given_to"  wire:model.defer="given_to" required>
                                    <option selected value="">Select</option>
                                    <option value='All'>All</option>
                                    <option value='Male'>Male</option>
                                    <option value='Female'>Female</option>
                                </select>
                                @error('given_to')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="notice_days" class="form-label required">Notice Days</label>
                                <input type="number" id="notice_days" class="form-control"  wire:model.defer="notice_days" required>                                
                                @error('notice_days')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="is_active" class="form-label required">Status</label>
                                <select class="form-select" id="is_active"  wire:model.defer="is_active" required>
                                    <option selected value="">Select</option>
                                    <option value='1'>Active</option>
                                    <option value='0'>Inactive</option>
                                </select>
                                @error('is_active')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="details" class="form-label">Details</label>
                                <textarea class="form-control" id="details" rows="5"  wire:model.defer="details"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end row-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"
                        wire:click="close()">{{ __('public.close') }}</button>

                    <x-button type="submit" class="btn-success btn-sm">
                        @if ($toggleForm)
                            {{ __('public.update') }} @else{{ __('public.save') }}
                        @endif
                    </x-button>

                </div>
                <!--end modal-footer-->
            </form>
        </div>
        <!--end modal-content-->
    </div>
    <!--end modal-dialog-->
</div>
<!--end modal-->
