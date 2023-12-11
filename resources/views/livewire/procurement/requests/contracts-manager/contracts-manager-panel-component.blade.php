
<div class="row" x-data="{ filter_data: @entangle('filter') }">
    <div class="col-12">
        <div class="card">
            <div class="card-header pt-0">
                <div class="row mb-2">
                    <div class="col-sm-12 mt-3">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0">
                                {{ __('Procurement Requests') }}
                                @include('livewire.layouts.partials.inc.filter-toggle-alpine')

                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('livewire.procurement.requests.contracts-manager.inc.procurement-requests-list-table')
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

