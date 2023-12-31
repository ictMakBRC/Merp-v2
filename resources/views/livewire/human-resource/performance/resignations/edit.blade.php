<div>
    @include('livewire.human-resource.performance.resignations.breadcrumps', [
    'heading' => 'Create',
    ])
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">

                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <form wire:submit.prevent="update">
                                <div class="row">
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

                                        @if($resignation->getFirstMedia())
                                        <div class="file-box-content mt-4">
                                            <div class="file-box">
                                                <a href="#" wire:click="download" class="download-icon-link">
                                                    <i class="las la-download file-download-icon"></i>
                                                </a>
                                                <div class="text-center">
                                                    <i class="lar la-file-alt text-primary"></i>
                                                    <h6 class="text-truncate">
                                                        {{$resignation->getFirstMedia()->file_name}}</h6>
                                                    <small class="text-muted">@formatDate($resignation->created_at) /
                                                        {{number_format(($resignation->getFirstMedia()->size)/2048,
                                                        3)}}MB</small>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
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
                                        <label for="comment" class="form-label">Comment</label>
                                        <textarea type="text" id="reason" rows="4" class="form-control"
                                            wire:model.defer="comment" placeholder="comment">
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