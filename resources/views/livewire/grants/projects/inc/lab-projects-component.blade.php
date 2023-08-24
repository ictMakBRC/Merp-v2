<div>
    <form wire:submit.prevent="attachLaboratory">
        <div class="row">
            <div class="mb-3 col-md-6">
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

            <div class="mb-3 col-md-6">
                <label for="laboratory_id" class="form-label required">{{ __('Laboratory') }}</label>
                <select class="form-select" id="laboratory_id" wire:model.lazy="laboratory_id">
                    <option selected value="">Select</option>
                    @forelse ($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->fullName }}</option>
                    @empty
                    @endforelse
                </select>
                @error('laboratory_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="modal-footer">
            <x-button type="submit" class="btn btn-success">{{ __('public.save') }}</x-button>
        </div>
    </form>
</div>
