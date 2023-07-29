<div wire:ignore.self class="modal fade" id="updateCreateModal" tabindex="-1" role="dialog"
    aria-labelledby="updateCreateModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h6 class="modal-title m-0" id="updateCreateModalTitle">
                    @if (!$toggleForm)
                        New Department
                    @else
                        Edit Department
                    @endif
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()"
                    aria-label="Close"></button>
            </div>
            <!--end modal-header-->
            <form @if ($toggleForm) wire:submit.prevent="updateDepartment" @else wire:submit.prevent="storeDepartment" @endif>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label for="parent_deparment" class="form-label">Parent Department</label>
                            <select class="form-select" id="parent_deparment" wire:model.defer="parent_department">
                                <option selected value="">None</option>
                                @foreach ($parent_departments as $parentdeparment)
                                    <option value="{{$parentdeparment->id}}">{{$parentdeparment->name}}</option>
                                @endforeach
                            </select>
                            @error('parent_deparment')
                                    <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-8">
                            <label for="departmentName" class="form-label">
                                Department/Unit Name
                            </label>
                            <input type="text" id="departmentName" class="form-control" wire:model.defer="name">
                            @error('name')
                                    <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div> <!-- end col -->

                        <div class="mb-3 col-md-4">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" id="type" wire:model.defer="type">
                                <option selected value="">Select</option>
                                <option value='Department'>Department</option>
                                <option value='Unit'>Unit</option>
                                <option value='Sub-Unit'>Sub-Unit</option>
                                <option value='Laboratory'>Laboratory</option>
                            </select>
                            @error('type')
                                    <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="prefix" class="form-label">
                                Prefix
                            </label>
                            <input type="text" id="prefix" class="form-control" wire:model.defer="prefix">                            
                            @error('prefix')
                                    <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="is_active" class="form-label">Status</label>
                            <select class="form-select" id="is_active" wire:model.defer="is_active">
                                <option selected value="">Select</option>
                                <option value='1'>Active</option>
                                <option value='2'>Inactive</option>
                            </select>
                            @error('is_active')
                                    <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" rows="3" wire:model.defer="description"></textarea>
                        </div>
                        @error('description')
                                <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- end row-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"
                        wire:click="close()">{{ __('public.close') }}</button>

                        @if($toggleForm) 
                        <x-button type="submit"  class="btn-success btn-sm">{{ __('public.update') }}</x-button>
                         @else 
                         <x-button type="submit"  class="btn-success btn-sm">{{ __('public.save') }}</x-button>
                         @endif

                </div>
                <!--end modal-footer-->
            </form>
        </div>
        <!--end modal-content-->
    </div>
    <!--end modal-dialog-->
</div>
<!--end modal-->
