<div>
    @include('livewire.human-resource.employee-data.inc.loading-info')
    
    <form>
        <div class="row">
            <div class="mb-3 col-md-4">
                <label for="contact_relationship" class="form-label required">Relationship To Contact</label>
                <select class="form-select select2" id="contact_relationship" wire:model.lazy="contact_relationship" required>
                    <option selected value="">Select</option>
                    @include('layouts.relationships')
            </select>
            </div>

            <div class="mb-3 col-md-4">
                <label for="contact_name" class="form-label required">Contact Name</label>
                <input type="text" id="contact_name" class="form-control" wire:model.defer='contact_name' required>
            </div>

            <div class="mb-3 col-md-4">
                <label for="contact_email" class="form-label">Email</label>
                <input wire:model.defer='contact_email' type="email" id="contact_email" class="form-control">
            </div>

            <div class="mb-3 col-md-4">
                <label for="contact_phone" class="form-label required">Phone Number</label>
                <input wire:model.defer='contact_phone' type="text" id="contact_phone" class="form-control" required>
            </div>

            <div class="mb-3 col-md-4">
                <label for="contact_address" class="form-label required">Address</label>
                <input wire:model.defer='contact_address' type="text" id="contact_address" class="form-control" required>
            </div>
        </div>

        <div class="modal-footer">
            <x-button class="btn-success">{{__('public.save')}}</x-button>
        </div>
    </form>
    
</div>
