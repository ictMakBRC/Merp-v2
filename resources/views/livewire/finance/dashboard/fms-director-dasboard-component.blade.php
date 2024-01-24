<div>

    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="float-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Metrica</a>
                            </li><!--end nav-item-->
                            <li class="breadcrumb-item"><a href="#">Dashboard</a>
                            </li><!--end nav-item-->
                            <li class="breadcrumb-item active">Analytics</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Analytics</h4>
                </div><!--end page-title-box-->
            </div><!--end col-->
        </div>
        <!-- end page title end breadcrumb -->
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-lg-12">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold">Budgeted Income</p>
                                        <h3 class="my-1 font-20 fw-bold">@moneyFormat($budget->total_income??0)</h3>
                                        <p class="mb-0 text-truncate text-muted"><span class="text-success"><i class="mdi mdi-trending-up"></i>8.5%</span>Today</p>
                                    </div><!--end col-->
                                    <div class="col-3 align-self-center">
                                        <div class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                            <i class="ti ti-users font-24 align-self-center text-muted"></i>
                                        </div>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div><!--end card-body--> 
                        </div><!--end card--> 
                    </div> <!--end col--> 
                    <div class="col-md-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center">                                                
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold">Budgeted Expense</p>
                                        <h3 class="my-1 font-20 fw-bold">@moneyFormat($budget->total_expenses??0)</h3>
                                        <p class="mb-0 text-truncate text-muted"><span class="text-success"><i class="mdi mdi-trending-up"></i>1.5%</span> Weekly</p>
                                    </div><!--end col-->
                                    <div class="col-3 align-self-center">
                                        <div class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                            <i class="ti ti-clock font-24 align-self-center text-muted"></i>
                                        </div>
                                    </div> <!--end col-->
                                </div><!--end row-->
                            </div><!--end card-body--> 
                        </div><!--end card--> 
                    </div> <!--end col--> 
                    <div class="col-md-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center">                                                
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold">Overdue Invoices</p>
                                        <h3 class="my-1 font-20 fw-bold">@moneyFormat($overDueInvoices)</h3>
                                        <p class="mb-0 text-truncate text-muted"><span class="text-danger"><i class="mdi mdi-trending-down"></i>35%</span>Weekly</p>
                                    </div><!--end col-->
                                    <div class="col-3 align-self-center">
                                        <div class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                            <i class="ti ti-activity font-24 align-self-center text-muted"></i>
                                        </div>
                                    </div> <!--end col-->
                                </div><!--end row-->
                            </div><!--end card-body--> 
                        </div><!--end card--> 
                    </div> <!--end col--> 
                    <div class="col-md-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-9">  
                                        <p class="text-dark mb-0 fw-semibold">Goal Completions</p>                                         
                                        <h3 class="my-1 font-20 fw-bold">85000</h3>
                                        <p class="mb-0 text-truncate text-muted"><span class="text-success"><i class="mdi mdi-trending-up"></i>10.5%</span> Completions Weekly</p>
                                    </div><!--end col-->
                                    <div class="col-3 align-self-center">
                                        <div class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                            <i class="ti ti-confetti font-24 align-self-center text-muted"></i>
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
                                <h4 class="card-title">Income Expense Overview</h4>                      
                            </div><!--end col-->
                            <div class="col-auto"> 
                                <div class="dropdown">
                                    <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                       This Year<i class="las la-angle-down ms-1"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Today</a>
                                        <a class="dropdown-item" href="#">Last Week</a>
                                        <a class="dropdown-item" href="#">Last Month</a>
                                        <a class="dropdown-item" href="#">This Year</a>
                                    </div>
                                </div>               
                            </div><!--end col-->
                        </div>  <!--end row-->                                  
                    </div><!--end card-header-->
                    <div class="card-body">
                        <div class="">
                            <div wire:ignore id="transactions_report" class="apex-charts"></div>
                        </div> 
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div><!--end col-->
        </div><!--end row-->

        <div class="row d-none">
            <div class="col-lg-4"> 
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">                      
                                <h4 class="card-title">Live Visits Our New Site</h4>                      
                            </div><!--end col-->
                            <div class="col-auto"> 
                                <div class="dropdown">
                                    <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                       Today<i class="las la-angle-down ms-1"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Today</a>
                                        <a class="dropdown-item" href="#">Yesterday</a>
                                        <a class="dropdown-item" href="#">Last Week</a>
                                    </div>
                                </div>               
                            </div><!--end col-->
                        </div>  <!--end row-->                                  
                    </div><!--end card-header--> 
                    <div class="card-body">   
                        <div id="circlechart" class="apex-charts"></div>   
                        <div>
                            <div class="row">
                                <div class="col-lg">
                                    <h4 class="card-title mt-0 mb-2">Traffic Sources</h4>                                         
                                    <div class="traffic-card">                                                
                                        <h4 class="my-2">80</h4>
                                        <p class="mb-2 fw-semibold">Right Now</p>
                                    </div>                                                
                                </div><!--end col-->
                                <div class="col-lg-auto align-self-center">   
                                    <ul class="list-unstyled url-list mb-0">
                                        <li>
                                            <i class="fas fa-caret-right font-16 text-primary"></i>
                                            <span>Organic</span>                                                                                                      
                                        </li>
                                        <li>
                                            <i class="fas fa-caret-right font-16 text-success"></i> 
                                            <span>Direct</span>                                              
                                        </li>
                                        <li>
                                            <i class="fas fa-caret-right font-16 text-gray"></i>
                                            <span>Campaign</span>                                                 
                                        </li>                                                
                                    </ul>
                                </div><!--end col-->
                            </div><!--end row-->      
                            <div class="progress mb-1">                                                    
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">55%</div>
                                <div class="progress-bar bg-info" role="progressbar" style="width: 28%" aria-valuenow="28" aria-valuemin="0" aria-valuemax="100">28%</div>
                                <div class="progress-bar bg-soft-secondary" role="progressbar" style="width: 17%" aria-valuenow="17" aria-valuemin="0" aria-valuemax="100">17%</div>
                            </div> 
                        </div>                                                      
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div><!--end col-->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">                      
                                <h4 class="card-title">Pages View by Users</h4>                      
                            </div><!--end col-->
                            <div class="col-auto"> 
                                <div class="dropdown">
                                    <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                       Today<i class="las la-angle-down ms-1"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Today</a>
                                        <a class="dropdown-item" href="#">Yesterday</a>
                                        <a class="dropdown-item" href="#">Last Week</a>
                                    </div>
                                </div>               
                            </div><!--end col-->
                        </div>  <!--end row-->                                  
                    </div><!--end card-header-->                                
                    <div class="card-body">
                        <ul class="list-group custom-list-group">
                            <li class="list-group-item align-items-center d-flex justify-content-between">
                                <div class="media">
                                    <img src="assets/images/small/rgb.svg" height="30" class="me-3 align-self-center rounded" alt="...">
                                    <div class="media-body align-self-center"> 
                                        <h6 class="m-0">Dastone - Admin Dashboard</h6>
                                        <p class="mb-0 text-muted">analytic-index.html</p>                                                                                           
                                    </div><!--end media body-->
                                </div>
                                <div class="align-self-center">
                                    <a href="" class="btn btn-sm btn-soft-primary">4.3k <i class="las la-external-link-alt font-15"></i></a>  
                                </div>                                            
                            </li>
                            <li class="list-group-item align-items-center d-flex justify-content-between">
                                <div class="media">
                                    <img src="assets/images/small/cobweb.svg" height="30" class="me-3 align-self-center rounded" alt="...">
                                    <div class="media-body align-self-center"> 
                                        <h6 class="m-0">Metrica Simple- Admin Dashboard</h6>
                                        <p class="mb-0 text-muted">sales-index.html</p>                                                                                             
                                    </div><!--end media body-->
                                </div>
                                <div class="align-self-center">
                                    <a href="" class="btn btn-sm btn-soft-primary">3.7k <i class="las la-external-link-alt font-15"></i></a>  
                                </div>
                            </li>
                            <li class="list-group-item align-items-center d-flex justify-content-between">
                                <div class="media">
                                    <img src="assets/images/small/blocks.svg" height="30" class="me-3 align-self-center rounded" alt="...">
                                    <div class="media-body align-self-center"> 
                                        <h6 class="m-0">Crovex - Admin Dashboard</h6>
                                        <p class="mb-0 text-muted">helpdesk-index.html</p>                                                                                          
                                    </div><!--end media body-->
                                </div>
                                <div class="align-self-center">
                                    <a href="" class="btn btn-sm btn-soft-primary">2.9k <i class="las la-external-link-alt font-15"></i></a>  
                                </div>   
                            </li>
                            <li class="list-group-item align-items-center d-flex justify-content-between">
                                <div class="media">
                                    <img src="assets/images/small/atom.svg" height="30" class="me-3 align-self-center rounded" alt="...">
                                    <div class="media-body align-self-center"> 
                                        <h6 class="m-0">Annex - Admin Dashboard</h6>
                                        <p class="mb-0 text-muted">calendar.html</p>                                                                                           
                                    </div><!--end media body-->
                                </div>
                                <div class="align-self-center">
                                    <a href="" class="btn btn-sm btn-soft-primary">1.6k <i class="las la-external-link-alt font-15"></i></a>                                                                                               
                                </div>   
                            </li>
                        </ul>                                
                    </div><!--end card-body--> 
                </div><!--end card--> 
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <h2 class="m-0 align-self-center">80</h2>
                            <div class="d-block ms-2 align-self-center">
                                <span class="text-warning">Right now</span>
                                <h5 class="my-1">Traffic Sources</h5>
                                <p class="mb-0 text-muted">It is a long established fact that a reader will 
                                    be of a page when looking at its layout.
                                    <a href="" class="text-primary">Read More <i class="las la-arrow-right"></i></a>
                                </p>
                            </div>
                        </div>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div> <!--end col--> 
                                    
            
            <div class="col-lg-4">
                <div class="card">   
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">                      
                                <h4 class="card-title">Activity</h4>                      
                            </div><!--end col-->
                            <div class="col-auto"> 
                                <div class="dropdown">
                                    <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        All<i class="las la-angle-down ms-1"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Purchases</a>
                                        <a class="dropdown-item" href="#">Emails</a>
                                    </div>
                                </div>          
                            </div><!--end col-->
                        </div>  <!--end row-->                                  
                    </div><!--end card-header-->                                              
                    <div class="card-bodyp-0"> 
                        <div class="p-3" data-simplebar style="height: 400px;">
                            <div class="activity">
                                <div class="activity-info">
                                    <div class="icon-info-activity">
                                        <i class="las la-user-clock bg-soft-primary"></i>
                                    </div>
                                    <div class="activity-info-text">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="text-muted mb-0 font-13 w-75"><span>Donald</span> 
                                                updated the status of <a href="">Refund #1234</a> to awaiting customer response
                                            </p>
                                            <small class="text-muted">10 Min ago</small>
                                        </div>    
                                    </div>
                                </div>   

                                <div class="activity-info">
                                    <div class="icon-info-activity">
                                        <i class="mdi mdi-timer-off bg-soft-primary"></i>
                                    </div>
                                    <div class="activity-info-text">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="text-muted mb-0 font-13 w-75"><span>Lucy Peterson</span> 
                                                was added to the group, group name is <a href="">Overtake</a>
                                            </p>
                                            <small class="text-muted">50 Min ago</small>
                                        </div>    
                                    </div>
                                </div>   

                                <div class="activity-info">
                                    <div class="icon-info-activity">
                                        <img src="assets/images/users/user-5.jpg" alt="" class="rounded-circle thumb-sm">
                                    </div>
                                    <div class="activity-info-text">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="text-muted mb-0 font-13 w-75"><span>Joseph Rust</span> 
                                                opened new showcase <a href="">Mannat #112233</a> with theme market
                                            </p>
                                            <small class="text-muted">10 hours ago</small>
                                        </div>    
                                    </div>
                                </div>   

                                <div class="activity-info">
                                    <div class="icon-info-activity">
                                        <i class="mdi mdi-clock-outline bg-soft-primary"></i>
                                    </div>
                                    <div class="activity-info-text">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="text-muted mb-0 font-13 w-75"><span>Donald</span> 
                                                updated the status of <a href="">Refund #1234</a> to awaiting customer response
                                            </p>
                                            <small class="text-muted">Yesterday</small>
                                        </div>    
                                    </div>
                                </div>   
                                <div class="activity-info">
                                    <div class="icon-info-activity">
                                        <i class="mdi mdi-alert-outline bg-soft-primary"></i>
                                    </div>
                                    <div class="activity-info-text">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="text-muted mb-0 font-13 w-75"><span>Lucy Peterson</span> 
                                                was added to the group, group name is <a href="">Overtake</a>
                                            </p>
                                            <small class="text-muted">14 Nov 2019</small>
                                        </div>    
                                    </div>
                                </div> 
                                <div class="activity-info">
                                    <div class="icon-info-activity">
                                        <img src="assets/images/users/user-4.jpg" alt="" class="rounded-circle thumb-sm">
                                    </div>
                                    <div class="activity-info-text">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="text-muted mb-0 font-13 w-75"><span>Joseph Rust</span> 
                                                opened new showcase <a href="">Mannat #112233</a> with theme market
                                            </p>
                                            <small class="text-muted">15 Nov 2019</small>
                                        </div>    
                                    </div>
                                </div>                                                                                                                                      
                            </div><!--end activity-->
                        </div><!--end analytics-dash-activity-->
                    </div>  <!--end card-body-->                                     
                </div><!--end card--> 
            </div><!--end col--> 
           
        </div><!--end row-->
        <div class="row">                        
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">                      
                                <h4 class="card-title">Bank Account Reports</h4>                      
                            </div><!--end col-->                                        
                        </div>  <!--end row-->                                  
                    </div><!--end card-header-->
                    <div class="card-body">
                        <div class="table-responsive browser_users">
                            <table class="table mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-top-0">#</th>
                                        <th class="border-top-0">Type</th>
                                        <th class="border-top-0">Name</th>
                                        <th class="border-top-0">Amount</th>
                                    </tr><!--end tr-->
                                </thead>
                                <tbody>
                                    @foreach ($bank_accounts as $key => $account)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $account->type }}</td>
                                            <td>{{ $account->name}}</td>
                                            {{-- <td>{{ $account->account_no??'N/A' }}</td> --}}
                                            <td>{{ $account->currency->code??''  }} @moneyFormat($account->current_balance)</td>
                                    <tr>    
                                    @endforeach    
                                </tbody>
                            </table> <!--end table-->                                               
                        </div><!--end /div-->
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div> <!--end col-->   
            
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">                      
                                <h4 class="card-title">Unit/project ledger Reports</h4>                      
                            </div><!--end col-->                                        
                        </div>  <!--end row-->                                  
                    </div><!--end card-header-->
                    <div class="card-body">
                        <div class="table-responsive browser_users">
                            <table class="table mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-top-0">#</th>
                                        <th class="border-top-0">Unit</th>
                                        <th class="border-top-0">Opening Balance</th>
                                        <th class="border-top-0">Current Balance</th>
                                    </tr><!--end tr-->
                                </thead>
                                <tbody>
                                    @foreach ($ledger_accounts as $key => $account)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $account->requestable->name }}</td>
                                            <td>{{ $account->currency->code??''  }} @moneyFormat($account->opening_balance)</td>
                                            <td>{{ $account->currency->code??''  }} @moneyFormat($account->current_balance)</td>
                                    <tr>
                                        @endforeach           
                                </tbody>
                            </table> <!--end table-->                                               
                        </div><!--end /div--> 
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div> <!--end col-->
        </div><!--end row-->

    </div><!-- container -->
    @push('scripts')
    <script>       

        var options2 = {
            series: [{
                    name: 'Total Incomes',
                    data: [
                        @foreach ($transactions_chart as $data)
                        // {{ $data->total_expense }},
                        "{{ sprintf('%.2f', $data->total_income) }}",
                        
                        @endforeach
                    ]
                }, 
                {
                    name: 'Total Expenses',
                    data: [
                        @foreach ($transactions_chart as $data)
                        // {{ $data->total_expense }},
                        "{{ sprintf('%.2f', $data->total_expense) }}",
                        @endforeach
                    ]
                }

            ],
            colors: ['#2A76F4', '#67C8FF','#951F39', '#33C481'],
            chart: {
                height: 350,
                type: 'bar'
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                categories: [
                    @foreach ($transactions_chart as $data)
                        '{{ $data->display_date }}',
                    @endforeach
                ]
            },

        };

        var chart2 = new ApexCharts(document.querySelector("#transactions_report"), options2);
        chart2.render();
    </script>
    @endpush
</div>