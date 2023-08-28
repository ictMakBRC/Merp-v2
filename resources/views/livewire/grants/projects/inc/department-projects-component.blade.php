<div>
    <div class="row">
        <div class="row col-md-6">
            <div class="mb-3 col-md-12">
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
            <div class="list-group list-group-flush scrollabe-content scrollable">
                @forelse ($departments as $department)
                    <div class="form-check list-group-item py-1 ms-2">
                        <input class="form-check-input" type="checkbox" value="{{ $department->id }}"
                            id="project_department{{ $department->id }}" wire:model="project_departments">
                        <label class="form-check-label"
                            for="project_department{{ $department->id }}">{{ $department->name }}</label>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
        <div class="row col-md-6">
            <div class="col-12">
                @if (!$selectedDepartments->isEmpty())
                    <div class="table-responsive scrollabe-content scrollable">
                        <table class="table mb-0 w-100 sortable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>{{ __('public.name') }}</th>
                                    <th>{{ __('public.short_code') }}</th>
                                    <th>{{ __('public.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($selectedDepartments as $key=>$department)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            {{ $department->name }}
                                        </td>
                                        <td>{{ $department->prefix }}</td>
                                        <td>
                                            <div class="table-actions">
                                                <button wire:click='detachDepartment({{ $department->id }})'
                                                    class="btn-outline-danger btn btn-sm"
                                                    title="{{ __('public.cancel') }}"><i class="ti ti-x"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert border-0 border-start border-5 border-warning alert-dismissible fade show py-2">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-warning"><i class='bx bx-primary-circle'></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-warning">{{ __('Departments/Laboratories') }}</h6>
                                <div>{{ __('public.not_found') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if (count($project_departments))
                <hr>
                    <div class="modal-footer">
                        <button class="btn btn-outline-success btn-sm"
                            wire:click='attachDepartments'>{{ __('public.submit') }}</button>
                    </div>
                @endif
            </div>

        </div>

    </div>
    
</div>
