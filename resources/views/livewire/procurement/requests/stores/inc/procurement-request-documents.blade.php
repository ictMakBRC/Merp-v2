<div>
    {{-- @include('livewire.procurement.requests.inc.loading-info') --}}
    <form wire:submit.prevent="storeDocument">
        <div class="row">
            {{-- <div class="mb-3 col-md-4">
                <label for="provider_id" class="form-label required">{{ __('Provider') }}</label>
                <select class="form-select" id="provider_id" wire:model.lazy="provider_id">
                    <option selected value="">Select</option>
                    @forelse ($providers as $provider)
                        <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                    @empty
                    @endforelse
                </select>
                @error('provider_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div> --}}

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

            {{-- <div class="mb-3 col-md-4">
                <label for="expires" class="form-label required">{{ __('Expires?') }}</label>
                <select class="form-select" id="expires" wire:model.lazy="expires">
                    <option selected value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                @error('expires')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div> --}}

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

            {{-- @if ($expires)
                <div class="mb-3 col-md-4">
                    <label for="expiry_date" class="form-label required">{{ __('Expiry Date') }}</label>
                    <input type="date" id="expiry_date" class="form-control" wire:model.defer="expiry_date">
                    @error('expiry_date')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>
            @endif --}}

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
