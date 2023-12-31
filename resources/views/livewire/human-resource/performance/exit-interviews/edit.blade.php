<div>
    @include('livewire.human-resource.performance.exit-interviews.breadcrumps', [
    'heading' => 'Edit',
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
                                        <label for="file" class="form-label">Update Completed Exit Interview
                                            Document</label>
                                        <input type="file" id="file" class="form-control"
                                            wire:model.defer="file_upload">
                                        @error('file_upload')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                        @if($exitInterview->getFirstMedia())
                                        <div class="file-box-content mt-4">
                                            <div class="file-box">
                                                <a href="#" wire:click="download" class="download-icon-link">
                                                    <i class="las la-download file-download-icon"></i>
                                                </a>
                                                <div class="text-center">
                                                    <i class="lar la-file-alt text-primary"></i>
                                                    <h6 class="text-truncate">
                                                        {{$exitInterview->getFirstMedia()->file_name}}</h6>
                                                    <small class="text-muted">@formatDate($exitInterview->created_at) /
                                                        {{number_format(($exitInterview->getFirstMedia()->size)/2048,
                                                        3)}}MB</small>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <a href="{{route('exit-interviews')}}" class="btn btn-danger me-2">{{
                                        __('public.cancel') }}</a>
                                    <x-button class="btn-primary">Update</x-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>