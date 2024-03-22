<div wire:ignore.self class="modal fade" id="updateCreateModal" tabindex="-1" role="dialog"
    aria-labelledby="updateCreateModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="updateCreateModalTitle">
                    @if (!$toggleForm)
                        New Category
                    @else
                        Edit Category
                    @endif
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()"
                    aria-label="Close"></button>
            </div>
            <!--end modal-header-->
            <form
                @if ($toggleForm) wire:submit.prevent="updateAssetCategory" @else wire:submit.prevent="storeAssetCategory" @endif>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="asset_classification_id" class="form-label">Classification</label>
                            <select class="form-select select2" id="asset_classification_id"
                                wire:model.defer="asset_classification_id">
                                <option selected value="">Select</option>
                                @foreach ($classifications as $classification)
                                    <option value="{{ $classification->id }}">{{ $classification->name }}</option>
                                @endforeach
                            </select>
                            @error('asset_classification_id')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="category" class="form-label">
                                Category
                            </label>
                            <input type="text" id="category" class="form-control" wire:model.defer="name">
                            @error('name')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div> <!-- end col -->

                        <div class="mb-3 col-md-12">
                            <label for="short_code" class="form-label">
                                Short Code
                            </label>
                            <input type="text" class="form-control" wire:model.defer="short_code">
                            @error('short_code')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div> <!-- end col -->

                        <div class="mb-3 col-md-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" rows="3" wire:model.defer="description"></textarea>
                            @error('description')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <!-- end row-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"
                        wire:click="close()">{{ __('public.close') }}</button>

                    @if ($toggleForm)
                        <x-button class="btn-success btn-sm">{{ __('public.update') }}</x-button>
                    @else
                        <x-button class="btn-success btn-sm">{{ __('public.save') }}</x-button>
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
