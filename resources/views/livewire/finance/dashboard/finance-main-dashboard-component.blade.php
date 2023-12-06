<div>
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="float-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">MERP</a>
                                </li><!--end nav-item-->
                                <li class="breadcrumb-item"><a href="#">Finance</a>
                                </li><!--end nav-item-->
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Main Dashboard</h4>
                    </div><!--end page-title-box-->
                </div><!--end col-->
            </div>
            <!-- end page title end breadcrumb -->
            <!-- end page title end breadcrumb -->
            <div class="row">
                <div class="col-lg-9">
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-9">
                                            <p class="text-dark mb-0 fw-semibold">Total Requets</p>
                                            <h3 class="my-1 font-20 fw-bold">{{ $request_counts->count() }}</h3>
                                            <p class="mb-0 text-truncate text-muted"><span class="text-success"><i class="mdi mdi-trending-up"></i>
                                                {{ $request_counts->where('status', '!=', 'Completed')->count() }}</span> Pending</p>
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
                                            <p class="text-dark mb-0 fw-semibold">Inter-Trans Requets</p>
                                            <h3 class="my-1 font-20 fw-bold">{{ $request_counts->whereIn('request_type',['Internal Transfer'])->count() }}</h3>
                                            <p class="mb-0 text-truncate text-muted"><span class="text-success"><i class="mdi mdi-trending-up"></i>
                                                {{ $request_counts->whereIn('request_type',['Internal Transfer'])->where('status', '!=', 'Completed')->count() }}</span> Pending</p>
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
                                            <p class="text-dark mb-0 fw-semibold">Payemnt Requets</p>
                                            <h3 class="my-1 font-20 fw-bold">{{ $request_counts->whereIn('request_type',['Payment','Procurement', 'Advance Payment'])->count() }}</h3>
                                            <p class="mb-0 text-truncate text-muted"><span class="text-warning"><i class="mdi mdi-trending-up"></i>
                                                {{ $request_counts->whereIn('request_type',['Payment','Procurement Request', 'Advance Request'])->where('status', '!=', 'Completed')->count() }}</span> Pending</p>
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
                                            <p class="text-dark mb-0 fw-semibold">Petty cash Requets</p>
                                            <h3 class="my-1 font-20 fw-bold">{{ $request_counts->whereIn('request_type',['Petty Cash'])->count() }}</h3>
                                            <p class="mb-0 text-truncate text-muted"><span class="text-success"><i class="mdi mdi-trending-up"></i>
                                                {{ $request_counts->whereIn('request_type',['Petty Cash'])->where('status', '!=', 'Completed')->count() }}</span> Pending</p>
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
                <div class="col-lg-3">
                    <div class="card">
                                <h4 class="card-title mt-0 mb-2">Budget Overview</h4>                                         
                            <div class="card-body">
                            <div class="table-responsive mt-2">
                                <table class="table border-dashed mb-0">
                                    <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th class="text-end">Budgeted</th>
                                        <th class="text-end">Expected</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-success">
                                            <td class="text-end">Income</td>
                                            <td class="text-end">@moneyFormat(40000000)</td>
                                            <td class="text-end">@moneyFormat(1000000)</td>                                                 
                                            <td class="text-end">@moneyFormat(200000)</td>                                                 
                                        </tr>
                                        <tr class="text-info">
                                            <td class="text-end">Expense</td>
                                            <td class="text-end">@moneyFormat(20000000)</td>
                                            <td class="text-end">@moneyFormat(5000000)</td>                                                 
                                            <td class="text-end">@moneyFormat(250000)</td>                                                 
                                        </tr>
                                    </tbody>
                                </table><!--end /table-->
                            </div><!--end /div-->     
                            <div class="progress mb-1">                                                    
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 62%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100">62%</div>
                                <div class="progress-bar bg-info" role="progressbar" style="width: 38%" aria-valuenow="38" aria-valuemin="0" aria-valuemax="100">38%</div>
                            </div> 
                            </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">                      
                                    <h4 class="card-title">Invoices Overview</h4>                      
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
                        <div class="card-body">
                            <div class="text-center">
                                <div class="apex-charts" wire:ignore id="invoice_report"></div>
                                <h6 class="bg-light-alt py-3 px-2 mb-0">
                                    <i data-feather="calendar" class="align-self-center icon-xs me-1"></i>
                                    01 January 2023 to 31 December 2023
                                </h6>
                            </div>  
                            <div class="table-responsive mt-2">
                                <table class="table border-dashed mb-0">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th class="text-end">Statua</th>
                                        <th class="text-end">Amount(UGX)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoice_amounts as $invoice)
                                        @php
                                            if($invoice->status =='Paid'){
                                                $color = 'text-primary';
                                            } elseif($invoice->status =='Partially Paid'){
                                                $color = 'text-info';
                                            }elseif($invoice->status =='Approved'){
                                                $color = 'text-warning';
                                            }else{                                    
                                                $color = 'text-secondary';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="text-end"><i class="fas fa-play {{ $color  }} me-2"></i></td>
                                            <td class="text-end">{{ $invoice->status }}</td>
                                            <td class="text-end">@moneyFormat($invoice->amount)</td>                                                 
                                        </tr>
                                    @endforeach
                                    
                                    
                                    </tbody>
                                </table><!--end /table-->
                            </div><!--end /div-->                                 
                        </div><!--end card-body--> 
                    </div><!--end card--> 
                </div> <!--end col--> 
            </div><!--end row-->

            <div class="row">
                @if (count($requests) > 0)
        
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 class="card-title">Income Transactions</h4>
                                    </div><!--end col-->
                                    <div class="col-auto">
                                        <div class="dropdown">
                                            <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                This Month<i class="las la-angle-down ms-1"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Today</a>
                                                <a class="dropdown-item" href="#">Last Week</a>
                                                <a class="dropdown-item" href="#">Last Month</a>
                                                <a class="dropdown-item" href="#">This Year</a>
                                            </div>
                                        </div>
                                    </div><!--end col-->
                                </div> <!--end row-->
                            </div><!--end card-header-->
                            <div class="card-body">
        
                                <div class="table-responsive">
                                    <table id="datableButton" class="table thead-light table-striped mb-0 w-100 sortable">
                                        <thead class="table-light">
                                            <tr>
                                                <th>No.</th>
                                                <th>Trx No.</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Currency</th>
                                                <th>Unit</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($requests as $key => $transaction)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $transaction->request_type ?? '' }}</td>
                                                    <td>{{ $transaction->date_approved ?? 'N/A' }}</td>
                                                    <td>{{ $transaction->total_amount }}</td>
                                                    <td>{{ $transaction->currency->code ?? 'UGX' }} @ {{ $transaction->rate }}
                                                    </td>
                                                    <td><span
                                                            class="badge badge-md badge-soft-purple">{{ $transaction->status }}</span>
                                                    </td>
                                                    <td class="table-action">
        
                                                        <a href="{{ URL('finance-main_transaction_view', $transaction->id) }}"
                                                            class="btn btn-sm btn-outline-secondary">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
        
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> <!-- end preview-->
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->
                @endif
        
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">Recent Transactions</h4>
                                </div><!--end col-->
                                <div class="col-auto">
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            This Month<i class="las la-angle-down ms-1"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">Today</a>
                                            <a class="dropdown-item" href="#">Last Week</a>
                                            <a class="dropdown-item" href="#">Last Month</a>
                                            <a class="dropdown-item" href="#">This Year</a>
                                        </div>
                                    </div>
                                </div><!--end col-->
                            </div> <!--end row-->
                        </div><!--end card-header-->
                        <div class="card-body">
        
                            <div class="table-responsive">
                                <table id="datableButton" class="table thead-light table-striped mb-0 w-100 sortable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>Trx No.</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Currency</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $key => $transaction)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $transaction->trx_no ?? '' }}</td>
                                                <td>{{ $transaction->trx_date ?? 'N/A' }}</td>
                                                <td>{{ $transaction->total_amount }}</td>
                                                <td>{{ $transaction->currency->code ?? 'UGX' }} @ {{ $transaction->rate }}</td>
                                                <td><span
                                                        class="badge badge-md badge-soft-purple">{{ $transaction->status }}</span>
                                                </td>
                                                <td class="table-action">
        
                                                    <a href="{{ URL('finance-main_transaction_view', $transaction->id) }}"
                                                        class="btn btn-sm btn-outline-secondary">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
        
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end preview-->
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div><!--end col-->
            </div><!--end row-->

        </div><!-- container -->
        @push('scripts')
        <script>
            var options = {
                stroke:{show:!0,width:2,colors:["transparent"]},
                legend:{show:!1,position:"bottom",horizontalAlign:"center",verticalAlign:"middle",floating:!1,fontSize:"14px",offsetX:0,offsetY:5},
                series: [
                    @foreach ($invoice_chart as $value)
                        {{ $value->inv_count }},
                    @endforeach
                ],
                colors: ["#097A3A","#2a76f4","#67c8ff"],
                chart: {
                    width: '80%',
                    type: 'pie',
                },
                labels: [
                    @foreach ($invoice_chart as $value)
                        "{{ $value->status }}",
                    @endforeach
                ],
    
                plotOptions: {
                    pie: {
                        dataLabels: {
                            offset: -5
                        },
    
                        fill: {
                            type: 'gradient',
                        },
                    }
                },
                dataLabels: {
                    formatter(val, opts) {
                        const name = opts.w.globals.labels[opts.seriesIndex]
                        return [name, val.toFixed(1) + '%']
                    }
                },
                responsive:[{breakpoint:600,options:{plotOptions:{donut:{customScale:.2}},chart:{height:200},legend:{show:!1}}}],
            };
    
            var chart = new ApexCharts(document.querySelector("#invoice_report"), options);
            chart.render();
    
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
