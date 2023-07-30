<div>
    <form>
        <div class="row">

            <div class="mb-3 col-md-4">
                <label for="bank_name" class="form-label required">Bank Name</label>
                <input type="text" id="bank_name" class="form-control" wire:model.defer='bank_name'>
            </div>

            <div class="mb-3 col-md-4">
                <label for="branch" class="form-label required">Branch</label>
                <input type="text" id="branch" class="form-control" wire:model.defer='branch'>
            </div>

            <div class="mb-3 col-md-4">
                <label for="account_name" class="form-label required">Account Name</label>
                <input type="text" id="account_name" class="form-control" wire:model.defer='account_name'>
            </div>

            <div class="mb-3 col-md-4">
                <label for="account_number" class="form-label required">Account Number</label>
                <input type="text" id="account_number" class="form-control" wire:model.defer='account_number'>
            </div>

            <div class="mb-3 col-md-2">
                <label for="currency" class="form-label required">Currency</label>
                <select class="form-select select2" id="currency" wire:model.lazy='currency'>
                    <option selected value="">Select</option>
                    <option value="UGX">UGX</option>
                    <option value="USD">USD</option>
                    <option value="GBP">GBP</option>
                    <option value="EUR">EUR</option>
                </select>
            </div>

            <div class="mb-3 col-md-2">
                <label for="is_default" class="form-label required">Default Account</label>
                <select class="form-select select2" id="is_default" wire:model.lazy='is_default'>              
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
        </div>

        <div class="modal-footer">
            <x-button class="btn-success">Save</x-button>
        </div>
    </form>
    
</div>