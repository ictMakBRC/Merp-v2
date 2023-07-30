<div>
    <form>
        <div class="row">
            <div class="mb-3 col-md-4">
                <label for="contract_summary" class="form-label required">Contract summary</label>
                <textarea type="text" id="contract_summary" class="form-control" wire:model.defer="contract_summary" required></textarea>
            </div>

            <div class="mb-3 col-md-2">
                <label for="salary" class="form-label">Gross Salary</label>
                <input type="number" id="gsalary" class="form-control" wire:model.defer="gross_salary" required>
            </div>  

            <div class="mb-3 col-md-2">
                <label for="currency" class="form-label required">Currency</label>
                <select class="form-select select2" id="currency" wire:model.defer="currency" required>
                    <option selected value="">Select</option>
                    <option value="UGX">UGX</option>
                    <option value="USD">USD</option>
                    <option value="GBP">GBP</option>
                    <option value="EUR">EUR</option>
                </select>
            </div>

            <div class="mb-3 col-md-2">
                <label for="date7" class="form-label required">From</label>
                <input type="date" id="date1" class="form-control" wire:model.defer="start_date" required>
            </div>

            <div class="mb-3 col-md-2">
                <label for="date8" class="form-label required">To</label>
                <input type="date" id="date2" class="form-control" wire:model.defer="end_date" required>
            </div>

            <div class="mb-3 col-md-4">
                <label for="contract_file1" class="form-label">Contract</label>
                <input type="file" id="contract_file1" class="form-control" wire:model.defer="contract_file" accept=".pdf" >
            </div>
        </div>

        <div class="modal-footer">
            <x-button class="btn-success">{{__('public.save')}}</x-button>
        </div>
    </form>
    
</div>
