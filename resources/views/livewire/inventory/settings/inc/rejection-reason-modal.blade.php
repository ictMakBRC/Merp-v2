<div wire:ignore.self class="modal fade" id="rejectionReasonModal" data-bs-backdrop="static"
data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">

      <h5 class="modal-title" id="staticBackdropLabel">{{ __('Reject Reason') }}</h5>
      <button type="button" class="btn-close" wire:click="close()" data-bs-dismiss="modal"
      aria-hidden="true"></button>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="mb-3 col-md-12">
          <label for="rejection_reason" class="form-label required">Rejection Reason</label>
          <input type="text" class="form-control" wire:model.defer="rejection_reason">

          @error('rejection_reason')
          <div class="text-danger text-small">{{ $message }}</div>
          @enderror
        </div>
      </div>
    </div>
    <!-- end row-->
    <div class="modal-footer">
      <button type="button" wire:click.prevent="storeData"
      class="btn btn-success close-modal bx bx-tick-circle">{{ __('Save') }}</button>
      <x-button type="button" class="btn btn-danger bx bx-x-circle" wire:click="close()"
      data-bs-dismiss="modal">{{ __('Close') }}</x-button>
    </div>
  </div>
</div> <!-- end modal content-->
</div> <!-- end modal dialog-->
