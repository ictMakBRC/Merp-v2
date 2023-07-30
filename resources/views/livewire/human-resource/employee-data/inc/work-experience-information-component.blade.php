<div>
    <form>
        <div class="row">

            <div class="mb-3 col-md-3">
                <label for="date1" class="form-label required">From</label>
                <input type="date" id="date1" class="form-control" wire:model.defer="start_date" required>
            </div>
            
            <div class="mb-3 col-md-3">
                <label for="date2" class="form-label required">To</label>
                <input type="date" id="date2" class="form-control" wire:model.defer="end_date" required>
            </div>

            <div class="mb-3 col-md-6">
                <label for="company" class="form-label required">Company/Organisation/Office</label>
                <input type="text" id="company" class="form-control" wire:model.defer="company" required>
            </div>

            <div class="mb-3 col-md-5">
                <label for="position_held" class="form-label required">Position Held</label>
                <input type="text" id="position_held" class="form-control" wire:model.defer="position_held" required>
            </div>

            <div class="mb-3 col-md-2">
                <label for="employment_type" class="form-label required">Employment Type</label>
                <select class="form-select select2" id="employment_type" wire:model.lazy="employment_type" required>
                    <option selected value="">Select</option>
                    @include('layouts.employment-types')
                </select>
            </div>

            <div class="mb-3 col-md-3">
                <label for="monthly_salary" class="form-label required">Monthly Salary/Wage</label>
                <input type="number" id="monthly_salary" class="form-control" wire:model.defer="monthly_salary">
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

            <div class="mb-3 col-md-12">
                <label for="job-description" class="form-label">Key Responsibilities</label>
                <textarea type="text" id="job-description" rows="4" class="form-control" wire:model.defer="job_description"
                    placeholder="List Key Responsibilities"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <x-button class="btn-success">{{ __('public.save') }}</x-button>
        </div>
    </form>

</div>
