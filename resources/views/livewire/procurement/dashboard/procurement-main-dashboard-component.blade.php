<div>
    <div class="row">
        <div class="col-lg-9">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-3">
                    <div class="card border-info">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col-9">
                                    <p class="text-dark mb-0 fw-semibold">Requests</p>
                                    <h5 class="my-1 font-20 fw-bold">{{ $totalRequests }}</h5>
                                    <p class="mb-0 text-truncate text-muted"><span
                                            class="text-success">{{ $totalRequestsCompleted }}</span> Completed</p>
                                </div><!--end col-->
                                <div class="col-3 align-self-center">
                                    <div
                                        class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                        <i class="ti ti-file-text font-24 align-self-center text-muted"></i>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
                <div class="col-md-6 col-lg-3">
                    <div class="card border-info">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col-9">
                                    <p class="text-dark mb-0 fw-semibold">Providers</p>
                                    <h5 class="my-1 font-20 fw-bold">{{ $providersCount }}</h5>
                                    <p class="mb-0 text-truncate text-muted"><span class="text-success">Active</p>
                                </div><!--end col-->
                                <div class="col-3 align-self-center">
                                    <div
                                        class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                        <i class="ti ti-truck-delivery font-24 align-self-center text-muted"></i>
                                    </div>
                                </div> <!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
                <div class="col-md-6 col-lg-3">
                    <div class="card border-info">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col-9">
                                    <p class="text-dark mb-0 fw-semibold">Avg TAT</p>
                                    <h5 class="my-1 font-20 fw-bold">{{ $avgTat }}</h5>
                                    <p class="mb-0 text-truncate text-muted"><span class="text-success">Days</p>
                                </div><!--end col-->
                                <div class="col-3 align-self-center">
                                    <div
                                        class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                        <i class="ti ti-clock font-24 align-self-center text-muted"></i>
                                    </div>
                                </div> <!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
                <div class="col-md-6 col-lg-3">
                    <div class="card border-info">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col-9">
                                    <p class="text-dark mb-0 fw-semibold">Expenditure ({{ getDefaultCurrency()->code }})
                                    </p>
                                    <h5 class="my-1 font-20 fw-bold">@moneyFormat($totalExpenditure) (M)</h5>
                                    <p class="mb-0 text-truncate text-muted"><span class="text-success">For Completed
                                    </p>
                                </div><!--end col-->
                                <div class="col-3 align-self-center">
                                    <div
                                        class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                        <i class="ti ti-report-money font-24 align-self-center text-muted"></i>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
            </div><!--end row-->
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Financial year summary</h4>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="">
                        <div id="financial_year_contract_total" class="apex-charts"></div>
                        <h6 class="text-primary bg-soft-primary p-3 mb-0">
                            <i class="ti ti-chart-bar align-self-center icon-xs me-1"></i>
                            Financial Year (Procurement Requests)
                        </h6>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header bg-light">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Requests Per Step</h4>
                        </div><!--end col-->
                        <div class="col-auto">
                            <div class="dropdown">
                                <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    All<i class="las la-angle-down ms-1"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('procurement-office-panel') }}">View all</a>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive mt-0">
                        <table class="table border-dashed mb-0">
                            <thead>
                                <tr>
                                    <th>Step</th>
                                    <th class="text-end">Number of Requests</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($steps as $step)
                                    <tr>
                                        <td>{{ getProcurementRequestStep($step->step_order) }}</td>
                                        <td class="text-end"><span class="badge bg-danger">{{ $step->count }}</span>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table><!--end /table-->
                    </div><!--end /div-->
                </div><!--end card-body-->
            </div><!--end card-->
            {{-- <div class="col-lg-4"> --}}
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">                      
                                <h4 class="card-title">Updates</h4>                      
                            </div><!--end col-->
                        </div>  <!--end row-->                                  
                    </div><!--end card-header-->
                    <div class="card-body dash-info-carousel">                                    
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="row">    
                                        <div class="col-12 align-self-center">
                                            <h6 class="mt-0 text-start">Apollo Hospital</h6>
                                            <div class="media mt-3">
                                                <img src="assets/images/users/dr-1.jpg" alt="" height="70"  class="rounded-circle">                                   
                                                <div class="media-body align-self-center ms-3">
                                                    <h5 class="mt-0 mb-1 font-15">Dr.Helen White</h5>
                                                    <p class="text-muted mb-0"><span class="me-2 text-secondary">MS Cardiology</span> 11:00am to 03:00pm</p>
                                                    <ul class="list-inline mb-0">
                                                        <li class="list-inline-item m-0"><i class="mdi mdi-star text-warning font-16"></i></li>
                                                        <li class="list-inline-item m-0"><i class="mdi mdi-star text-warning font-16"></i></li>
                                                        <li class="list-inline-item m-0"><i class="mdi mdi-star text-warning font-16"></i></li>
                                                        <li class="list-inline-item m-0"><i class="mdi mdi-star text-warning font-16"></i></li>
                                                        <li class="list-inline-item m-0"><i class="mdi mdi-star-half text-warning font-16"></i></li>
                                                        <li class="list-inline-item m-0"><small class="text-muted">4.91/5 (1021 reviews)</small></li>
                                                    </ul> 
                                                </div><!--end media-body-->
                                            </div> <!--end media--> 
                                            <hr class="hr-dashed">                                                         
                                            <div class="p-2 bg-light">                                                           
                                                <div class="media">
                                                   <h3>68</h3>                                     
                                                    <div class="media-body align-self-center ms-3">
                                                        <p class="mb-0 font-weight-semibold text-uppercase text-dark-alt">Appointments</p>
                                                        <p class="mb-0 text-muted">Last Saturday 52 Appointments</p>
                                                    </div><!--end media-body-->
                                                </div>
                                            </div>                                                    
                                        </div><!--end col-->                                                        
                                    </div><!--end row-->  
                                </div><!--end carousel-item-->
                                <div class="carousel-item">
                                    <div class="row">   
                                        <div class="col-12 align-self-center">
                                            <h6 class="mt-0 text-start">Kaiser Foundation Hospital</h6>
                                            <div class="media mt-3">
                                                <img src="assets/images/users/dr-3.jpg" alt="" height="70"  class="rounded-circle">                                   
                                                <div class="media-body align-self-center ms-3">
                                                    <h5 class="mt-0 mb-1 font-15">Dr.Wendy Keen</h5>
                                                    <p class="text-muted mb-0"><span class="me-2 text-secondary">MD Neurology</span> 01:00pm to 04:00pm</p>
                                                    <ul class="list-inline mb-0">
                                                        <li class="list-inline-item m-0"><i class="mdi mdi-star text-warning font-16"></i></li>
                                                        <li class="list-inline-item m-0"><i class="mdi mdi-star text-warning font-16"></i></li>
                                                        <li class="list-inline-item m-0"><i class="mdi mdi-star text-warning font-16"></i></li>
                                                        <li class="list-inline-item m-0"><i class="mdi mdi-star text-warning font-16"></i></li>
                                                        <li class="list-inline-item m-0"><i class="mdi mdi-star-half text-warning font-16"></i></li>
                                                        <li class="list-inline-item m-0"><small class="text-muted">4.91/5 (1021 reviews)</small></li>
                                                    </ul> 
                                                </div><!--end media-body-->
                                            </div> <!--end media--> 
                                            <hr class="hr-dashed"> 
                                            <div class="p-2 bg-light">                                                           
                                                <div class="media">
                                                   <h3>42</h3>                                     
                                                    <div class="media-body align-self-center ms-3">
                                                        <p class="mb-0 font-weight-semibold text-uppercase text-dark-alt">Appointments</p>
                                                        <p class="mb-0 text-muted">Last Saturday 52 Appointments</p>
                                                    </div><!--end media-body-->
                                                </div>
                                            </div>                                                 
                                        </div><!--end col-->                                       
                                    </div><!--end row-->  
                                </div><!--end carousel-item-->
                                <div class="carousel-item">
                                    <div class="row">  
                                        <div class="col-12 align-self-center">

                                            <h6 class="mt-0 text-start">Florida Hospital</h6>
                                            <div class="media mt-3">
                                                <img src="assets/images/users/dr-2.jpg" alt="" height="70"  class="rounded-circle">                                   
                                                <div class="media-body align-self-center ms-3">
                                                    <h5 class="mt-0 mb-1 font-15">Dr.Lisa King</h5>
                                                    <p class="text-muted mb-0"><span class="me-2 text-secondary">MD Orthopedic</span> 09:00am to 11:30am</p>
                                                    <ul class="list-inline mb-0">
                                                        <li class="list-inline-item m-0"><i class="mdi mdi-star text-warning font-16"></i></li>
                                                        <li class="list-inline-item m-0"><i class="mdi mdi-star text-warning font-16"></i></li>
                                                        <li class="list-inline-item m-0"><i class="mdi mdi-star text-warning font-16"></i></li>
                                                        <li class="list-inline-item m-0"><i class="mdi mdi-star text-warning font-16"></i></li>
                                                        <li class="list-inline-item m-0"><i class="mdi mdi-star-half text-warning font-16"></i></li>
                                                        <li class="list-inline-item m-0"><small class="text-muted">4.91/5 (1021 reviews)</small></li>
                                                    </ul> 
                                                </div><!--end media-body-->
                                            </div> <!--end media--> 
                                            <hr class="hr-dashed"> 
                                            <div class="p-2 bg-light">                                                           
                                                <div class="media">
                                                   <h3>35</h3>                                     
                                                    <div class="media-body align-self-center ms-3">
                                                        <p class="mb-0 font-weight-semibold text-uppercase text-dark-alt">Appointments</p>
                                                        <p class="mb-0 text-muted">Last Saturday 52 Appointments</p>
                                                    </div><!--end media-body-->
                                                </div>
                                            </div>                                            
                                        </div><!--end col-->                                                        
                                    </div><!--end row-->  
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"  data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"  data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>                                    
                    </div><!--end card-body-->                                                                                                        
                </div><!--end card-->
            {{-- </div><!-- end col--> --}}

        </div> <!--end col-->
    </div><!--end row-->

    <div class="row row-cols-1 row-cols-md-1 row-cols-lg-3 row-cols-xl-3">
        <div class="col d-flex">
            <div class="card border-info flex-grow-1">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Procurement Thresholds</h4>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <div id="procurement_categorization" class="apex-charts"></div>
                    <div>
                        <div class="row">
                            <div class="table-responsive mt-0">
                                <table class="table border-dashed mb-0 text-start">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th class="text-end">Number of Requests</th>
                                            <th class="text-end">Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($countsPerCategorization as $category)
                                            <tr>
                                                <td>{{ $category['name'] }}</td>
                                                <td class="text-end"><span
                                                        class="badge bg-info">{{ $category['count'] }}</span>
                                                </td>
                                                <td>@moneyFormat($category['contract_total']) M</td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table><!--end /table-->
                            </div><!--end /div-->
                        </div><!--end row-->
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->

        <div class="col d-flex">
            <div class="card border-info flex-grow-1">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Categories</h4>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <ul class="list-group custom-list-group">
                        @forelse ($countsPerSector as $category)
                            <li class="list-group-item align-items-center d-flex justify-content-between">
                                <div class="media">
                                    <div class="media-body align-self-center">
                                        <h6 class="m-0">{{ $category['sector'] }}</h6>
                                        <small class="mb-0 text-dange">Requests <span
                                                class="badge bg-danger">{{ $category['count'] }}</span></small>
                                    </div><!--end media body-->
                                </div>
                                <div class="align-self-center">
                                    <a href="#" class="btn btn-sm btn-soft-primary">@moneyFormat($category['contract_total']) M</a>
                                </div>
                            </li>
                        @empty
                        @endforelse
                    </ul>
                </div><!--end card-body-->
                <div class="card border-info mx-2">
                    <div class="card-body">
                        <div class="d-fle">
                            <h2 class="m-0 align-self-center">{{ $countLateDelivery }} %</h2>
                            <div class="d-block ms-2 align-self-center">
                                <span class="text-warning"><i class="ti ti-alert-triangle"></i>Procurement
                                    Requests</span>
                                <p class="mb-0 text-muted">Fulfilled beyond exepected deadline.
                                </p>
                            </div>
                        </div>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div><!--end card-->
        </div> <!--end col-->

        <div class="col d-flex">
            <div class="card border-info flex-grow-1">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Chain of custody Avg TAT</h4>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <ul class="list-group custom-list-group">
                        @forelse ($chainOfCustodyTat as $custody)
                            <li class="list-group-item align-items-center d-flex justify-content-between">
                                <div class="media">
                                    <div class="media-body align-self-center">
                                        <h6 class="m-0">{{ $custody['step'] }}</h6>
                                    </div><!--end media body-->
                                </div>
                                <div class="align-self-center">
                                    <a href="#"
                                        class="btn btn-sm btn-soft-primary">{{ round($custody['average_tat'], 1) }}
                                        Days</a>
                                </div>
                            </li>
                        @empty
                        @endforelse
                    </ul>
                </div><!--end card-body-->
            </div><!--end card-->
        </div>
    </div><!--end row-->

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Distribution Per Subcategory</h4>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="p-1 flex-glow-1" data-simplebar style="height: 400px;">
                        <div class="activity">
                            @forelse ($countsPerSubcategory as $subcategory)
                                <div class="activity-info">
                                    <div class="icon-info-activity">
                                        <i class="ti ti-shopping-cart-discount bg-soft-primary"></i>
                                    </div>
                                    <div class="activity-info-text">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="text-muted mb-0 font-13 w-75">
                                                <span>{{ $subcategory['name'] }}</span>
                                                take up <span class="badge bg-info">{{ $subcategory['count'] }}</span> Procurement Requests
                                            </p>
                                            <small class="text-success fw-bold">@moneyFormat($category['contract_total']) M</small>
                                            
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            @empty
                            @endforelse
                        </div><!--end activity-->
                    </div><!--end analytics-dash-activity-->
                </div> <!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->

        <div class="col-lg-4 d-flex">
            <div class="card flex-glow-1">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Provider Distribution (Top 10)</h4>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-top-0">Provider</th>
                                    <th class="border-top-0">Procurements Handled</th>
                                    <th class="border-top-0">Contract Value</th>
                                </tr><!--end tr-->
                            </thead>
                            <tbody>
                                @forelse ($countsPerProvider as $provider)
                                <tr>
                                    <td><a href="" class="text-primary">{{ $provider['name'] }}</a></td>
                                    <td><small class="badge bg-danger">{{ $provider['count'] }}</small></td>
                                    <td><small class="text-success fw-bold">@moneyFormat($provider['contract_total']) M</small></td>
                                </tr><!--end tr-->
                            @empty
                            
                            @endforelse
                                 
                            </tbody>
                        </table> <!--end table-->
                    </div><!--end /div-->
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!--end col-->

        <div class="col-lg-4 d-flex">
            <div class="card flex-glow-1">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Procurement Methods Distribution</h4>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive browser_users">
                        <table class="table mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-top-0">Procurement Method</th>
                                    <th class="border-top-0">Procurements Requests</th>
                                    <th class="border-top-0">Contract Value</th>
                                </tr><!--end tr-->
                            </thead>
                            <tbody>
                                @forelse ($countsPerMethod as $method)
                                <tr>
                                    <td><a href="" class="text-primary">{{ $method['name'] }}</a></td>
                                    <td><small class="badge bg-danger">{{ $method['count'] }}</small></td>
                                    <td><small class="text-success fw-bold">@moneyFormat($method['contract_total']) M</small></td>
                                </tr><!--end tr-->
                            @empty
                            
                            @endforelse
                                
                            </tbody>
                        </table> <!--end table-->
                    </div><!--end /div-->
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!--end col-->
    </div><!--end row-->




    @push('scripts')
        <script>
            var options = {
                    chart: {
                        height: 325,
                        type: "bar",
                        toolbar: {
                            show: !1
                        }
                    },
                    colors: ["#67c8ff", "#6d81f5"],
                    dataLabels: {
                        enabled: !1
                    },
                    stroke: {
                        show: !0,
                        curve: "smooth",
                        width: [1.5, 1.5],
                        dashArray: [0, 4],
                        lineCap: "round"
                    },
                    series: [{
                        name: "Total Value",
                        data: [
                            @foreach ($countsPerYear as $year)
                                '{{ $year['contract_total'] }}',
                            @endforeach
                        ]
                    }, ],
                    labels: [
                        @foreach ($countsPerYear as $year)
                            '{{ $year['year'] }}',
                        @endforeach
                    ],
                    yaxis: {
                        title: {
                            text: "Total Value (M) {{ getDefaultCurrency()->code }}"
                        },
                        labels: {
                            offsetX: -5,
                            offsetY: 0
                        }
                    },
                    legend: {
                        show: true,
                        position: 'top', // Adjust as needed: 'top', 'bottom', 'right', 'left'
                        horizontalAlign: 'center', // Adjust as needed: 'left', 'center', 'right'
                        onItemClick: {
                            toggleDataSeries: true
                        }
                    },
                    grid: {
                        borderColor: "#e0e6ed",
                        strokeDashArray: 3,
                        xaxis: {
                            lines: {
                                show: !0
                            }
                        },
                        yaxis: {
                            lines: {
                                show: !1
                            }
                        }
                    },

                    tooltip: {
                        y: {
                            formatter: function(e) {
                                return e + "M ({{ getDefaultCurrency()->code }})"
                            }
                        }
                    },

                    fill: {
                        type: "gradient",
                        gradient: {
                            type: "vertical",
                            shadeIntensity: 1,
                            inverseColors: !1,
                            opacityFrom: .28,
                            opacityTo: .05,
                            stops: [45, 100]
                        }
                    }
                },

                chart = (new ApexCharts(document.querySelector("#financial_year_contract_total"), options)).render(),

                donut_options = ({
                    chart: {
                        height: 240,
                        type: "donut"
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: "85%"
                            }
                        }
                    },
                    dataLabels: {
                        enabled: 1
                    },
                    stroke: {
                        show: !0,
                        width: 2,
                        colors: ["transparent"]
                    },
                    series: [
                        @foreach ($countsPerCategorization as $categorization)
                            '{{ $categorization['contract_total'] }}',
                        @endforeach
                    ],
                    legend: {
                        show: 1,
                        position: "bottom",
                        horizontalAlign: "center",
                        verticalAlign: "middle",
                        floating: !1,
                        fontSize: "14px",
                        offsetX: 0,
                        offsetY: -13
                    },
                    labels: [
                        @foreach ($countsPerCategorization as $categorization)
                            '{{ $categorization['name'] }}',
                        @endforeach
                    ],
                    colors: ["#67C2FE", "#41CBD8", "#22B783", ],
                    responsive: [{
                        breakpoint: 600,
                        options: {
                            plotOptions: {
                                donut: {
                                    customScale: .2
                                }
                            },
                            chart: {
                                height: 240
                            },
                            legend: {
                                show: 1
                            }
                        }
                    }],
                    tooltip: {
                        y: {
                            formatter: function(e) {
                                return e + "M ({{ getDefaultCurrency()->code }})"
                            }
                        }
                    }
                });

            (chart = new ApexCharts(document.querySelector("#procurement_categorization"), donut_options)).render();
        </script>
    @endpush
</div>
