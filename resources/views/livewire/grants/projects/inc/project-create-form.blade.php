<div>
    <form wire:submit.prevent="storProjectProfile">
        <div class="row">

            <div class="mb-3 col-md-2">
                <label for="project_category" class="form-label required">{{ __('Project Category') }}</label>
                <select class="form-select" id="project_category" wire:model.lazy="project_category">
                    <option selected value="">Select</option>
                    <option value="Primary">Primary</option>
                    <option value="Non-Primary">Non-Primary</option>
                </select>
                @error('project_category')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="project_code" class="form-label required">{{ __('Project Code') }}</label>
                <input type="text" id="project_code" class="form-control" wire:model.defer="project_code">
                @error('project_code')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label for="name" class="form-label required">{{ __('Name') }}</label>
                <input type="text" id="name" class="form-control" wire:model.defer="name">
                @error('name')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="grant_profile_id" class="form-label">{{ __('Associated Grant') }}</label>
                <select class="form-select" id="grant_profile_id" wire:model.lazy="grant_profile_id">
                    <option selected value="">Select</option>
                </select>
                @error('grant_profile_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="project_type" class="form-label required">{{ __('Project Type') }}</label>
                <select class="form-select" id="project_type" wire:model.lazy="project_type">
                    <option selected value="">Select</option>
                    <option value="research">Research Project</option>
                    <option value="health_medical">Health and Medical Research Project</option>
                    <option value="education">Education Project</option>
                    <option value="equipment">Equipment Project</option>
                    <option value="training">Training Project</option>
                    <option value="program_development">Program Development Project</option>
                    <option value="community_outreach">Community Outreach Project</option>
                    <option value="capacity_building">Capacity Building Project</option>
                    <option value="international_collaboration">International Collaboration Project</option>
                    <option value="environmental">Environmental Project</option>
                    <option value="humanitarian">Humanitarian Project</option>
                    <option value="technology_innovation">Technology Innovation Project</option>
                    <option value="innovation_entrepreneurship">Innovation and Entrepreneurship Project</option>
                    <option value="arts_culture">Arts and Culture Project</option>
                    <option value="travel">Travel Project</option>
                </select>
                @error('project_type')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label for="funding_source" class="form-label">{{ __('Funding Source') }}</label>
                <input type="text" id="funding_source" class="form-control" wire:model.defer="funding_source">
                @error('funding_source')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="funding_amount" class="form-label">{{ __('Funding Amount') }}</label>
                <input type="number" id="funding_amount" class="form-control" wire:model.defer="funding_amount" step="0.01">
                @error('funding_amount')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="currency" class="form-label required">{{ __('Currency') }}</label>
                <select class="form-select" id="currency" wire:model.lazy="currency">
                    <option selected value="">Select</option>
                    @include('layouts.currencies')
                </select>
                @error('currency')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="start_date" class="form-label required">Start Date</label>
                <input type="date" id="start_date" class="form-control" wire:model.defer="start_date">
                @error('start_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="end_date" class="form-label required">End Date</label>
                <input type="date" id="end_date" class="form-control" wire:model.defer="end_date">
                @error('end_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="pi" class="form-label @if($project_category=='Primary') required @endif">{{ __('Principal Investigator') }}</label>
                <select class="form-select" id="pi" wire:model.lazy="pi">
                    <option selected value="">Select</option>
                </select>
                @error('pi')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="co_pi" class="form-label @if($project_category=='Primary') required @endif">{{ __('Co-Principal Investigator') }}</label>
                <select class="form-select" id="co_pi" wire:model.lazy="co_pi">
                    <option selected value="">Select</option>
                </select>
                @error('co_pi')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label for="project_status" class="form-label">{{ __('Project Summary') }}</label>
                <textarea id="project_status" class="form-control" wire:model.defer="project_status"></textarea>
                @error('project_status')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="progress_status" class="form-label required">{{ __('Progress Status') }}</label>
                <select class="form-select" id="progress_status" wire:model.lazy="progress_status">
                    <option selected value="">Select</option>
                    <option value="planning">Planning</option>
                    <option value="pending_funding">Pending Funding</option>
                    <option value="implementation">Implementation</option>
                    <option value="in_progress">In Progress</option>
                    <option value="data_analysis">Data Analysis</option>
                    <option value="quality_assurance">Quality Assurance</option>
                    <option value="evaluation">Evaluation</option>
                    <option value="iteration_refinement">Iteration/Refinement</option>
                    <option value="milestone_achieved">Milestone Achieved</option>
                    <option value="reporting">Reporting</option>
                    <option value="transition">Transition</option>
                    <option value="completed">Completed</option>
                    <option value="delayed">Delayed</option>
                    <option value="pending_review">Pending Review</option>
                    <option value="on_hold">On Hold</option>
                    <option value="termination">Termination</option>
                </select>
                @error('progress_status')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="modal-footer">
            <x-button type="submit" class="btn btn-success">{{ __('public.save') }}</x-button>
        </div>
    </form>
</div>
