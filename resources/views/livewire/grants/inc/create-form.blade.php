<div>
    <form wire:submit.prevent="storeGrantProfile">
        <div class="row">
            <div class="mb-3 col-md-4">
                <label for="grant_code" class="form-label required">{{ __('Grant Code') }}</label>
                <input type="text" id="grant_code" class="form-control" wire:model.defer="grant_code">
                @error('grant_code')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-8">
                <label for="name" class="form-label required">{{ __('Name') }}</label>
                <input type="text" id="name" class="form-control" wire:model.defer="name">
                @error('name')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="grant_type" class="form-label required">{{ __('Grant/Proposal Type') }}</label>
                <select class="form-select" id="grant_type" wire:model.lazy="grant_type">
                    <option selected value="">Select</option>
                    <option value="research">Research Grant</option>
                    <option value="health_medical">Health and Medical Research Grant</option>
                    <option value="education">Education Grant</option>
                    <option value="equipment">Equipment Grant</option>
                    <option value="training">Training Grant</option>
                    <option value="program_development">Program Development Grant</option>
                    <option value="community_outreach">Community Outreach Grant</option>
                    <option value="capacity_building">Capacity Building Grant</option>
                    <option value="international_collaboration">International Collaboration Grant</option>
                    <option value="environmental">Environmental Grant</option>
                    <option value="humanitarian">Humanitarian Grant</option>
                    <option value="technology_innovation">Technology Innovation Grant</option>
                    <option value="innovation_entrepreneurship">Innovation and Entrepreneurship Grant</option>
                    <option value="arts_culture">Arts and Culture Grant</option>
                    <option value="travel">Travel Grant</option>
                </select>
                @error('grant_type')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-5">
                <label for="funding_source" class="form-label">{{ __('Funding Source') }}</label>
                <input type="text" id="funding_source" class="form-control" wire:model.defer="funding_source">
                @error('funding_source')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="funding_amount" class="form-label">{{ __('Funding Amount') }}</label>
                <input type="number" id="funding_amount" class="form-control" wire:model.defer="funding_amount" step="0.01">
                @error('funding_amount')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="currency" class="form-label">{{ __('Currency') }}</label>
                <select class="form-select" id="currency" wire:model.lazy="currency">
                    <option selected value="">Select</option>
                    @include('layouts.currencies')
                </select>
                @error('currency')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" id="start_date" class="form-control" wire:model.defer="start_date">
                @error('start_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" id="end_date" class="form-control" wire:model.defer="end_date">
                @error('end_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="proposal_submission_date" class="form-label required">Proposal Submission Date</label>
                <input type="date" id="proposal_submission_date" class="form-control" wire:model.defer="proposal_submission_date">
                @error('proposal_submission_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="pi" class="form-label required">{{ __('Principal Investigator') }}</label>
                <select class="form-select" id="pi" wire:model.lazy="pi">
                    <option selected value="">Select</option>
                    <option value="1">Research Grant</option>
                    <option value="2">Health and Medical Research Grant</option>
                </select>
                @error('pi')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label for="notes" class="form-label">{{ __('Proposal Summary') }}</label>
                <textarea id="notes" class="form-control" wire:model.defer="notes"></textarea>
                @error('notes')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="award_status" class="form-label required">{{ __('Status') }}</label>
                <select class="form-select" id="award_status" wire:model.lazy="award_status">
                    <option selected value="">Select</option>
                    <option value="proposal_submission">Proposal Submission</option>
                    <option value="pending_review">Pending Review</option>
                    <option value="under_evaluation">Under Evaluation</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                    <option value="funded">Funded</option>
                    <option value="active">Active</option>
                    <option value="completed">Completed</option>
                    <option value="expired">Expired</option>
                    <option value="terminated">Terminated</option>
                </select>
                @error('award_status')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>


        </div>

        <div class="modal-footer">
            <x-button type="submit" class="btn btn-success">{{ __('public.save') }}</x-button>
        </div>
    </form>
</div>
