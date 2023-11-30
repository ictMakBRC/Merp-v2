<div wire:ignore.self class="modal fade" id="updateCreateInvCommodityModal" tabindex="-1" role="dialog"
aria-labelledby="updateCreateInvCommodityModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
<div class="modal-dialog modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h6 class="modal-title m-0" id="updateCreateInvCommodityModalTitle">
        @if ($createNew)
        New Supplier
        @else
        Update Supplier
        @endif
      </h6>
      <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()" aria-label="Close"></button>
    </div><!--end modal-header-->

    <form  @if ($createNew) wire:submit.prevent="storeData" @else wire:submit.prevent="updateData" @endif >

      <div class="modal-body">

        <div class="row">
          <div class="mb-3 col-md-6" required>
            <label for="name" class="form-label">Supplier Name</label>
            <input type="text" class="form-control" wire:model.defer="name">
            @error('name')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-6" required>
            <label for="contact" class="form-label">Telephone Contact</label>
            <input type="text" class="form-control" wire:model.defer="contact">
            @error('contact')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-6" required>
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" wire:model.defer="email">
            @error('email')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

            <div class="mb-3 col-md-6">
              <label for="address" class="form-label">Physical Address</label>
              <textarea class="form-control" rows="3" wire:model.defer="address"></textarea>
              @error('address')
              <div class="text-danger text-small">{{ $message }}</div>
              @enderror
            </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">{{ __('public.close') }}</button>
        @if(!$createNew)
        <x-button type="submit"  class="btn-success btn-sm">{{ __('public.update') }}</x-button>
        @else
        <x-button type="submit"  class="btn-success btn-sm">{{ __('public.save') }}</x-button>
        @endif
      </div><!--end modal-footer-->

    </div><!--end modal-content-->
  </div><!--end modal-dialog-->
</form>
</div><!--end modal-->
