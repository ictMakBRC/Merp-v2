<div wire:ignore.self class="modal fade" id="confirmDelete" data-bs-backdrop="static"
data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">

      <h5 class="modal-title" id="staticBackdropLabel">{{ __('logistics.confirm_action') }}</h5>
      <button type="button" class="btn-close" wire:click="close()" data-bs-dismiss="modal"
      aria-hidden="true"></button>
    </div>
    <div class="modal-body">
      <h1 class="bx bx-error-alt"></h1>
      <h6>Are you sure you want to delete this entry?
        <br>This action is irreversible</h6>

    </div>
    <!-- end row-->
    <div class="modal-footer">
      <button type="button" wire:click.prevent="deleteEntry()"
      class="btn btn-success close-modal bx bx-tick-circle"
      data-dismiss="modal">{{ __('Yes') }}</button>
      <x-button type="button" class="btn btn-danger bx bx-x-circle" wire:click="close()"
      data-bs-dismiss="modal">{{ __('Close') }}</x-button>
    </div>
  </div>
</div> <!-- end modal content-->
</div> <!-- end modal dialog-->
