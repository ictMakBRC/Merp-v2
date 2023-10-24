<div class="row" x-data="{ filter_data: @entangle('filter'), create_new: @entangle('createNew') }">
    <div class="col-12">
        <div class="card">
            <div class="card-header pt-0">
                <div class="row mb-2">
                    <div class="col-sm-12 mt-3">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0">
                                @if (!$toggleForm)
                                    {{ __('Procurements Requests') }}
                                    @include('livewire.layouts.partials.inc.filter-toggle-alpine')
                                @else
                                    {{ __('Edit Request') }}
                                @endif

                            </h5>
                            @include('livewire.layouts.partials.inc.create-resource-alpine')
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <livewire:procurement.requests.inc.procurement-request-form-component />
                <hr>
                @include('livewire.procurement.requests.inc.procurement-requests-list-table')

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
