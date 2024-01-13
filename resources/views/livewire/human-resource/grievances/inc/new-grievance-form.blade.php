<div x-cloak x-show="create_new">
    <form
        @if ($toggleForm) wire:submit.prevent="updateData" @else wire:submit.prevent="storeData" @endif>

    <div class="row">
            <div class="mb-3 col-4">
                <label for="grievance_type_id" class="form-label required">Grievance Type</label>
                <select id="grievance_type_id" class="form-control form-select" name="grievance_type_id" required
                    wire:model="grievance_type_id">
                    <option value="">Select</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                @error('grievance_type_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-4">
                <label for="addressee" class="form-label required">Adressee</label>
                <select id="addressee"  class="form-select" wire:model.defer='addressee'>
                    <option value="">Select</option>
                    <option value="Administration">Administration</option>
                    <option value="Department">Department</option>
                    <option value="Both">Both</option>
                </select>
                @error('addressee')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-4">
                <label for="file_upload" class="form-label required">Attachment</label>
                <input type="file" id="file_upload"  class="form-control" wire:model='file_upload'>
                @error('file_upload')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
                <div class="text-success text-small" wire:loading wire:target="file_upload">
                    Uploading file...</div>
            </div>

            <div class="mb-3 col-4">
                <label for="subject" class="form-label required">Subject</label>
                <input type="text" id="subject"  class="form-control" wire:model.defer='subject'>
                @error('subject')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3 col-8">
                <label for="address" class="form-label">Comment</label>
                <textarea id="comment" class="form-control text-uppercase"
                    wire:model.defer='comment'></textarea>
                @error('comment')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

        </div>
        <div class="modal-footer">
            <x-button class="btn btn-success">{{ __('Save') }}</x-button>
        </div>
        <hr>
    </form>
    <hr>
</div>
