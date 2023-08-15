<div>
    @include('livewire.human-resource.grievance-types.breadcrumps', [
    'heading' => '',
    ])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8 flex justify-end my-2">
                            <a href="/human-resource/grievance-types/create" class="btn btn-sm me-2 btn-success">
                                <i class="ti ti-plus"></i>{{ __('public.new') }}
                            </a>
                        </div>
                        <div class="row col-4">
                            <div class="col-12 row">
                                <div class="col-10 flex justify-end">
                                    <input class="form-control" type="text" placeholder="Search ..."
                                        id="example-text-input">
                                </div>
                                <div class="col-2 flex items-center mt-1">
                                    <a type="button" class="btn btn-sm btn-outline-success me-2"><i
                                            class="ti ti-filter"></i></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0 w-100 ">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name.</th>
                                            <th>Slug</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($grievanceTypes as $grievanceType)
                                        <tr>
                                            <td>{{$grievanceType->id}}</td>
                                            <td>{{$grievanceType->name}}</td>
                                            <td>{{$grievanceType->slug}}</td>
                                            <td class="text-left">
                                                <a href="#"><i class="las la-pen text-secondary font-16"></i></a>
                                                <a href="#"><i class="las la-trash-alt text-danger font-16"></i></a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td>No Grievance Types...</td>
                                        </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="btn-group float-end">
                                {{ $grievanceTypes->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>