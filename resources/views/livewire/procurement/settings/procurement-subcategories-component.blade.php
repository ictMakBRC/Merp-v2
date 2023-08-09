<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-1">
                        <div class="col-sm-12 mt-1">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    Procurements Sectors and Categories
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
                <div class="card-body p-2">
                    @include('livewire.procurement.settings.inc.subcategory-create-form')
                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
</div>
