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
                                    {{__('Assets and Equipments')}} (<span class="text-danger fw-bold">{{ $assets->total() }}</span>)
                                        @include('livewire.layouts.partials.inc.filter-toggle-alpine')
                                    @else
                                    {{__('Edit Asset/Equipment')}}
                                    @endif

                                </h5>
                                @include('livewire.layouts.partials.inc.create-resource-alpine')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('livewire.assets-management.inc.create-form')
                   
                    @include('livewire.assets-management.inc.list-table')

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    {{-- @include('livewire.assets-management.inc.asset-logger-modal') --}}
</div>
