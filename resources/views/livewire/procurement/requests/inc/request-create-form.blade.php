{{-- <div x-cloak x-show="create_new"> --}}
<form wire:submit.prevent="storeProcurementRequest">
    <div class="row">
        <div class="mb-3 col-md-2">
            <label for="request_type" class="form-label required">{{ __('Request Type') }}</label>
            <select class="form-select" id="request_type" wire:model.lazy="request_type">
                <option selected value="">Select</option>
                <option value="Departmental">Departmental Request</option>
                <option value="Project">Project Request</option>
            </select>
            @error('request_type')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        @if ($request_type == 'Project')
            <div class="mb-3 col-md-4">
                <label for="project_id"
                    class="form-label @if ($request_type == 'Project') required @endif">{{ __('Project') }}</label>
                <select class="form-select" id="project_id" wire:model.lazy="project_id">
                    <option selected value="">Select</option>
                    @forelse ($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @empty
                    @endforelse
                </select>
                @error('project_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
        @endif

        <div class="mb-3 @if ($request_type == 'Project') col-md-6 @else col-md-10 @endif">
            <label for="subject" class="form-label required">{{ __('Procurement Subject') }}</label>
            <input type="text" id="subject" class="form-control" wire:model.defer="subject">
            @error('subject')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label for="details" class="form-label required">{{ __('Details/Body') }}</label>
            <textarea type="text" id="details" class="form-control" wire:model.defer="body"></textarea>
            @error('body')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-3">
            <label for="procuring_entity_code" class="form-label">{{ __('Procuring Entity Code') }}</label>
            <input type="text" id="procuring_entity_code" class="form-control"
                wire:model.defer="procuring_entity_code">
            @error('procuring_entity_code')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-3">
            <label for="procurement_sector" class="form-label required">{{ __('Sector/Category') }}</label>
            <select class="form-select" id="procurement_sector" wire:model.lazy="procurement_sector">
                <option selected value="">Select</option>
                <option value="Supplies">Supplies</option>
                <option value="Services">Services</option>
                <option value="Works">Works</option>
                <option value="Consultancy">Consultancy</option>
            </select>
            @error('procurement_sector')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-2">
            <label for="financial_year" class="form-label">{{ __('Financial Year') }}</label>
            <select class="form-select" id="financial_year" wire:model.lazy="financial_year">
                <option selected value="">Select</option>
                <option value="{{ today()->year . '-' . today()->addYear(1)->year }}">
                    {{ today()->year . '-' . today()->addYear(1)->year }}</option>
                <option value="{{ today()->subYear(1)->year . '-' . today()->year }}">
                    {{ today()->subYear(1)->year . '-' . today()->year }}</option>

            </select>
            @error('financial_year')
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

        <div class="mb-3 col-md-4">
            <label for="budget_line" class="form-label required">{{ __('Budget Line') }}</label>
            <select class="form-select" id="budget_line" wire:model.lazy="budget_line">
                <option selected value="">Select</option>
                <option value="Computer-Hardware-Procurement">Computer-Hardware-Procurement</option>
                <option value="Office-Hardware-Procurement">Office-Hardware-Procurement</option>
                <option value="Office-Maintenance-Procurement">Office-Maintenance-Procurement</option>
                <option value="Computer-Repair-Procurement">Computer-Repair-Procurement</option>
            </select>
            @error('budget_line')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="sequence_number" class="form-label">{{ __('Sequence Number') }}</label>
            <input type="text" id="sequence_number" class="form-control" wire:model.defer="sequence_number">
            @error('sequence_number')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-3">
            <label for="procurement_plan_ref" class="form-label">{{ __('Procurement Plan Reference') }}</label>
            <input type="text" id="procurement_plan_ref" class="form-control"
                wire:model.defer="procurement_plan_ref">
            @error('procurement_plan_ref')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-3">
            <label for="location_of_delivery" class="form-label">{{ __('Location of Delivery') }}</label>
            <input type="text" id="location_of_delivery" class="form-control"
                wire:model.defer="location_of_delivery">
            @error('location_of_delivery')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-3">
            <label for="date_required" class="form-label">{{ __('Date Required') }}</label>
            <input type="date" id="date_required" class="form-control" wire:model.defer="date_required">
            @error('date_required')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="modal-footer">
        <x-button type="submit" class="btn btn-success">{{ __('public.save') }}</x-button>
    </div>
</form>
{{-- <hr>
</div> --}}
