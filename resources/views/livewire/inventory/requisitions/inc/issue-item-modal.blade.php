<div wire:ignore.self class="modal fade" id="issueItemModal" tabindex="-1" role="dialog"
aria-labelledby="deptItemupdateCreateModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
<div class="modal-dialog modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h6 class="modal-title m-0" id="deptItemupdateCreateModalTitle">
        @if (!$toggleForm)
      Issue / Allocate Item
        @else
        Update Allocation
        @endif

      </h6>
      <button type="button" class="btn-close text-danger" wire:click="close()" aria-label="Close"></button>
    </div><!--end modal-header-->

    <div class="modal-body">
        <div class="col-md-12">
        <div class="row">
          <div class="col-md-4">

            <label for="request_code" class="form-label">Request Code</label>
            <input type="text" class="form-control" wire:model.defer="request_code" readonly>
          </div>

          <div class="mb-3 col-md-4">
            <label for="order_date" class="form-label">Request Date</label>
            <input type="text" class="form-control" wire:model.defer="order_date" readonly>
          </div>

          <div class="mb-3 col-md-4">
            <label for="department_id" class="form-label">Deparment</label>
            <input type="text" class="form-control" wire:model.defer="department_id" readonly>
          </div>

          <div class="mb-3 col-md-4">
            <label for="item_id" class="form-label">Item</label>
            <input type="text" class="form-control" wire:model.defer="item_id" readonly>
          </div>

          <div class="mb-3 col-md-2">
            <label for="quantity_required" class="form-label">Qty Required</label>
            <input type="number" class="form-control" wire:model.defer="quantity_required" readonly>
          </div>

          <div class="mb-3 col-md-2">
            <label for="stock_balance" class="form-label">Stock Balance</label>
            <input type="number" class="form-control" wire:model.defer="stock_balance" readonly>
          </div>

          <div class="mb-3 col-md-4">
            <label for="quantity_dispatched" class="form-label required"> Qty Dispatched </label>
            <input type="number" class="form-control" wire:model.defer="quantity_dispatched" min='1'>
            @error('quantity_dispatched')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>


          <div class="mb-3 col-md-6">
            <label for="dispatch_comment" class="form-label">Comment</label>
            <textarea  wire:model.defer="dispatch_comment" rows="2" cols="48"></textarea>
          </div>
        </div>
        </div>


      </div><!--end modal-body-->

        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" wire:click="close()" >{{ __('public.close') }}</button>
          @if($toggleForm)
          <x-button type="submit"  class="btn-success btn-sm">{{ __('public.update') }}</x-button>
          @else
          <x-button type="submit" wire:click="saveIssueStock" class="btn-success btn-sm">{{ __('Submit') }}</x-button>
          @endif
        </div><!--end modal-footer-->

  </div><!--end modal-content-->

</div><!--end modal-dialog-->
</div><!--end modal-->
