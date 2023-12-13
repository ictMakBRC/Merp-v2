<div>
    @include('livewire.human-resource.performance.appraisals.breadcrumps', [
    'heading' => 'Create',
    ])
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">

                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <form wire:submit.prevent="store">
                                <div class="row">
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

                                    <div class="mb-3 col-md-5">
                                        <label for="file" class="form-label">Support File</label>
                                        <input type="file" id="file" class="form-control mb-2"
                                            wire:model.defer="file_upload">
                                        <a href="#" wire:click="download" class="text-decoration-underline pt-2">If you
                                            don't have the
                                            Appraisal
                                            letter template, download it here</a>
                                        @error('file_upload')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <a href="{{route('appraisals')}}" class="btn btn-danger me-2">{{
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