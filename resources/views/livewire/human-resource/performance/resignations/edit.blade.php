<div>
    @include('livewire.human-resource.performance.resignations.breadcrumps', [
    'heading' => 'Edit',
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
                                        <label class="mb-3">Department</label>
                                        <div class="" style="width: 100%;">
                                            <select class="form-select" wire:model="department_id">
                                                <option value="" disabled="">Select ...</option>
                                                @foreach ($departments as $department)
                                                <option value="{{$department->id}}" selected="">
                                                    {{$department->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('department_id')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
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
                                        <label for="file" class="form-label">Resignation Letter</label>
                                        <input type="file" id="file" class="form-control"
                                            wire:model.defer="file_upload">
                                        @error('file_upload')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-5">
                                        <label for="hand_over_date" class="form-label"> Date of Hand Over</label>
                                        <input type="date" id="hand_over_date" class="form-control"
                                            wire:model.defer="hand_over_date">
                                        @error('hand_over_date')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-12">
                                        <label for="reason" class="form-label">Reason</label>
                                        <textarea type="text" id="reason" rows="4" class="form-control"
                                            wire:model.defer="reason" placeholder="reason">
                                        </textarea>

                                        @error('reason')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <a href="{{route('resignations')}}" class="btn btn-danger me-2">{{
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