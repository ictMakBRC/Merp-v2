<div>
    @include('livewire.human-resource.grievances.breadcrumps', [
    'heading' => 'Create',
    ])
    <div class="row">
        <div class="col-12">
            <div class="card">
                {{-- <div class="card-header">
                    <div class="flex justify-end mt-4">
                        <a type="button" class="btn btn-sm btn-outline-success me-2"><i class="ti ti-refresh"></i></a>
                        <a type="button" class="btn btn-sm me-2 btn-success">
                            <i class="ti ti-plus"></i>{{ __('public.new') }}
                        </a>
                    </div>
                </div> --}}
                <div class="card-body">

                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <form wire:submit.prevent="store">
                                <div class="row">

                                    <div class="mb-3 col-md-4">
                                        <label class="mb-3 required">Grievance Type</label>
                                        <div class="" style="width: 100%;">
                                            <select class="form-select" wire:model="grievance_type_id">
                                                <option value="" disabled="">Select ...</option>
                                                @foreach ($grievanceTypes as $grievanceType)
                                                <option value="{{$grievanceType->id}}" selected="">
                                                    {{$grievanceType->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('greivance_type_id')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label class="mb-3 required">Addresse</label>
                                        <div class="selectr-container selectr-desktop has-selected"
                                            style="width: 100%;">
                                            <div class="" style="width: 100%;">
                                                <select class="form-select" wire:model="addressee">
                                                    <option value="" disabled>Select ...</option>
                                                    <option value="administration" selected="">Administration</option>
                                                    <option value="department">Department</option>
                                                    <option value="both">Both</option>
                                                </select>
                                            </div>
                                            @error('addressee')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-5">
                                        <label for="file" class="form-label">Support File</label>
                                        <input type="file" id="file" class="form-control"
                                            wire:model.defer="file_upload">
                                        @error('file_upload')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-12">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea type="text" id="description" rows="4" class="form-control"
                                            wire:model.defer="description" placeholder="Description">
                                        </textarea>

                                        @error('description')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="{{route('grievances')}}" class="btn btn-danger me-2">{{
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