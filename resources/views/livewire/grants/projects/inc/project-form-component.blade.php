<div>
    <div class="card-bod p-0" x-cloak x-show="create_new">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#general-information" role="tab"
                    aria-selected="true">General Information</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#employees" role="tab"
                    aria-selected="false">Employees</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#documents" role="tab"
                    aria-selected="false">Documents</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#project-departments" role="tab"
                    aria-selected="false">Facilities</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane p-3 active" id="general-information" role="tabpanel">

                <form
                    @if ($editMode) wire:submit.prevent="updateProject"
                @else
                wire:submit.prevent="storeProject" @endif>
                    <div class="row">

                        <div class="mb-3 col-md-3">
                            <label for="project_category" class="form-label required">{{ __('Category') }}</label>
                            <select class="form-select" id="project_category" wire:model.lazy="project_category">
                                <option selected value="">Select</option>
                                <option value="Project">Project</option>
                                <option value="Study">Study</option>
                                <option value="Grant">Grant</option>
                            </select>
                            @error('project_category')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-3">
                            <label for="project_type" class="form-label required">{{ __('Type') }}</label>
                            <select class="form-select" id="project_type" wire:model.lazy="project_type">
                                <option selected value="">Select</option>
                                @if ($project_category == 'Grant')
                                    <option value="Research">Research Grant</option>
                                    <option value="Health-Medical">Health and Medical Research Grant</option>
                                    <option value="Education">Education Grant</option>
                                    <option value="Equipment">Equipment Grant</option>
                                    <option value="Training">Training Grant</option>
                                    <option value="Program-Development">Program Development Grant</option>
                                    <option value="Community-Outreach">Community Outreach Grant</option>
                                    <option value="Capacity-Building">Capacity Building Grant</option>
                                    <option value="International-Collaboration">International Collaboration Grant
                                    </option>
                                    <option value="Environmental">Environmental Grant</option>
                                    <option value="Humanitarian">Humanitarian Grant</option>
                                    <option value="Technology-Innovation">Technology Innovation Grant</option>
                                    <option value="Innovation-Entrepreneurship">Innovation and Entrepreneurship Grant
                                    </option>
                                    <option value="Arts-Culture">Arts and Culture Grant</option>
                                    <option value="Travel">Travel Grant</option>
                                @else
                                    <option value="Primary">Primary</option>
                                    <option value="Non-Primary">Non-Primary</option>
                                @endif

                            </select>
                            @error('project_type')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <div class="mb-3 col-md-4">
                            <label for="associated_institution"
                                class="form-label required">{{ __('Associated Institution') }}</label>
                            <select class="form-select" id="associated_institution"
                                wire:model.lazy="associated_institution">
                                <option selected value="">Select</option>
                                @forelse ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->fullName }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('associated_institution')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <div class="mb-3 col-md-6">
                            <label for="project_code"
                                class="form-label required">{{ __('Project/Study/Grant Code') }}</label>
                            <input type="text" id="project_code" class="form-control"
                                wire:model.defer="project_code">
                            @error('project_code')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label required">{{ __('Name') }}</label>
                            <input type="text" id="name" class="form-control" wire:model.defer="name">
                            @error('name')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>


                        {{-- <div class="mb-3 col-md-3">
                            <label for="grant_id" class="form-label">{{ __('Associated Grant') }}</label>
                            <select class="form-select" id="grant_id" wire:model.lazy="grant_id">
                                <option selected value="">Select</option>
                            </select>
                            @error('grant_id')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <div class="mb-3 col-md-3">
                            <label for="sponsor_id" class="form-label required">{{ __('Sponsor/Funder') }}</label>
                            <select class="form-select" id="sponsor_id" wire:model.lazy="sponsor_id">
                                <option selected value="">Select</option>
                                @forelse ($sponsors as $sponsor)
                                    <option selected value="{{ $sponsor->id }}">{{ $sponsor->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('sponsor_id')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <div class="mb-3 col-md-6">
                            <label for="funding_source" class="form-label">{{ __('Funding Source') }}</label>
                            <input type="text" id="funding_source" class="form-control"
                                wire:model.defer="funding_source">
                            @error('funding_source')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <div class="mb-3 col-md-3">
                            <label for="funding_amount" class="form-label">{{ __('Funding Amount') }}</label>
                            <input type="number" id="funding_amount" class="form-control"
                                wire:model.defer="funding_amount" step="0.01">
                            @error('funding_amount')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-3">
                            <label for="currency_id" class="form-label required">{{ __('Currency') }}</label>
                            <select class="form-select" id="currency_id" wire:model.lazy="currency_id">
                                <option selected value="">Select</option>
                                @include('layouts.currencies')
                            </select>
                            @error('currency_id')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        @if ($project_category == 'Grant')
                            <div class="mb-3 col-md-3">
                                <label for="proposal_submission_date" class="form-label required">Proposal Submission
                                    Date</label>
                                <input type="date" id="proposal_submission_date" class="form-control"
                                    wire:model.defer="proposal_submission_date">
                                @error('proposal_submission_date')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <div class="mb-3 col-md-3">
                            <label for="start_date" class="form-label required">Start Date</label>
                            <input type="date" id="start_date" class="form-control"
                                wire:model.defer="start_date">
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

                        <div class="mb-3 col-md-6">
                            <label for="project_summary"
                                class="form-label">{{ __('Project/Study/Grant Summary') }}</label>
                            <textarea id="project_summary" class="form-control" wire:model.defer="project_summary"></textarea>
                            @error('project_summary')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-3">
                            <label for="progress_status"
                                class="form-label required">{{ __('Progress Status') }}</label>
                            <select class="form-select" id="progress_status" wire:model.lazy="progress_status">
                                <option selected value="">Select</option>
                                @if ($project_category == 'Grant')
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
                                @else
                                    <option value="Planning">Planning</option>
                                    <option value="Pending Funding">Pending Funding</option>
                                    <option value="Implementation">Implementation</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Data Analysis">Data Analysis</option>
                                    <option value="Quality Assurance">Quality Assurance</option>
                                    <option value="Evaluation">Evaluation</option>
                                    <option value="Iteration">Iteration/Refinement</option>
                                    <option value="Milestone Achieved">Milestone Achieved</option>
                                    <option value="Reporting">Reporting</option>
                                    <option value="Transition">Transition</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Delayed">Delayed</option>
                                    <option value="Pending Review">Pending Review</option>
                                    <option value="On-hold">On Hold</option>
                                    <option value="Terminated">Terminated</option>
                                @endif
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

            <div class="tab-pane p-3" id="employees" role="tabpanel">
                <livewire:grants.projects.inc.project-employees-component />
            </div>

            <div class="tab-pane p-3" id="documents" role="tabpanel">
                <livewire:grants.projects.inc.project-documents-component />
            </div>

            <div class="tab-pane p-3" id="project-departments" role="tabpanel">
                <livewire:grants.projects.inc.department-projects-component />
            </div>

        </div>
    </div>
</div>
