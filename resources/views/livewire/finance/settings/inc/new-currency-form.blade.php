<div wire:ignore.self class="modal fade" id="updateCreateModal" tabindex="-1" role="dialog" aria-labelledby="updateCreateModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="updateCreateModalTitle">
                    @if (!$toggleForm)
                        New Account Subtype
                    @else
                        Edit Subtype
                    @endif
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()" aria-label="Close"></button>
            </div><!--end modal-header-->     
            
            <form  @if ($toggleForm) wire:submit.prevent="updateFmsCurrency" @else wire:submit.prevent="storeFmsCurrency" @endif >             
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-8">
                            <label for="name" class="form-label required">Name</label>
                            <input type="text" id="name" class="form-control" name="name" required
                                wire:model.defer="name">
                            @error('name')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="exchange_rate" class="form-label required">Short Code</label>
                            <input type="text" id="code" class="form-control" name="code" required
                                wire:model.defer="code">
                            @error('code')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="is_active" class="form-label required">{{ __('public.status') }}</label>
                            <select class="form-select select2" id="is_active" wire:model.defer="is_active">
                                <option selected value="">Select</option>
                                <option value='1'>Active</option>
                                <option value='0'>Inactive</option>
                            </select>
                            @error('is_active')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3 col-md-4">
                            <label for="system_default" class="form-label required">{{ __('System Default') }}</label>
                            <select class="form-select select2" id="system_default" wire:model.defer="system_default">
                                <option selected value="">Select</option>
                                <option value='1'>Yes</option>
                                <option value='0'>No</option>
                            </select>
                            @error('system_default')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3 col-md-4">
                            <label for="exchange_rate" class="form-label required">Exchange Rate</label>
                            <input type="text" id="exchange_rate" class="form-control" name="exchange_rate" required
                                wire:model.defer="exchange_rate">
                            @error('exchange_rate')
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
            </form>
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->