<div wire:ignore.self class="modal fade" id="deptItemupdateCreateModal" tabindex="-1" role="dialog"
aria-labelledby="deptItemupdateCreateModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
<div class="modal-dialog modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h6 class="modal-title m-0" id="deptItemupdateCreateModalTitle">
        @if (!$toggleForm)
        Add Department Item
        @else
        Update Department Item
        @endif
      </h6>
      <!-- <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()" aria-label="Close"></button> -->
      <button type="button" class="btn-close text-danger" wire:click="close()" aria-label="Close"></button>
    </div><!--end modal-header-->

    <div class="modal-body">
      <form  @if (!$toggleForm) wire:submit.prevent="storeData" @else wire:submit.prevent="updateData" @endif >
        <div class="row">

          <div class="mb-3 col-md-3  col-sm-3">
            <label for="entry_type" class="form-label required">Entry Unit Type</label>
            <select class="form-control form-select" id="entry_type" wire:model='entry_type'>
                <option selected value="">Select</option>
                <option value="Department">Department</option>
                <option value="Project">Project</option>
            </select>
            @error('entry_type')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>
          <div class="mb-3 col-md-4">
            <label for="unit_id" class="form-label" required>Unit</label>
            <select class="form-select" wire:model.defer="unit_id" required>

              <option value="">Select...</option>
              @foreach ($departments as $key => $value)
              <option value="{{$value->id}}">{{$value->name}}</option>
              @endforeach
            </select>
            @error('unit_id')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-5" required>
            <label for="item_id" class="form-label">Commodity</label>
            <select class="form-select" wire:model.defer="item_id">
              <option value="">Select...</option>
              @foreach ($items as $key => $value)
              <option value="{{$value->id}}">{{$value->name}}</option>
              @endforeach
            </select>
            @error('item_id')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-6" required>
            <label for="brand" class="form-label">Brand</label>
            <input type="text" id="category" class="form-control" wire:model.defer="brand">
            @error('brand')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-6" required>
            <label for="is_active" class="form-label">Status</label>
            <select class="form-select" wire:model.defer="is_active">
              <option value="1"selected>Active</option>
              <option value="0">Inactive</option>
            </select>

            @error('is_active')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
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

      </div><!--end modal-body-->
    </form>
  </div><!--end modal-content-->
</div><!--end modal-dialog-->
</div><!--end modal-->
