<div x-cloak x-show="create_new">
    <form
        @if ($toggleForm) wire:submit.prevent="updateRequest" @else wire:submit.prevent="storeRequest" @endif>

        <div class="row">

            <div class="col-md-2">
                <div class="form-group select-placeholder">
                    <label for="recurring" class="form-label required">Request Type</label>
                    <select class="form-select" data-width="100%" name="request_type" wire:model='request_type'>
                        <option value="Normal">Normal</option>
                        <option value="Urgent">Urgent</option>
                    </select>
                </div>
                @error('request_type')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col">
                <label for="address" class="form-label">Description</label>
                <textarea id="description" class="form-control" wire:model.defer='description'></textarea>
                @error('description')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

        </div>
        <div class="modal-footer">
            <x-button class="btn btn-success">{{ __('create') }}</x-button>
        </div>
        <hr>
    </form>
    <hr>
</div>
