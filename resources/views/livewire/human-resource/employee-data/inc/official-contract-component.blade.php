<div>
    @include('livewire.human-resource.employee-data.inc.loading-info')

    <form wire:submit.prevent="storeOfficialContractInformation">
        <div class="row">
            <div class="mb-3 col-md-4">
                <label for="contract_summary" class="form-label required">Contract summary</label>
                <textarea type="text" id="contract_summary" class="form-control" wire:model.defer="contract_summary"></textarea>
                @error('contract_summary')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="salary" class="form-label required">Gross Salary</label>
                <input type="number" id="gsalary" class="form-control" wire:model.defer="gross_salary">
                @error('gross_salary')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>  

            <div class="mb-3 col-md-2">
                <label for="currency" class="form-label required">Currency</label>
                <select class="form-select select2" id="currency" wire:model.defer="currency">
                    <option selected value="">Select</option>
                    @include('layouts.currencies')
                </select>
                @error('currency')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="date7" class="form-label required">From</label>
                <input type="date" id="date1" class="form-control" wire:model.defer="start_date">
                @error('start_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="date8" class="form-label required">To</label>
                <input type="date" id="date2" class="form-control" wire:model.defer="end_date">
                @error('end_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="contract_file1{{$employee_id}}" class="form-label">Contract</label>
                <input type="file" id="contract_file1{{$employee_id}}" class="form-control" wire:model.lazy="contract_file" accept=".pdf" >
                <div class="text-success text-small" wire:loading wire:target="contract_file">Uploading contract
                </div>
                @error('contract_file')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="modal-footer">
            <x-button class="btn-success">{{__('public.save')}}</x-button>
        </div>
    </form>
    
</div>
