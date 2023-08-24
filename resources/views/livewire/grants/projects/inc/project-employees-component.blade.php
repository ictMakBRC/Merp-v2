<div>
    <form wire:submit.prevent="attachEmployee">
        <div class="row">
            <div class="mb-3 col-md-4">
                <label for="project_id" class="form-label required">{{ __('Project/Study') }}</label>
                <select class="form-select" id="project_id" wire:model.lazy="project_id">
                    <option selected value="">Select</option>
                    @forelse ($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->project_code }}</option>
                    @empty
                    @endforelse
                </select>
                @error('project_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="employee_id" class="form-label required">{{ __('Employee') }}</label>
                <select class="form-select" id="employee_id" wire:model.lazy="employee_id">
                    <option selected value="">Select</option>
                    @forelse ($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->fullName }}</option>
                    @empty
                    @endforelse
                </select>
                @error('employee_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="designation_id" class="form-label required">{{ __('Designation/Position') }}</label>
                <select class="form-select" id="designation_id" wire:model.lazy="designation_id">
                    <option selected value="">Select</option>
                    @forelse ($designations as $designation)
                        <option value="{{ $designation->name }}">{{ $designation->name }}</option>
                    @empty
                    @endforelse
                </select>
                @error('designation_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="start_date" class="form-label required">{{ __('Start Date') }}</label>
                <input type="date" id="start_date" class="form-control" wire:model.defer="start_date">
                @error('start_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="end_date" class="form-label required">{{ __('End Date') }}</label>
                <input type="date" id="end_date" class="form-control" wire:model.defer="end_date">
                @error('end_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3 col-md-3">
                <label for="contract_file" class="form-label required">{{ __('Contract file') }}</label>
                <input type="file" id="contract_file" class="form-control" wire:model.defer="contract_file">
                <div class="text-success text-small" wire:loading wire:target="document">Uploading contract...</div>
                @error('contract_file')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="contract_status" class="form-label required">{{ __('Contract Status') }}</label>
                <select class="form-select" id="contract_status" wire:model.lazy="cstatus">
                    <option selected value="">Select</option>
                    <option value="Running">Running</option>
                    <option value="Terminated">Terminated</option>
                    <option value="Expired">Expired</option>
                </select>
                @error('status')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-12">
                <label for="contract_summary" class="form-label">{{ __('Contract Summary') }}</label>
                <textarea id="contract_summary" class="form-control" wire:model.defer="contract_summary"></textarea>
                @error('contract_summary')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="modal-footer">
            <x-button type="submit" class="btn btn-success">{{ __('public.save') }}</x-button>
        </div>
    </form>
</div>
