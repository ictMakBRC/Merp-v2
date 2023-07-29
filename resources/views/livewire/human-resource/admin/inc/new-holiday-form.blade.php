<div wire:ignore.self class="modal fade" id="updateCreateModal" tabindex="-1" role="dialog" aria-labelledby="updateCreateModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h6 class="modal-title m-0" id="updateCreateModalTitle">
                    @if (!$toggleForm)
                        New Designation
                    @else
                        Edit Designation
                    @endif
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()" aria-label="Close"></button>
            </div><!--end modal-header-->            
           
            
                <form  @if ($toggleForm) wire:submit.prevent="updateHoliday" @else  wire:submit.prevent="storeHoliday" @endif>             
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="holidayName" class="form-label">Holiday Name</label>
                                    <input type="text" id="holidayName" class="form-control" wire:model.defer="title" required>
                                </div>
                            </div> <!-- end col -->
                            <div class="mb-3 col-md-6">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-select" id="type" wire:model.defer="holiday_type" required>
                                    <option selected value="">Select</option>
                                    <option value='Annual Holiday'>Annual Holiday</option>
                                    <option value='Irregular Holiday'>Irregular Holiday</option>
                                </select>
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
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="date" id="startDate" class="form-control" wire:model.defer="start_date" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="endDate" class="form-label">End Date</label>
                                <input type="date" id="endDate" class="form-control" wire:model.defer="end_date">
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="details" class="form-label">Details</label>
                                <textarea class="form-control" id="details" rows="3" wire:model.defer="details"></textarea>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" wire:click="close()" >{{ __('public.close') }}</button>
                        
                        <x-button type="submit"  class="btn-success btn-sm">@if($toggleForm)  {{ __('public.update') }} @else  {{ __('public.save') }} @endif </x-button>
                        
                    </div><!--end modal-footer-->
            </form>
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->