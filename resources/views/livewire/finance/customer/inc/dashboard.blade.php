<div>
    @if ($requestable)
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
                        <div>
                            <div wire:ignore id="transactions_report" class="apex-charts"></div>
                        </div>
                    </div><!--end card-body-->
                </div><!--end card-->
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

                    </div><!--end card-body-->
                </div><!--end  card-->
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">Invoice Report</h4>
                            </div><!--end col-->
                        </div> <!--end row-->
                    </div><!--end card-header-->
                    <div class="card-body">
                        <ul class="list-unstyled">
                            @foreach ($invoice_amounts as $invoice)
                                @php
                                    if ($invoice->status == 'Paid') {
                                        $color = 'text-primary';
                                    } elseif ($invoice->status == 'Partially Paid') {
                                        $color = 'text-info';
                                    } elseif ($invoice->status == 'Approved') {
                                        $color = 'text-warning';
                                    } else {
                                        $color = 'text-secondary';
                                    }
                                @endphp
                                <li class="list-item mb-2">
                                    <i class="fas fa-play {{ $color }} me-2"></i>{{ $invoice->status }}:
                                    @moneyFormat($invoice->amount)
                                </li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn btn-sm btn-de-primary">View Details <i
                                class="mdi mdi-arrow-right"></i></button>
                    </div><!--end card-body-->
                </div><!--end card-body-->
            </div><!--end col-->
        </div><!--end row-->

        <div class="row">

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
        </div><!--end row-->
        @push('scripts')
            <script>
                var options = {
                    stroke: {
                        show: !0,
                        width: 2,
                        colors: ["transparent"]
                    },
                    legend: {
                        show: !1,
                        position: "bottom",
                        horizontalAlign: "center",
                        verticalAlign: "middle",
                        floating: !1,
                        fontSize: "14px",
                        offsetX: 0,
                        offsetY: 5
                    },
                    series: [
                        @foreach ($invoice_chart as $value)
                            {{ $value->inv_count }},
                        @endforeach
                    ],
                    colors: ["#097A3A", "#2a76f4", "#67c8ff"],
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
                    responsive: [{
                        breakpoint: 600,
                        options: {
                            plotOptions: {
                                donut: {
                                    customScale: .2
                                }
                            },
                            chart: {
                                height: 200
                            },
                            legend: {
                                show: !1
                            }
                        }
                    }],
                };

                var chart = new ApexCharts(document.querySelector("#invoice_report"), options);
                chart.render();

                var options2 = {
                    series: [{
                            name: 'Total Payments',
                            data: [
                                @foreach ($transactions_chart as $data)
                                    // {{ $data->total_expense }},
                                    "{{ sprintf('%.2f', $data->total_amount) }}",
                                @endforeach
                            ]
                        }

                    ],
                    colors: ['#2A76F4', '#67C8FF', '#951F39', '#33C481'],
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
    @else
        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-5 mx-auto">
                            <div class="card">
                                <div class="card-body p-0 auth-header-box">
                                    <div class="text-center p-3">
                                        <a href="index.html" class="logo logo-admin">
                                            <img src="assets/images/logo-sm.png" height="50" alt="logo"
                                                class="auth-logo">
                                        </a>
                                        <h4 class="mt-3 mb-1 fw-semibold text-white font-18">Oops! Sorry unit not found
                                        </h4>
                                        <p class="text-muted  mb-0">Back to dashboard.</p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="ex-page-content text-center">
                                        <img src="assets/images/error.svg" alt="0" class=""
                                            height="170">
                                        <h1 class="mt-5 mb-4">404!</h1>
                                        <h5 class="font-16 text-muted mb-5">Somthing went wrong</h5>
                                    </div>
                                    <a class="btn btn-primary w-100" href="index.html">Back to Dashboard <i
                                            class="fas fa-redo ml-1"></i></a>
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end card-body-->
            </div><!--end col-->
        </div><!--end row-->
    @endif
</div><!-- container -->
