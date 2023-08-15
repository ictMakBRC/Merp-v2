<div>
    @include('livewire.human-resource.grievance-types.breadcrumps', [
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

                                    <div class="mb-3 col-md-6">
                                        <label for="date1" class="form-label required">Name</label>
                                        <input type="text" id="name" class="form-control" wire:model="name" required>
                                        @error('name')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-5">
                                        <label for="slug" class="form-label required">Slug</label>
                                        <input type="text" id="slug" class="form-control" wire:model.defer="slug"
                                            required disabled>
                                        @error('slug')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-12">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea type="text" id="description" rows="4" class="form-control"
                                            wire:model.defer="description" placeholder="Description"></textarea>
                                        @error('description')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="{{route('grievance-types')}}" class="btn btn-danger me-2">{{
                                        __('public.cancel') }}</a>
                                    <x-button class="btn-success">{{ __('public.save') }}</x-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>