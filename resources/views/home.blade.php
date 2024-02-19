<x-holizontal-layout>
    <div>
        <div class="row">
            <div class="col-lg-12 mx-auto">
                @if (!auth()->user()->information_share_consent)
                    <!-- Data sharing consent Starts-->
                    <livewire:user-management.data-policy-confirmation-component />
                    <!-- Data sharing consent ends-->
                @else
                    <div class="row row-cols-1 row-cols-md-1 row-cols-lg-3 row-cols-xl-4">
                        <div class="col d-flex">
                            <div class="card radius-10  border-info border-1">
                                <div class="card-body">
                                    <div class="text-center">
                                        <i class="ti ti-users text-primary" style="font-size:50px"></i>
                                        <h5 class="my-0">{{ __('Human Resource') }}</h5>
                                        <p class="mb-0 text-secondary">
                                            {{ __('Recruitment, Compensation and Employee relations.') }}
                                            {{-- @if (Auth::user()->hasPermission(['access_user_management_module'])) --}}
                                                <a href="{{ route('human-resource-dashboard') }}"
                                                    class="btn btn-sm btn-outline-success">
                                                    <i class="ti ti-arrow-bar-right me-1"></i>
                                                </a>
                                            {{-- @endif --}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col d-flex">
                            <div class="card radius-10  border-info border-1">
                                <div class="card-body">
                                    <div class="text-center">
                                        <i class="ti ti-subtask text-primary" style="font-size:50px"></i>
                                        <h5 class="my-0">{{ __('Grants and Projects') }}</h5>
                                        <p class="mb-0 text-secondary">
                                            {{ __('Managing MERP system settings, users, their roles and permissions, and tracking user activity on the system.') }}
                                            {{-- @if (Auth::user()->hasPermission(['access_user_management_module'])) --}}
                                                <a href="{{ route('projects-dashboard') }}"
                                                    class="btn btn-sm btn-outline-success">
                                                    <i class="ti ti-arrow-bar-right me-1"></i>
                                                </a>
                                            {{-- @endif --}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col d-flex">
                            <div class="card radius-10  border-info border-1">
                                <div class="card-body">
                                    <div class="text-center">
                                        <i class="ti ti-report-money text-primary" style="font-size:50px"></i>
                                        <h5 class="my-0">{{ __('Finance') }}</h5>
                                        <p class="mb-0 text-secondary">
                                            {{ __('Budgeting, Accounting, Invoicing, and Requisition.') }}
                                            {{-- @if (Auth::user()->hasPermission(['access_user_management_module'])) --}}
                                                <a href="{{ route('finance-dashboard') }}"
                                                    class="btn btn-sm btn-outline-success">
                                                    <i class="ti ti-arrow-bar-right me-1"></i>
                                                </a>
                                            {{-- @endif --}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col d-flex">
                            <div class="card radius-10  border-info border-1">
                                <div class="card-body">
                                    <div class="text-center">
                                        <i class="ti ti-truck-delivery text-primary" style="font-size:50px"></i>
                                        <h5 class="my-0">{{ __('Procurement') }}</h5>
                                        <p class="mb-0 text-secondary">
                                            {{ __('Planning, Identification, Selection, and Aquisition.') }}
                                            {{-- @if (Auth::user()->hasPermission(['access_user_management_module'])) --}}
                                                <a href="{{ route('procurement-dashboard') }}"
                                                    class="btn btn-sm btn-outline-success">
                                                    <i class="ti ti-arrow-bar-right me-1"></i>
                                                </a>
                                            {{-- @endif --}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col d-flex">
                            <div class="card radius-10  border-info border-1">
                                <div class="card-body">
                                    <div class="text-center">
                                        <i class="fas fa-boxes text-primary" style="font-size:50px"></i>
                                        <h5 class="my-0">{{ __('Inventory Management') }}</h5>
                                        <p class="mb-0 text-secondary">
                                            {{ __('Forecasting, Acquisition, Consumption, and Tracking') }}
                                            {{-- @if (Auth::user()->hasPermission(['access_user_management_module'])) --}}
                                                <a href="{{ route('inventory-dashboard') }}"
                                                    class="btn btn-sm btn-outline-success">
                                                    <i class="ti ti-arrow-bar-right me-1"></i>
                                                </a>
                                            {{-- @endif --}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col d-flex">
                            <div class="card radius-10  border-info border-1">
                                <div class="card-body">
                                    <div class="text-center">
                                        <i class="ti ti-transfer-in text-primary" style="font-size:50px"></i>
                                        <h5 class="my-0">{{ __('Assets Management') }}</h5>
                                        <p class="mb-0 text-secondary">
                                            {{ __('Identification, Acquisition, Maintenance and Disposal.') }}
                                            {{-- @if (Auth::user()->hasPermission(['access_user_management_module'])) --}}
                                                <a href="{{ route('asset-dashboard') }}"
                                                    class="btn btn-sm btn-outline-success">
                                                    <i class="ti ti-arrow-bar-right me-1"></i>
                                                </a>
                                            {{-- @endif --}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col d-flex">
                            <div class="card radius-10  border-info border-1">
                                <div class="card-body">
                                    <div class="text-center">
                                        <i class="ti ti-files text-primary" style="font-size:50px"></i>
                                        <h5 class="my-0">{{ __('Documents Management') }}</h5>
                                        <p class="mb-0 text-secondary">
                                            {{ __('Reports, SoPs, Policies, Notices, and Templates.') }}
                                            {{-- @if (Auth::user()->hasPermission(['access_user_management_module'])) --}}
                                                <a href="{{ route('documents-dashboard') }}"
                                                    class="btn btn-sm btn-outline-success">
                                                    <i class="ti ti-arrow-bar-right me-1"></i>
                                                </a>
                                            {{-- @endif --}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                            <div class="col d-flex">
                                <div class="card radius-10  border-info border-1">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <i class="ti ti-user-plus text-primary" style="font-size:50px"></i>
                                            <h5 class="my-0">{{ __('user-mgt.user_management') }}</h5>
                                            <p class="mb-0 text-secondary">
                                                {{ __('Managing MERP system settings, users, their roles and permissions, and tracking user activity on the system.') }}
                                                {{-- @if (Auth::user()->hasPermission(['access_user_management_module'])) --}}
                                                    <a href="{{ route('usermanagement') }}"
                                                        class="btn btn-sm btn-outline-success">
                                                        <i class="ti ti-arrow-bar-right me-1"></i>
                                                    </a>
                                                {{-- @endif --}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                @endif
            </div>
            {{-- <div class="col-lg-6">
                <div class="card-group mb-3">
                    <div class="card">
                        <img class="img-fluid bg-light-alt" src="assets/images/small/ex-card.png" alt="Card image">
                        <div class="card-header">
                            <h4 class="card-title">Card Groups Example</h4>
                        </div><!--end card-header-->
                        <div class="card-body">
                            <p class="card-text">This is a wider card supporting text below to content.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div><!--end card-body-->
                    </div><!--end card-->
                    <div class="card">
                        <img class="img-fluid bg-light-alt" src="assets/images/small/ex-card.png" alt="Card image">
                        <div class="card-header">
                            <h4 class="card-title">Card Groups Example</h4>
                        </div><!--end card-header-->
                        <div class="card-body">
                            <p class="card-text">This is a wider card supporting text below to content.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div><!--end card-body-->
                    </div><!--end card-->
                    <div class="card">
                        <img class="img-fluid bg-light-alt" src="assets/images/small/ex-card.png" alt="Card image">
                        <div class="card-header">
                            <h4 class="card-title">Card Groups Example</h4>
                        </div><!--end card-header-->
                        <div class="card-body">
                            <p class="card-text">This is a wider card supporting text below to content.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div><!--end card-group-->
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4 bg-light-alt align-self-center">
                            <img src="assets/images/small/ex-card.png" alt="..."  class="img-fluid bg-light-alt">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text mb-0">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                <p class="card-text mb-0"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end col-->  
            <div class="col-lg-6">
                <div class="row row-cols-1 row-cols-md-2 gx-3">
                    <div class="col">
                        <div class="card">
                            <img src="assets/images/small/ex-card.png" class="card-img-top bg-light-alt" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->
                    <div class="col">
                        <div class="card">
                            <img src="assets/images/small/ex-card.png" class="card-img-top bg-light-alt" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->
                    <div class="col">
                        <div class="card">
                            <img src="assets/images/small/ex-card.png" class="card-img-top bg-light-alt" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->
                    <div class="col">
                        <div class="card">
                            <img src="assets/images/small/ex-card.png" class="card-img-top bg-light-alt" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end col-->                --}}
        </div><!--end row-->
    </div>

</x-holizontal-layout>
