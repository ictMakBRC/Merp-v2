<div x-cloak x-show="create_new">
    <form wire:submit.prevent="storeSubcategory">
        <div class="row">
            <div class="mb-3 col-md-3">
                <label for="category" class="form-label required">{{ __('Sector/Category') }}</label>
                <select class="form-select" id="category" wire:model.lazy="category">
                    <option selected value="">Select</option>
                    <option value="Supplies">Supplies</option>
                    <option value="Services">Services</option>
                    <option value="Works">Works</option>
                    <option value="Consultancy">Consultancy</option>
                </select>
                @error('category')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label for="name" class="form-label required">{{ __('Subcategory') }}</label>
                <input type="text" id="name" class="form-control" wire:model.defer="name">
                @error('name')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="is_active" class="form-label required">{{ __('Status') }}</label>
                <select class="form-select" id="is_active" wire:model.lazy="is_active">
                    <option selected value="">Select</option>
                    <option value="1">Active</option>
                    <option value="0">Suspended</option>
                </select>
                @error('is_active')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="modal-footer">
            <x-button type="submit" class="btn btn-success">{{ __('public.save') }}</x-button>
        </div>
    </form>
    <hr>
</div>
