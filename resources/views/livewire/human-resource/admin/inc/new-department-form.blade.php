<div wire:ignore.self class="modal fade" id="updateCreateModal" tabindex="-1" role="dialog"
    aria-labelledby="updateCreateModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h6 class="modal-title m-0" id="updateCreateModalTitle">
                    @if (!$toggleForm)
                        New station
                    @else
                        Edit station
                    @endif
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()"
                    aria-label="Close"></button>
            </div>
            <!--end modal-header-->
            <form @if ($toggleForm) wire:submit="updateStation" @else wire:submit="storeStation" @endif>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label for="parent_deparment" class="form-label">Parent Department</label>
                            <select class="form-select" id="parent_deparment" name="parent_department">
                                <option selected value="">Select</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-8">
                            <label for="departmentName" class="form-label">
                                Department/Project/Unit Name
                            </label>
                            <input type="text" id="departmentName" class="form-control" name="department_name"
                                value="">
                            <input type="text" id="autonumber" hidden class="form-control" name="autonumber"
                                value="100">
                        </div> <!-- end col -->

                        <div class="mb-3 col-md-4">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" id="type" name="type">
                                <option selected value="">Select</option>
                                <option value='Department'>Department</option>
                                <option value='Unit'>Unit</option>
                                <option value='Sub-Unit'>Sub-Unit</option>
                                <option value='Laboratory'>Laboratory</option>
                                <option value='Project'>Project</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="prefix" class="form-label">
                                Prefix
                            </label>
                            <input type="text" id="prefix" class="form-control" name="prefix" value="">
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="is_active" class="form-label">Status</label>
                            <select class="form-select" id="is_active" name="status">
                                <option selected value="">Select</option>
                                <option value='Active'>Active</option>
                                <option value='Inactive'>Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                        </div>
                    </div>
                    <!-- end row-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"
                        wire:click="close()">{{ __('public.close') }}</button>

                    <x-button type="submit" class="btn-success btn-sm">
                        @if ($toggleForm)
                            {{ __('public.update') }} @else{{ __('public.save') }}
                        @endif
                    </x-button>

                </div>
                <!--end modal-footer-->
            </form>
        </div>
        <!--end modal-content-->
    </div>
    <!--end modal-dialog-->
</div>
<!--end modal-->
