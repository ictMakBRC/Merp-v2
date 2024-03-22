
<div>
    <div class="row" x-data="{ filter_data: @entangle('filter'),create_new: @entangle('createNew') }">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    @if (!$toggleForm)
                                    {{__('Projects/Studies/Grants')}} (<span
                                    class="text-danger fw-bold">{{ $projects->total() }}</span>)
                                        @include('livewire.layouts.partials.inc.filter-toggle-alpine')
                                    @else
                                    {{__('Edit Project/Study/Grant')}}
                                    @endif

                                </h5>
                                @include('livewire.layouts.partials.inc.create-resource-alpine')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:grants.projects.inc.project-form-component />
                    <hr>
                    @include('livewire.grants.projects.inc.project-list-table')

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

</div>


<!--end row-->
