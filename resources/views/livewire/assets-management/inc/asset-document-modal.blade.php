<div wire:ignore.self class="modal fade" id="assetDocumentModal" tabindex="-1" role="dialog"
    aria-labelledby="assetDocumentModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centere modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="assetDocumentModalTitle">
                    Asset Documents
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal"
                    aria-label="Close"><i class="ti ti-x"></i></button>
            </div>

            <div class="modal-body">
                <form wire:submit.prevent="storeDocument">
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label for="document_category" class="form-label required">{{ __('Document Category') }}</label>
                            <select class="form-select" id="document_category" wire:model.lazy="document_category">
                                <option selected value="">Select</option>
                                @forelse ($document_categories as $document_category)
                                    <option value="{{ $document_category->name }}">{{ $document_category->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('document_category')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-4">
                            <label for="document_name" class="form-label required">{{ __('Document Name') }}</label>
                            <input type="text" id="document_name" class="form-control" wire:model.defer="document_name">
                            @error('document_name')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-4">
                            <label for="document" class="form-label required">{{ __('Document file') }}</label>
                            <input type="file" id="document" class="form-control" wire:model.defer="document">
                            <div class="text-success text-small" wire:loading wire:target="document">Uploading document...</div>
                            @error('document')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 col-md-4">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea id="description" class="form-control" wire:model.defer="description"></textarea>
                            @error('description')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
            
                    <div class="modal-footer">
                        <x-button type="submit" class="btn btn-success">{{ __('public.save') }}</x-button>
                    </div>
                </form>
            </div>

        </div>
        <!--end modal-content-->
    </div>
    <!--end modal-dialog-->
</div>
<!--end modal-->
