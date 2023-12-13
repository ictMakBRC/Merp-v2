<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pt-0">
                <div class="row mb-1">
                    <div class="col-sm-12 mt-1">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0">
                                Register new employee information <small class="text-success">{{$loadingInfo}}</small>
                            </h5>
                            <div class="ms-auto mb-2">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--end card-header-->
            <div class="card-body p-0">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#personal_info" role="tab"
                            aria-selected="true">General Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#education" role="tab"
                            aria-selected="false">Education Background</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#working_experience" role="tab"
                            aria-selected="false">Working Experience</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#official_contract" role="tab"
                            aria-selected="false">Official Contract</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane p-3 active" id="personal_info" role="tabpanel">
                        <div class="accordion accordion-flush" id="generalInformation">
                            <div class="accordion-item">
                                <h5 class="accordion-header m-0" id="flush-headingOne">
                                    <button class="accordion-button fw-semibold" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#basic-information"
                                        aria-expanded="true" aria-controls="basic-information">
                                        Basic Information
                                    </button>
                                </h5>
                                <div id="basic-information" class="accordion-collapse collapse show"
                                    aria-labelledby="flush-basic-information" data-bs-parent="#generalInformation">
                                    <div class="accordion-body">
                                        <livewire:human-resource.employee-data.inc.general-information-component />
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h5 class="accordion-header m-0" id="flush-banking-information">
                                    <button class="accordion-button collapsed fw-semibold" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-banking-info"
                                        aria-expanded="false" aria-controls="flush-banking-info">
                                        Banking Information
                                    </button>
                                </h5>
                                <div id="flush-banking-info" class="accordion-collapse collapse"
                                    aria-labelledby="flush-banking-information" data-bs-parent="#generalInformation">
                                    <div class="accordion-body">
                                        <livewire:human-resource.employee-data.inc.banking-information-component />
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h5 class="accordion-header m-0" id="flush-family-info">
                                    <button class="accordion-button collapsed fw-semibold" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-family-information"
                                        aria-expanded="false" aria-controls="flush-family-information">
                                        Family Background
                                    </button>
                                </h5>
                                <div id="flush-family-information" class="accordion-collapse collapse"
                                    aria-labelledby="flush-family-info" data-bs-parent="#generalInformation">
                                    <div class="accordion-body">
                                        <livewire:human-resource.employee-data.inc.family-background-information-component />
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h5 class="accordion-header m-0" id="flush-emergence-contact-info">
                                    <button class="accordion-button collapsed fw-semibold" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-emergence-contact-information"
                                        aria-expanded="false" aria-controls="flush-emergence-contact-information">
                                        Emergency Contact Information
                                    </button>
                                </h5>
                                <div id="flush-emergence-contact-information" class="accordion-collapse collapse"
                                    aria-labelledby="flush-emergence-contact-info" data-bs-parent="#generalInformation">
                                    <div class="accordion-body">
                                        <livewire:human-resource.employee-data.inc.emergency-contact-information-component />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane p-3" id="education" role="tabpanel">
                        <div class="accordion accordion-flush" id="educationInformation">
                            <div class="accordion-item">
                                <h5 class="accordion-header m-0" id="flush-heading-education-history">
                                    <button class="accordion-button fw-semibold" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#education-history-information"
                                        aria-expanded="true" aria-controls="basic-information">
                                        Education History
                                    </button>
                                </h5>
                                <div id="education-history-information" class="accordion-collapse collapse show"
                                    aria-labelledby="flush-education-history-information"
                                    data-bs-parent="#educationInformation">
                                    <div class="accordion-body">
                                        <livewire:human-resource.employee-data.inc.education-information-component />
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h5 class="accordion-header m-0" id="flush-training-history-information">
                                    <button class="accordion-button collapsed fw-semibold" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-training-history-info"
                                        aria-expanded="false" aria-controls="flush-training-history-info">
                                        Training History
                                    </button>
                                </h5>
                                <div id="flush-training-history-info" class="accordion-collapse collapse"
                                    aria-labelledby="flush-training-history-information"
                                    data-bs-parent="#educationInformation">
                                    <div class="accordion-body">
                                        <livewire:human-resource.employee-data.inc.training-information-component />
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane p-3" id="working_experience" role="tabpanel">
                        <livewire:human-resource.employee-data.inc.work-experience-information-component />
                    </div>

                    <div class="tab-pane p-3" id="official_contract" role="tabpanel">
                        <livewire:human-resource.employee-data.inc.official-contract-component />
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
