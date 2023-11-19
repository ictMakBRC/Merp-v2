
<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    @include('livewire.procurement.requests.inc.loading-info')
                    {{-- <div class="row mb-2">
                        <div class="col-lg-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                
                                <h5 class="mb-2 mb-sm-0">
                                    {{ __('Procurements Request Items Reception') }}
                                </h5>

                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="card-body">
                    <div class="p-0" x-cloak x-show="create_new">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#general-information" role="tab"
                                    aria-selected="true">Items</a>
                            </li>
                
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#documents" role="tab"
                                    aria-selected="false">Supporting Documents</a>
                            </li>
                
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#provider_rating" role="tab"
                                    aria-selected="false">Provider Rating</a>
                            </li>
                        </ul>
                
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane p-3 active" id="general-information" role="tabpanel">
                                @include('livewire.procurement.store.inc.procurement-request-items')
                            </div>

                            <div class="tab-pane p-3" id="documents" role="tabpanel">
                                @include('livewire.procurement.store.inc.procurement-request-documents')
                            </div>
                
                            <div class="tab-pane p-3" id="provider_rating" role="tabpanel">
                                {{-- <livewire:procurement.requests.inc.procurement-request-items-component /> --}}
                            </div>
                
                        </div>
                    </div>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

</div>