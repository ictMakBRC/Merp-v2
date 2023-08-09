<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pt-0">
                <div class="row mb-1">
                    <div class="col-sm-12 mt-1">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0">
                                Procurement Providers/Suppliers 
                                {{-- <small class="text-success">{{$loadingInfo}}</small> --}}
                            </h5>
                            {{-- <div class="ms-auto mb-2">
                                <div class="row">
                                    <label class="col-md-4 col-form-label text-end">Load Employee</label>
                                    <div class="col-md-8">
                                        <select class="form-select" aria-label="Default select" wire:model.lazy='employee_id'>
                                            <option selected value="">Select</option>
                                            @foreach ($employees as $employee)
                                                <option value='{{ $employee->id }}'>{{ $employee->fullName }}</option>
                                            @endforeach
                                          </select>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

            <!--end card-header-->
            <div class="card-body p-0">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#general-information" role="tab"
                            aria-selected="true">General Information</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#sectors" role="tab"
                            aria-selected="false">Sector</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#documents" role="tab"
                            aria-selected="false">Documents</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane p-3 active" id="general-information" role="tabpanel">
                        @include('livewire.procurement.settings.inc.provider-create-form')
                    </div>

                    <div class="tab-pane p-3" id="sectors" role="tabpanel">
                        <livewire:procurement.settings.inc.provider-sectors-component />
                    </div>

                    <div class="tab-pane p-3" id="documents" role="tabpanel">
                        <livewire:procurement.settings.inc.provider-documents-component />
                    </div>

                </div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!--end row-->
