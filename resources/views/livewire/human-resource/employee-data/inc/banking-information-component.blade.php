<div>
    @include('livewire.human-resource.employee-data.inc.loading-info')
    
    <form wire:submit.prevent="storeBankingInformation">
        <div class="row">

            <div class="mb-3 col-md-4">
                <label for="bank_name" class="form-label required">Bank Name</label>
                <input type="text" id="bank_name" class="form-control" wire:model.defer='bank_name'>
                @error('bank_name')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="branch" class="form-label required">Branch</label>
                <input type="text" id="branch" class="form-control" wire:model.defer='branch'>
                @error('branch')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="account_name" class="form-label required">Account Name</label>
                <input type="text" id="account_name" class="form-control" wire:model.defer='account_name'>
                @error('account_name')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="account_number" class="form-label required">Account Number</label>
                <input type="text" id="account_number" class="form-control" wire:model.defer='account_number'>
                @error('account_number')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="currency_id" class="form-label required">Currency</label>
                <select class="form-select select2" id="currency_id" wire:model.lazy='currency_id'>
                    <option selected value="">Select</option>
                    @include('layouts.currencies')
                </select>
                @error('currency_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="is_default" class="form-label required">Is default account?</label>
                <select class="form-select select2" id="is_default" wire:model.lazy='is_default'>
                    <option value="" selected>Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                @error('is_default')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="modal-footer">
            <x-button class="btn btn-success">{{ __('public.save') }}</x-button>
        </div>
    </form>

</div>
