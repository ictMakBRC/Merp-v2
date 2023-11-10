<div>
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ $requestable->name }}</a>
                        </li><!--end nav-item-->
                        <li class="breadcrumb-item"><a href="#">Finance</a>
                        </li><!--end nav-item-->
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
                <h4 class="page-title">Dashboard</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Unit : {{ $requestable->name }}</h4>
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
                    <div class="row mb-3">
                        <div class="col col-md">
                            <div class="media">
                                <i class="align-self-center icon-lg text-secondary fas fa-briefcase"></i>
                                <div class="media-body align-self-center ms-2">
                                    <h6 class="mt-0 mb-1 font-16">Estimated Income This FY <i
                                            class="fas fa-check text-success"></i></h6>
                                    <h6 class="mt-0 mb-1 font-16">Estimated Expense This FY <i
                                            class="far fa-minus-square text-info"></i></h6>
                                </div><!--end media body-->
                            </div>
                        </div><!--end col-->
                        <div class="col-md-auto">
                            <button type="button" class="btn btn-sm btn-de-secondary px-3 mt-2">More details</button>
                        </div><!--end col-->
                    </div> <!--end row-->
                    <div>
                        <div wire:ignore id="transactions_report" class="apex-charts"></div>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col text-center">
                                    <span class="h4">60k</span>
                                    <h6 class="text-uppercase text-muted mt-2 m-0">Total Requests</h6>
                                </div><!--end col-->
                            </div> <!-- end row -->
                        </div><!--end card-body-->
                    </div> <!--end card-body-->
                </div><!--end col-->
                <div class="col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col text-center">
                                    <span class="h4">10k</span>
                                    <h6 class="text-uppercase text-muted mt-2 m-0">Requests Pending</h6>
                                </div><!--end col-->
                            </div> <!-- end row -->
                        </div><!--end card-body-->
                    </div> <!--end card-body-->
                </div><!--end col-->
                <div class="col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col text-center">
                                    <span class="h4">720</span>
                                    <h6 class="text-uppercase text-muted mt-2 m-0">Requests Approved</h6>
                                </div><!--end col-->
                            </div> <!-- end row -->
                        </div><!--end card-body-->
                    </div> <!--end card-body-->
                </div><!--end col-->
                <div class="col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col text-center">
                                    <span class="h4">964</span>
                                    <h6 class="text-uppercase text-muted mt-2 m-0">Requests Paid</h6>
                                </div><!--end col-->
                            </div> <!-- end row -->
                        </div><!--end card-body-->
                    </div> <!--end card-->
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end col-->
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Invoice Status</h4>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="apex-charts" wire:ignore id="invoice_report"></div>
                    <div class="text-center mt-4">
                        <h6 class="bg-light-alt py-3 px-2 mb-0">
                            <i data-feather="calendar" class="align-self-center icon-xs me-1"></i>
                            01 January 2021 to 31 December 2021
                        </h6>
                    </div>
                </div><!--end card-body-->
            </div><!--end  card-->
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Social Report</h4>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <ul class="list-unstyled">
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
                        <li class="list-item mb-2">
                            <i class="fas fa-play {{ $color  }} me-2"></i>{{ $invoice->status }}: @moneyFormat($invoice->amount)
                        </li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn btn-sm btn-de-primary">View Details <i class="mdi mdi-arrow-right"></i></button>
                </div><!--end card-body-->
            </div><!--end card-body-->
        </div><!--end col-->
    </div><!--end row-->

    <div class="row">
        @if (count($incomes) > 0)

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
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($incomes as $key => $transaction)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $transaction->trx_no ?? '' }}</td>
                                            <td>{{ $transaction->trx_date ?? 'N/A' }}</td>
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
                            <h4 class="card-title">Expense Transactions</h4>
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
                                @foreach ($expenses as $key => $transaction)
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
    {{ $transactions_chart }}
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
</div><!-- container -->
