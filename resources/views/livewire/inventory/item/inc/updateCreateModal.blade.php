<div wire:ignore.self class="modal fade" id="updateCreateInvCommodityModal" tabindex="-1" role="dialog"
aria-labelledby="updateCreateInvCommodityModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
<div class="modal-dialog modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h6 class="modal-title m-0" id="updateCreateInvCommodityModalTitle">
        @if (!$toggleForm)
        New Commodity
        @else
        Update Commodity
        @endif
      </h6>
      <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()" aria-label="Close"></button>
    </div><!--end modal-header-->

    <form  @if (!$toggleForm) wire:submit.prevent="storeData" @else wire:submit.prevent="updateData" @endif >

      <div class="modal-body">
        <div class="row">

          <div class="mb-3 col-md-6">
            <label for="category" class="form-label" required>Category</label>
            <select class="form-select" wire:model.defer="category_id">

              <option value="">Select...</option>
              @foreach ($categories as $key => $value)
              <option value="{{$value->id}}">{{$value->name}}</option>
              @endforeach
            </select>
            @error('name')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-6" required>
            <label for="uom_id" class="form-label">Unit Of Measure</label>
            <select class="form-select" wire:model.defer="uom_id">
              <option value="">Select...</option>
              @foreach ($uoms as $key => $value)
              <option value="{{$value->id}}">{{$value->name}}</option>
              @endforeach
            </select>
            @error('name')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-6" required>
            <label for="item_code" class="form-label">Item Code</label>
            <input type="text" id="category" class="form-control" wire:model.defer="item_code">
            @error('item_code')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-6" required>
            <label for="name" class="form-label">Commodity</label>
            <input type="text" id="category" class="form-control" wire:model.defer="name">
            @error('name')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" rows="3" wire:model.defer="description"></textarea>
            @error('description')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-3" required>
            <label for="min_qty" class="form-label">Min Stock Qty</label>
            <input type="number" class="form-control" min="0" wire:model.defer="min_qty">
            @error('min_qty')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror

            <div class="custom-control custom-switch mb-3 col-md-12">
              <input type="checkbox" class="custom-control-input"  wire:model="expires" checked>
              <label class="custom-control-label" for="customSwitch1">Item Expires <i style="color:gray">(Uncheck if false)</i></label>
            </div>
            </div>


          <div class="mb-3 col-md-3" required>
            <label for="max_qty" class="form-label">Max Stock Qty</label>
            <input type="number" class="form-control" min="1" wire:model.defer="max_qty">
            @error('max_qty')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" wire:click="close()" >{{ __('public.close') }}</button>
        @if($toggleForm)
        <x-button type="submit"  class="btn-success btn-sm">{{ __('public.update') }}</x-button>
        @else
        <x-button type="submit"  class="btn-success btn-sm">{{ __('public.save') }}</x-button>
        @endif
      </div><!--end modal-footer-->

  </div><!--end modal-content-->
</div><!--end modal-dialog-->
</form>
</div><!--end modal-->
