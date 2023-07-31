<div>
    @include('livewire.human-resource.employee-data.inc.loading-info')
    
    <form wire:submit.prevent="storeContactInformation">
        <div class="row">
            <div class="mb-3 col-md-4">
                <label for="contact_relationship" class="form-label required">Relationship To Contact</label>
                <select class="form-select select2" id="contact_relationship" wire:model.lazy="contact_relationship" required>
                    <option selected value="">Select</option>
                    @include('layouts.relationships')
            </select>
            @error('contact_relationship')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="contact_name" class="form-label required">Contact Name</label>
                <input type="text" id="contact_name" class="form-control" wire:model.defer='contact_name' required>
                @error('contact_name')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="contact_email" class="form-label">Email</label>
                <input wire:model.defer='contact_email' type="email" id="contact_email" class="form-control">
                @error('contact_email')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="contact_phone" class="form-label required">Phone Number</label>
                <input wire:model.defer='contact_phone' type="text" id="contact_phone" class="form-control" required>
                @error('contact_phone')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="contact_address" class="form-label required">Address</label>
                <input wire:model.defer='contact_address' type="text" id="contact_address" class="form-control" required>
                @error('contact_address')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="modal-footer">
            <x-button class="btn-success">{{__('public.save')}}</x-button>
        </div>
    </form>
    
</div>
