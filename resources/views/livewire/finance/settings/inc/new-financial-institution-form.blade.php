<div wire:ignore.self class="modal fade" id="updateCreateModal" tabindex="-1" role="dialog" aria-labelledby="updateCreateModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="updateCreateModalTitle">
                    @if (!$toggleForm)
                        New Institution
                    @else
                        Edit Institution
                    @endif
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()" aria-label="Close"></button>
            </div><!--end modal-header-->

            <div class="modal-body">
            <form  @if ($toggleForm) wire:submit.prevent="updateInstitution" @else wire:submit.prevent="storeInstitution" @endif >
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label required">Name</label>
                            <input type="text" id="name" class="form-control" name="name" required
                                wire:model.defer="name">
                            @error('name')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="code" class="form-label required">Short Code</label>
                            <input type="text" id="contact" class="form-control" name="code" required
                                wire:model.lazy="code">
                            @error('code')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-8">
                            <label for="contact" class="form-label required">Contact</label>
                            <input type="text" id="contact" class="form-control" name="contact" required
                                wire:model.defer="contact">
                            @error('contact')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="type" class="form-label required">{{ __('Type') }}</label>
                            <select class="form-select select2" id="type" wire:model.defer="type">
                                <option selected value="">Select</option>
                                <option value="Bank">Bank</option>                              
                            </select>
                            @error('type')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
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
                        <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Address</label>
                            <textarea  id="description" class="form-control"
                            name="address" wire:model.defer="address"></textarea>
                            @error('address')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="countryName" class="form-label">Description</label>
                            <textarea  id="description" class="form-control"
                            name="description" wire:model.defer="description"></textarea>
                            @error('description')
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
              </div>
            </form>
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->
