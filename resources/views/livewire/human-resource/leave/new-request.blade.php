<div>
    @include('livewire.human-resource.leave.breadcrumps', [
    'heading' => 'New',
    ])
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">

                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <form wire:submit.prevent="store">
                                <div class="row">

                                    <div class="mb-3 col-md-4">
                                        <label class="mb-3 required">Type of/Purpose for being Unavailable</label>
                                        <div class="selectr-container selectr-desktop has-selected"
                                            style="width: 100%;">
                                            <div class="" style="width: 100%;">
                                                <select class="form-select" wire:model="leave_type_id">
                                                    <option value="" disabled>Select ...</option>
                                                    @foreach ($leaveTypes as $leaveType)
                                                    <option value="{{$leaveType->id}}" selected="">
                                                        {{$leaveType->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('leave_type_id')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label class="mb-3">Employee</label>
                                        <div class="selectr-container selectr-desktop has-selected"
                                            style="width: 100%;">
                                            <div class="" style="width: 100%;">
                                                <select class="form-select" wire:model="employee_id">
                                                    <option value="" disabled>Select ...</option>
                                                    @foreach ($employees as $employee)
                                                    <option value="{{$employee->id}}" selected="">
                                                        {{$employee->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('employee_id')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-5">
                                        <label for="start_date" class="form-label required">From</label>
                                        <input type="date" id="start_date" class="form-control"
                                            wire:model.defer="start_date" required>
                                        @error('start_date')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-5">
                                        <label for="end_date" class="form-label required">To</label>
                                        <input type="date" id="end_date" class="form-control"
                                            wire:model.defer="end_date" required>
                                        @error('end_date')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-10">
                                        <label for="reason" class="form-label">Reason</label>
                                        <textarea type="text" id="reason" rows="4" class="form-control"
                                            wire:model.defer="reason" placeholder="reason">
                                        </textarea>

                                        @error('reason')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label class="mb-3 required">Select Staff to Delegate roles to</label>
                                        <div class="selectr-container selectr-desktop has-selected"
                                            style="width: 100%;">
                                            <div class="" style="width: 100%;">
                                                <select class="form-select" wire:model="delegatee_id">
                                                    <option value="" disabled>Select ...</option>
                                                    @foreach ($employees as $employee)
                                                    <option value="{{$employee->id}}" selected="">
                                                        {{$employee->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('delegatee_id')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-10">
                                        <label for="reason" class="form-label">Any comment to the delegatee?</label>
                                        <textarea type="text" id="reason" rows="4" class="form-control"
                                            wire:model.defer="reason" placeholder="eg I will be offline for a bit.">
                                        </textarea>

                                        @error('reason')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <a href="{{route('leave.requests')}}" class="btn btn-danger me-2">{{
                                        __('public.cancel') }}</a>
                                    <x-button class="btn-primary">{{ __('public.save') }}</x-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>