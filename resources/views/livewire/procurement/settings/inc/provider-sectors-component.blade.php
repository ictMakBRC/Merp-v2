<div>
    <form wire:submit.prevent="storeCategories">
        <div class="row">
            <div class="mb-3 col-md-4">
                <label for="provider_id" class="form-label required">{{ __('Provider') }}</label>
                <select class="form-select" id="provider_id" wire:model.lazy="provider_id">
                    <option selected value="">Select</option>
                    <option value="cheque">Cheque</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
                @error('provider_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="modal-footer">
            <x-button type="submit" class="btn btn-success">{{ __('public.save') }}</x-button>
        </div>
    </form>
</div>
