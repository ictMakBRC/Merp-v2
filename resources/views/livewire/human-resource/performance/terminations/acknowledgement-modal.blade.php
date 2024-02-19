<div wire:ignore.self class="modal fade" id="acknowledge_modal" tabindex="-1" role="dialog"
    aria-labelledby="acknowledgeModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h6 class="modal-title m-0" id="acknowledgeModalTitle">
                    Acknowledge the receipt of this termination
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()"
                    aria-label="Close"></button>
            </div>
            <!--end modal-header-->
            <div class="modal-body">
                <div class="row">
                    <div class="mb-3 col-md-12">
                        <label for="description" class="form-label">Additional Comment</label>
                        <textarea type="text" id="additional_comment" rows="4" class="form-control"
                            wire:model.defer="additional_comment" placeholder="This is noted">
                    </textarea>

                        @error('additional_comment')
                        <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-bs-dismiss="modal" wire:click="close()">{{
                    __('public.close') }}</button>

                <x-button type="click" wire:click="store" class="btn-danger btn-sm">Confirm</x-button>

            </div>
            <!--end modal-footer-->
        </div>
        <!--end modal-content-->
    </div>
    <!--end modal-dialog-->
</div>