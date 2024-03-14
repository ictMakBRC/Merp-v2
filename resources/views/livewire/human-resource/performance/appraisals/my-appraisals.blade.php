<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    @if (!$toggleForm)
                                    My appraisals (<span class="text-danger fw-bold">{{ $appraisals->total()
                                        }}</span>)
                                    @else
                                    Edit Appraisal
                                    @endif

                                </h5>

                                <div class="ms-auto">
                                    <a type="button" class="btn btn-sm btn-outline-primary me-2"
                                        wire:click="refresh()"><i class="mdi mdi-refresh"></i></a>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#updateCreateModal"
                                        class="btn btn-sm me-2 btn-primary">
                                        <i class="fa fa-plus"></i>New
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="row mb-0">
                            <div class="col-md-8 row">
                                <div class="mb-3 col-md-2">
                                    <label for="orderBy" class="form-label">OrderBy</label>
                                    <select wire:model="orderBy" class="form-select">
                                        <option value="name">Name</option>
                                        <option value="id">Latest</option>
                                    </select>
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label for="orderAsc" class="form-label">Order</label>
                                    <select wire:model="orderAsc" class="form-select" id="orderAsc">
                                        <option value="1">Ascending</option>
                                        <option value="0">Descending</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="search" class="form-label">Search</label>
                                <input id="search" type="text" class="form-control" wire:model.debounce.300ms="search"
                                    placeholder="search">
                            </div>
                            <hr>
                        </div>


                        <div class="table-responsive">
                            <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($appraisals as $key => $appraisal)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>@formatDate($appraisal->start_date)</td>
                                        <td>@formatDate($appraisal->end_date)</td>
                                        <td>@formatDate($appraisal->created_at)</td>
                                        <td class="table-action d-flex">
                                            <a href="{{route('appraisals.show', $appraisal->id)}}"
                                                class="action-ico btn-sm text-primary mx-1">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{route('appraisals.update', $appraisal->id)}}"
                                                class="action-ico btn-sm text-primary mx-1">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <div wire:click="deleteData({{ $appraisal->id }})" data-bs-toggle="modal"
                                                data-bs-target="#delete_modal"
                                                class="action-ico text-primary btn-outline-success mx-1">
                                                <i class="las la-trash-alt text-danger font-16"></i>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No appraisals recorded yet ...</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="btn-group float-end">
                                    {{ $appraisals->links('vendor.livewire.bootstrap') }}
                                </div>
                            </div>
                        </div>
                    </div> <!-- end tab-content-->
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- create/edit modal -->
    <div wire:ignore.self class="modal fade" id="updateCreateModal" tabindex="-1" role="dialog"
        aria-labelledby="updateCreateModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title m-0" id="updateCreateModalTitle">
                        @if (!$toggleForm)
                        Register New Grievance Type
                        @else
                        Update Existing Grievance Type
                        @endif
                    </h6>
                    <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()"
                        aria-label="Close"></button>
                </div>
                <!--end modal-header-->

                <form @if ($toggleForm) wire:submit.prevent="update" @else wire:submit.prevent="store" @endif>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="name" class="form-label required">Name</label>
                                <input type="text" id="name" class="form-control" name="name" required
                                    wire:model="name">
                                @error('name')
                                <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="slug" class="form-label required">Slug</label>
                                <input type="text" id="slug" class="form-control" required wire:model.defer="slug"
                                    disabled>
                                @error('slug')
                                <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="countryName" class="form-label">Description</label>
                                <textarea id="description" class="form-control" name="description"
                                    wire:model.defer="description"></textarea>
                                @error('description')
                                <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"
                            wire:click="close()">{{ __('public.close') }}</button>
                        @if($toggleForm)
                        <x-button type="submit" class="btn-primary btn-sm">{{ __('public.update') }}</x-button>
                        @else
                        <x-button type="submit" class="btn-primary btn-sm">{{ __('public.save') }}</x-button>
                        @endif
                    </div>
                    <!--end modal-footer-->
                </form>
            </div>
            <!--end modal-content-->
        </div>
        <!--end modal-dialog-->
    </div>
    <!--end modal-->
    <!-- delete modal -->
    <div wire:ignore.self class="modal fade" id="delete_modal" tabindex="-1" role="dialog"
        aria-labelledby="deleteModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title m-0" id="deleteModalTitle">
                        Delete Existing Grievance Type
                    </h6>
                    <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()"
                        aria-label="Close"></button>
                </div>
                <!--end modal-header-->
                <div class="modal-body">
                    <div class="row">
                        Are you sure you want to delete this record
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-bs-dismiss="modal" wire:click="close()">{{
                        __('public.close') }}</button>

                    <x-button type="click" wire:click="delete" class="btn-danger btn-sm">Confirm</x-button>

                </div>
                <!--end modal-footer-->
            </div>
            <!--end modal-content-->
        </div>
        <!--end modal-dialog-->
    </div>
    <!--end modal-->

    @push('scripts')
    <script>
        window.addEventListener('close-modal', event => {
                    $('#updateCreateModal').modal('hide');
                    $('#delete_modal').modal('hide');
                    $('#show-delete-confirmation-modal').modal('hide');
                });
                window.addEventListener('delete-modal', event => {
                    $('#delete_modal').modal('show');
                });
    </script>
    @endpush
</div>