<div>
    <form wire:submit.prevent="storeDocument">
        <div class="row">
            <div class="mb-3 col-md-4">
                <label for="grant_profile_id" class="form-label required">{{ __('Grant') }}</label>
                <select class="form-select" id="grant_profile_id" wire:model.lazy="grant_profile_id">
                    <option selected value="">Select</option>
                    <option value="cheque">Cheque</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
                @error('grant_profile_id')
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
