<div>
    <form
        @if (!$editMode) wire:submit.prevent="attachEmployee"
    @else
    wire:submit.prevent="updateProjectContract" @endif>
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
                    @forelse ($employees_list as $employee)
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
                        <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                    @empty
                    @endforelse
                </select>
                @error('designation_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="contract_start_date" class="form-label required">{{ __('Start Date') }}</label>
                <input type="date" id="contract_start_date" class="form-control" wire:model.defer="contract_start_date">
                @error('contract_start_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="contract_end_date" class="form-label required">{{ __('End Date') }}</label>
                <input type="date" id="contract_end_date" class="form-control" wire:model.defer="contract_end_date">
                @error('contract_end_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="fte" class="form-label required">{{ __('FTE') }}</label>
                <input type="number" id="fte" class="form-control" wire:model.defer="fte" step="0.01">
                @error('fte')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="gross_salary" class="form-label required">{{ __('Gloss Salary in') }} <strong
                        class="badge bg-warning">{{ $currencyCode }}</strong></label>
                <input type="number" id="gross_salary" class="form-control" wire:model.defer="gross_salary"
                    step="0.01">
                @error('gross_salary')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3 col-md-4">
                <label for="contract_file" class="form-label">{{ __('Contract file') }}</label>
                <input type="file" id="contract_file" class="form-control" wire:model.defer="contract_file">
                <div class="text-success text-small" wire:loading wire:target="contract_file">Uploading contract...
                </div>
                @error('contract_file')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="contract_status" class="form-label required">{{ __('Contract Status') }}</label>
                <select class="form-select" id="contract_status" wire:model.lazy="status">
                    <option selected value="">Select</option>
                    <option value="Running">Running</option>
                    <option value="Terminated">Terminated</option>
                    <option value="Expired">Expired</option>
                </select>
                @error('status')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-9">
                <label for="contract_summary" class="form-label">{{ __('Contract Summary') }}</label>
                <textarea id="contract_summary" class="form-control" wire:model.defer="contract_summary"></textarea>
                @error('contract_summary')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="modal-footer">
            <div class="row mb-3">
                <div class="col-md-9">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" wire:model="special_role" id="inlineRadio1"
                            value="pi">
                        <label class="form-check-label" for="inlineRadio1">is Principal Investigator</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" wire:model="special_role" id="inlineRadio2"
                            value="coordinator">
                        <label class="form-check-label" for="inlineRadio2">is Co-ordinator</label>
                    </div>
                </div>
            </div> <!--end row-->

            <x-button type="submit" class="btn btn-success">
                @if (!$editMode)
                    {{ __('public.save') }}
                @else
                    {{ __('public.update') }}
                @endif
            </x-button>
        </div>
    </form>

    @if ($project_id && !$employees->isEmpty())
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="card-title">{{ __('Human Resource') }}</h4>
                </div><!--end col-->
            </div> <!--end row-->
        </div>

        <div class="table-responsive">
            <table class="table table-striped mb-0 w-100 sortable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Employee Name</th>
                        <th>Designation</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Gross Salary</th>
                        <th>Status</th>
                        <th>FTE</th>
                        <th>Contract Summary</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $key => $employee)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $employee->fullname ?? 'N/A' }}</td>
                            <td>{{ $employee->pivot->designation->name ?? 'N/A' }}</td>
                            <td>@formatDate($employee->pivot->start_date)</td>
                            <td>@formatDate($employee->pivot->end_date)</td>
                            <td>{{ getCurrencyCode($project->currency_id) }}
                                {{ $employee->pivot->gross_salary ?? 'N/A' }}</td>

                            @if ($employee->pivot->status == 'Running')
                                <td><span class="badge bg-success">{{ $employee->pivot->status }}</span>
                                </td>
                            @else
                                <td><span class="badge bg-warning">{{ $employee->pivot->status }}</span>
                                </td>
                            @endif
                            <td>
                                {{ $employee->pivot->fte ?? 'N/A' }}
                            </td>
                            <td>
                                {{ $employee->pivot->contract_summary }}
                            </td>

                            @if ($employee->pivot->status == 'Running' && $employee->pivot->end_date >= today())
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-sm btn-outline-success m-1"
                                            wire:click="loadContract({{ $employee->pivot->id }})"
                                            title="{{ __('public.edit') }}">
                                            <i class="ti ti-edit fs-18"></i></button>
                                    </div>
                                </td>
                            @else
                                <td>{{ __('N/A') }}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> <!-- end preview-->
    @endif
</div>
