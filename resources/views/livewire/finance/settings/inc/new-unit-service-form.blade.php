<div wire:ignore.self class="modal fade" id="updateCreateModal" tabindex="-1" role="dialog"
    aria-labelledby="updateCreateModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="updateCreateModalTitle">
                    @if (!$toggleForm)
                        New Service
                    @else
                        Edit Service
                    @endif
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()"
                    aria-label="Close"></button>
            </div><!--end modal-header-->

            <form
                @if ($toggleForm) wire:submit.prevent="updateFmsService" @else wire:submit.prevent="storeFmsService" @endif>
                <div class="modal-body">
                    <div class="row">
                        @if (!$toggleForm)
                            @include('livewire.partials.project-department-toggle')
                        @endif
                        <div class="mb-3 col-md-4">
                            <label for="service_id" class="form-label required">{{ __('Service') }}</label>
                            <select class="form-select select2" id="service_id" wire:model.lazy="service_id">
                                <option selected value="">Select</option>
                                <option value=''>None</option>
                                @foreach ($available_services as $available_service)
                                    <option value="{{ $available_service->id }}">{{ $available_service->name }}</option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="sale_price" class="form-label required">Sale Price</label>
                            <input type="number" step="any" id="sale_price" class="form-control" name="sale_price"
                                required wire:model.defer="sale_price">
                            @error('sale_price')
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

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"
                        wire:click="close()">{{ __('public.close') }}</button>
                    @if ($toggleForm)
                        <x-button type="submit" class="btn-success btn-sm">{{ __('public.update') }}</x-button>
                    @else
                        <x-button type="submit" class="btn-success btn-sm">{{ __('public.save') }}</x-button>
                    @endif
                </div><!--end modal-footer-->
            </form>
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->
