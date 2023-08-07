<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 w-100 sortable">
                            <thead>
                                <tr>
                                    <th>{{ __('Asset Name') }}</th>
                                    {{-- <th>{{ __('Category') }}</th>
                                    <th>{{ __('Classification') }}</th> --}}
                                    <th>{{ __('Brand') }}</th>
                                    <th>{{ __('Model') }}</th>
                                    <th>{{ __('Serial No') }}</th>
                                    <th>{{ __('Barcode') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $asset_name }}</td>
                                    <td>{{ $brand ?? 'N/A' }}</td>
                                    <td>{{ $model ?? 'N/A' }}</td>
                                    <td>{{ $serial_number ?? 'N/A' }}</td>
                                    <td>{{ $barcode ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div> <!-- end preview-->
                </div><!--end card-body-->
            </div> <!--end card-->
        </div><!--end col-->

        <form wire:submit.prevent>
            <div class="row">
                <div class="mb-3 col-md-4">
                    <label for="log_type" class="form-label required">{{ __('Log Type') }} </label>
                    <select class="form-select" id="log_type" wire:model.lazy="log_type">
                        <option selected value="">Select</option>
                        <option value="Allocation">Allocation</option>
                        <option value="Breakdown">Breakdown</option>
                        <option value="Maintenance">Maintenance</option>
                    </select>
                    @error('log_type')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>

                @if ($log_type == 'Allocation')
                    <div class="mb-3 col-md-4">
                        <label for="station_id" class="form-label required">{{ __('Station') }} </label>
                        <select class="form-select" id="station_id" wire:model.lazy="station_id">
                            <option selected value="">Select</option>
                            @foreach ($stations as $station)
                                <option value='{{ $station->id }}'>{{ $station->name }}</option>
                            @endforeach
                        </select>
                        @error('station_id')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="department_id" class="form-label required">{{ __('Department') }} </label>
                        <select class="form-select" id="department_id" wire:model.lazy="department_id">
                            <option selected value="">Select</option>
                            @foreach ($departments as $department)
                                <option value='{{ $department->id }}'>{{ $department->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="employee_id" class="form-label">{{ __('Employee') }} </label>
                        <select class="form-select" id="employee_id" wire:model.lazy="employee_id">
                            <option selected value="">Select</option>
                            @foreach ($employees as $employee)
                                <option value='{{ $employee->id }}'>{{ $employee->fullName }}</option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="date_allocated" class="form-label required">{{ __('Date Allocated') }} </label>
                        <input type="date" id="date_allocated" class="form-control"
                            wire:model.defer="date_allocated">
                        @error('date_allocated')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                @endif

                @if ($log_type == 'Breakdown')
                    <div class="mb-3 col-md-4">
                        <label for="breakdown_number" class="form-label required">{{ __('Breakdown Number') }} </label>
                        <input type="text" id="breakdown_number" class="form-control"
                            wire:model.defer="breakdown_number">
                        @error('breakdown_number')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="breakdown_type" class="form-label required">{{ __('Breakdown Type') }} </label>
                        <select class="form-select select2" id="breakdown_type" wire:model.lazy="breakdown_type">
                            <option selected value="">Select</option>
                            <option value="Software">Software</option>
                            <option value="Hardware">Hardware</option>
                            <option value="Human Error">Human Error</option>
                            <option value="Other">Other</option>
                        </select>
                        @error('breakdown_type')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="breakdown_date" class="form-label required">{{ __('Breakdown Date') }} </label>
                        <input type="date" id="breakdown_date" class="form-control"
                            wire:model.defer="breakdown_date">
                        @error('breakdown_date')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="breakdown_description"
                            class="form-label required">{{ __('Breakdown Description') }} </label>
                        <textarea type="text" id="breakdown_description" class="form-control" wire:model.defer="breakdown_description"></textarea>
                        @error('breakdown_description')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="action_taken" class="form-label required">{{ __('Action Taken') }} </label>
                        <textarea type="text" id="action_taken" class="form-control" wire:model.defer="action_taken"></textarea>
                        @error('action_taken')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="breakdown_status" class="form-label required">{{ __('Breakdown Status') }}
                        </label>
                        <select class="form-select" id="breakdown_status" wire:model.lazy="breakdown_status">
                            <option selected value="">Select</option>
                            <option value="Pending Fix">Pending Fix</option>
                            <option value="Fixed">Fixed</option>
                        </select>
                        @error('breakdown_status')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                @endif

                @if ($log_type == 'Maintenance')
                    <div class="mb-3 col-md-4">
                        <label for="breakdown_number" class="form-label">{{ __('Breakdown Number') }}
                        </label>
                        <input type="text" id="breakdown_number" class="form-control"
                            wire:model.defer="breakdown_number">
                        @error('breakdown_number')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="service_type" class="form-label required">{{ __('Service Type') }} </label>
                        <select class="form-select" id="service_type" wire:model.lazy="service_type">
                            <option selected value="">Select</option>
                            <option value="Corrective">Corrective</option>
                            <option value="Preventive">Preventive</option>
                            <option value="Condition-based">Condition-based</option>
                            <option value="Calibration">Calibration</option>
                            <option value="Risk-based">Risk-based</option>
                        </select>
                        @error('service_type')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="service_date" class="form-label required">{{ __('Service Date') }} </label>
                        <input type="date" id="service_date" class="form-control"
                            wire:model.defer="date_serviced">
                        @error('date_serviced')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="service_action" class="form-label required">{{ __('Service Action') }} </label>
                        <textarea type="text" id="service_action" class="form-control" wire:model.defer="service_action"></textarea>
                        @error('service_action')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="service_recommendations" class="form-label required">{{ __('Recommendations') }}
                        </label>
                        <textarea type="text" id="service_recommendations" class="form-control"
                            wire:model.defer="service_recommendations"></textarea>
                        @error('service_recommendations')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="resolution_status"
                            class="form-label required">{{ __('Issue Resolution status') }}
                        </label>
                        <select class="form-select" id="resolution_status" wire:model.lazy="resolution_status">
                            <option selected value="">Select</option>
                            <option value="Fully Fixed">Fully Fixed</option>
                            <option value="Partially Fixed">Partially Fixed</option>
                        </select>
                        @error('resolution_status')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="serviced_by" class="form-label required">{{ __('Serviced By') }} </label>
                        <select class="form-select" id="serviced_by" wire:model.lazy="serviced_by">
                            <option selected value="">Select</option>
                            @foreach ($departments as $department)
                                <option value='{{ $department->id }}'>{{ $department->name }}</option>
                            @endforeach
                        </select>
                        @error('serviced_by')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-2">
                        <label for="cost" class="form-label required">{{ __('Cost') }} </label>
                        <input type="number" id="cost" class="form-control" wire:model.defer="cost"
                            step="0.02">
                        @error('cost')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-2">
                        <label for="currency" class="form-label required">Currency</label>
                        <select class="form-select" id="currency" wire:model.lazy='currency'>
                            <option selected value="">Select</option>
                            @include('layouts.currencies')
                        </select>
                        @error('currency')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="next_service_date" class="form-label required">{{ __('Next Service Date') }}
                        </label>
                        <input type="date" id="next_service_date" class="form-control"
                            wire:model.defer="breakdown_date">
                        @error('next_service_date')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                @endif

            </div>

            <div class="modal-footer">
                <x-button class="btn-success" wire:click='storeLogDetails'>{{ __('public.save') }}</x-button>
            </div>
        </form>
        <hr>
    </div>
</div>
