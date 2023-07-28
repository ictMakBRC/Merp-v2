<div wire:ignore.self class="modal fade" id="createNewModal" tabindex="-1" role="dialog" aria-labelledby="createNewModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h6 class="modal-title m-0" id="createNewModalTitle">
                    @if (!$toggleForm)
                        New station
                    @else
                        Edit station
                    @endif
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()" aria-label="Close"></button>
            </div><!--end modal-header-->            
           
               
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="name" class="form-label required">Name</label>
                                <input type="text" id="name" class="form-control" name="name" required
                                    wire:model="name">
                                @error('name')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="countryName" class="form-label">Description</label>
                                <textarea  id="description" class="form-control"
                                name="description" wire:model="description"></textarea>
                                @error('description')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="is_active" class="form-label required">{{ __('public.status') }}</label>
                                <select class="form-select select2" id="is_active" wire:model="is_active">
                                    <option selected value="">Select</option>
                                    <option value='1'>Active</option>
                                    <option value='0'>Inactive</option>
                                </select>
                                @error('is_active')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" wire:click="close()" >{{ __('public.close') }}</button>
                        @if(!$toggleForm) 
                        <button type="button" wire:click="storeStation" class="btn-success btn-sm">{{ __('public.save') }}</button>
                         @else 
                         <button type="button" wire:click="updateStation" class="btn-success btn-sm">{{ __('public.update') }}</button>
                         @endif
                    </div><!--end modal-footer-->
                </form>
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->