<div class="row mb-0" x-show="filter_data">
    <h6>{{ __('Filter Projects') }}</h6>
    <div class="mb-3 col-md-3">
        <label for="project_category" class="form-label required">{{ __('Category') }}</label>
        <select class="form-select" id="project_category" wire:model.lazy="project_category">
            <option selected value="">Select</option>
            <option value="Project">Project</option>
            <option value="Study">Study</option>
        </select>
        <div class="text-info" wire:loading wire:target='project_category'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>

    <div class="mb-3 col-md-3">
        <label for="project_type" class="form-label required">{{ __('Type') }}</label>
        <select class="form-select" id="project_type" wire:model.lazy="project_type">
            <option selected value="">Select</option>
            <option value="Primary">Primary</option>
            <option value="Non-Primary">Non-Primary</option>
        </select>
        <div class="text-info" wire:loading wire:target='project_type'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>

    <div class="mb-3 col-md-3 ">
        <label for="pi" class="form-label">Principal Investigator</label>
        <select class="form-select" wire:model='pi'>
            <option value="0" selected>All</option>
            @forelse ($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->fullName }}
                </option>
            @empty
            @endforelse
        </select>
        <div class="text-info" wire:loading wire:target='pi'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>

    <div class="mb-3 col-md-3">
        <label for="progress_status" class="form-label required">{{ __('Progress Status') }}</label>
        <select class="form-select" id="progress_status" wire:model.lazy="progress_status">
            <option selected value="">Select</option>
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
        </select>
        <div class="text-info" wire:loading wire:target='progress_status'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>

</div>

<div class="row">

    <div class="mb-3 col-md-2">
        <label for="from_date" class="form-label">{{ __('public.from_date') }}</label>
        <input id="from_date" type="date" class="form-control" wire:model.lazy="from_date">
        <div class="text-info" wire:loading wire:target='from_date'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>

    <div class="mb-3 col-md-2">
        <label for="to_date" class="form-label">{{ __('public.to_date') }}</label>
        <input id="to_date" type="date" class="form-control" wire:model.lazy="to_date">
        <div class="text-info" wire:loading wire:target='to_date'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>

    <div class="mb-3 col-md-1">
        <label for="perPage" class="form-label">{{ __('public.per_page') }}</label>
        <select wire:model="perPage" class="form-select" id="perPage">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <div class="text-info" wire:loading wire:target='perPage'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>

    <div class="mb-3 col-md-2">
        <label for="orderBy" class="form-label">{{ __('public.order_by') }}</label>
        <select wire:model="orderBy" class="form-select">
            <option value="end_date">End Date</option>
            <option value="id">Latest</option>
        </select>

        <div class="text-info" wire:loading wire:target='orderBy'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>

    <div class="mb-3 col-md-1">
        <label for="orderAsc" class="form-label">{{ __('public.order') }}</label>
        <select wire:model="orderAsc" class="form-select" id="orderAsc">
            <option value="1">Asc</option>
            <option value="0">Desc</option>
        </select>
        <div class="text-info" wire:loading wire:target='orderAsc'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>

    <div class="mb-3 col-md-3">
        <label for="search" class="form-label">{{ __('public.search') }}</label>
        <input id="search" type="text" class="form-control" wire:model.lazy="search" placeholder="search">
        <div class="text-info" wire:loading wire:target='search'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>

    <div class="mt-4 col-md-1">
        <x-export-button></x-export-button>
    </div>
</div>
<hr>
