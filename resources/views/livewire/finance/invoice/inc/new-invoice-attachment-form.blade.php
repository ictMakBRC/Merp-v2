
    <form  wire:submit.prevent="saveAttachment">

        <div class="row">
            <div class="mb-3 col col-12 col col-sm-4">
                <label for="invoice_to" class="form-label required">Attachment</label>
             <input type="file" wire:model='file_upload' name="file" id="file_upload" class="form-control">
             <div class="text-success text-small" wire:loading wire:target="file_upload">
                Uploading file...</div>
                @error('file_upload')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col">
                <label for="address" class="form-label">Description</label>
                <textarea id="file_name" class="form-control text-uppercase" wire:model='file_name'></textarea>
                @error('file_name')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

        </div>
        <div class="modal-footer">
            <x-button class="btn btn-success">{{ __('Upload') }}</x-button>
        </div>
        <hr>
    </form>
    <hr>
<!-- Trigger download from Blade view -->
<button wire:click="downloadAttachment({{ $invoice_data->id }})">Download Attachment</button>
