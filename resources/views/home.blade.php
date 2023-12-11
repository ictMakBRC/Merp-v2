<x-app-layout>
    <div>
        <div class="container">
            <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-3">
                <div class="col">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('assets/images/home/hr.jpg') }}" alt="..."
                                    class="card-img">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Human Resource</h5>
                                    <p class="card-text">Recruitment, Compensation and Employee relations. <a
                                            href="{{route('human-resource-dashboard')}}" class="btn btn-sm btn-outline-success not_active">
                                            <i class="fa fa-arrow-right me-1"></i></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('assets/images/home/inventory.jpg') }}" alt="..."
                                    class="card-img">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Inventory & Logistics</h5>
                                    <p class="card-text">Forecasting, Acquisition, Consumption, and Tracking. <a
                                            href="{{route('inventory-dashboard')}}" class="btn btn-sm btn-outline-success not_active">
                                            <i class="fa fa-arrow-right me-1"></i></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('assets/images/home/assets.jpg') }}" alt="..."
                                    class="card-img">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Assets Management</h5>
                                    <p class="card-text">Identification, Acquisition, Maintenance and Disposal. <a
                                            href="{{route('asset-dashboard')}}" class="btn btn-sm btn-outline-success not_active">
                                            <i class="fa fa-arrow-right me-1"></i></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('assets/images/home/finance.jpg') }}" alt="..."
                                    class="card-img">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Finance & Accounting</h5>
                                    <p class="card-text">Budgeting, Accounting, Invoicing, and Requisition. <a
                                            href="{{route('finance-dashboard')}}" class="btn btn-sm btn-outline-success not_active">
                                            <i class="fa fa-arrow-right me-1"></i></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('assets/images/home/procurement.jpg') }}" alt="..."
                                    class="card-img">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Procurement</h5>
                                    <p class="card-text">Planning, Identification, Selection, and Aquisition. <a
                                            href="{{route('procurement-dashboard')}}" class="btn btn-sm btn-outline-success not_active">
                                            <i class="fa fa-arrow-right me-1"></i></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('assets/images/home/documents.jpg') }}" alt="..."
                                    class="card-img">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Document Control</h5>
                                    <p class="card-text">Reports, SoPs, Policies, Notices, and Templates. <a
                                            href="{{route('documents-dashboard')}}" class="btn btn-sm btn-outline-success not_active">
                                            <i class="fa fa-arrow-right me-1"></i></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('assets/images/home/timesheets.jpg') }}" alt="..."
                                    class="card-img">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Staff Timesheets</h5>
                                    <p class="card-text">Track employee work hours, leaves, and accruals.. <a
                                            href="#" class="btn btn-sm btn-outline-success not_active">
                                            <i class="fa fa-arrow-right me-1"></i></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('assets/images/home/monitoring.jpg') }}" alt="..."
                                    class="card-img">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Internal Monitoring</h5>
                                    <p class="card-text">Monitoring and Evaluation, Projects progress tracking.<a
                                            href="{{ route('manage-grants') }}" class="btn btn-sm btn-outline-success not_active">
                                            <i class="fa fa-arrow-right me-1"></i></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('assets/images/home/kpi.jpg') }}" alt="..."
                                    class="card-img">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">KPI Dashboard</h5>
                                    <p class="card-text">Tracking KPIs, summaries and aggrigates.<a href="#"
                                            class="btn btn-sm btn-outline-success not_active">
                                            <i class="fa fa-arrow-right me-1"></i></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
